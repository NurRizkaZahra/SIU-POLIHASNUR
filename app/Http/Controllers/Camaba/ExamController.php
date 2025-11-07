<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSchedule;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ExamController extends Controller
{
    /**
     * Halaman utama ujian (form sebelum mulai ujian)
     * Route: GET /camaba/exam
     * Name: camaba.exam
     */
    public function index()
    {
        $user = Auth::user();
        
        // Ambil jadwal ujian aktif untuk user ini
        $activeExam = Exam::with('examSchedule')
            ->where('user_id', $user->id)
            ->whereIn('status', ['pending', 'approved'])
            ->whereHas('examSchedule', function($query) {
                $query->where('status', 'active')
                      ->where('end_date', '>=', now());
            })
            ->first();
        
        // Jika tidak ada ujian aktif, redirect ke jadwal ujian
        if (!$activeExam) {
            return redirect()->route('camaba.exam-schedule')
                ->with('error', 'Tidak ada ujian yang tersedia saat ini.');
        }
        
        return view('camaba.exam', compact('user', 'activeExam'));
    }
    
    /**
     * Mulai ujian
     * Route: POST /exam/start
     * Name: ujian.start
     */
    public function start(Request $request)
    {
        $user = Auth::user();
        
        // Validasi
        $request->validate([
            'exam_schedule_id' => 'required|exists:exam_schedules,id'
        ]);
        
        // Cek apakah user sudah terdaftar di ujian ini
        $exam = Exam::where('user_id', $user->id)
            ->where('exam_schedule_id', $request->exam_schedule_id)
            ->whereIn('status', ['pending', 'approved'])
            ->first();
        
        if (!$exam) {
            return redirect()->back()
                ->with('error', 'Anda tidak terdaftar untuk ujian ini.');
        }
        
        // Cek apakah ujian sudah dimulai sebelumnya
        if ($exam->started_at) {
            return redirect()->route('ujian.questions', $exam->exam_schedule_id);
        }
        
        // Update waktu mulai ujian
        $exam->update([
            'started_at' => now(),
            'status' => 'in_progress'
        ]);
        
        return redirect()->route('ujian.questions', $exam->exam_schedule_id)
            ->with('success', 'Ujian dimulai. Selamat mengerjakan!');
    }
    
    /**
     * Halaman soal ujian
     * Route: GET /exam/{examScheduleId}/questions
     * Name: ujian.questions
     */
    public function questions($examScheduleId)
    {
        $user = Auth::user();
        
        // Ambil data ujian dengan soal-soal
        $exam = Exam::with(['examSchedule'])
            ->where('user_id', $user->id)
            ->where('exam_schedule_id', $examScheduleId)
            ->firstOrFail();
        
        // Cek apakah ujian sudah dimulai
        if (!$exam->started_at) {
            return redirect()->route('camaba.exam')
                ->with('error', 'Silakan mulai ujian terlebih dahulu.');
        }
        
        // Cek apakah ujian sudah selesai
        if ($exam->finished_at) {
            return redirect()->route('ujian.result', $examScheduleId)
                ->with('info', 'Ujian sudah selesai.');
        }
        
        // Ambil soal-soal (sesuaikan dengan struktur database Anda)
        $questions = DB::table('questions')
            ->where('exam_schedule_id', $examScheduleId)
            ->get();
        
        // Hitung waktu tersisa
        $examSchedule = $exam->examSchedule;
        $duration = $examSchedule->duration ?? 60; // dalam menit
        $startTime = $exam->started_at;
        $endTime = $startTime->copy()->addMinutes($duration);
        $timeRemaining = now()->diffInSeconds($endTime, false);
        
        // Jika waktu habis, otomatis submit
        if ($timeRemaining <= 0) {
            return $this->autoSubmit($exam);
        }
        
        // Ambil jawaban yang sudah ada (jika tabel exam_answers sudah ada)
        $answers = [];
        if (DB::getSchemaBuilder()->hasTable('exam_answers')) {
            $answers = DB::table('exam_answers')
                ->where('exam_id', $exam->id)
                ->pluck('answer', 'question_id')
                ->toArray();
        }
        
        return view('camaba.exam.questions', compact('exam', 'examSchedule', 'questions', 'timeRemaining', 'answers'));
    }
    
    /**
     * Simpan jawaban (AJAX)
     * Route: POST /exam/{examScheduleId}/answer
     * Name: ujian.answer
     */
    public function answer(Request $request, $examScheduleId)
    {
        $user = Auth::user();
        
        $request->validate([
            'question_id' => 'required|exists:questions,id',
            'answer' => 'required'
        ]);
        
        $exam = Exam::where('user_id', $user->id)
            ->where('exam_schedule_id', $examScheduleId)
            ->firstOrFail();
        
        // Simpan atau update jawaban
        DB::table('exam_answers')->updateOrInsert(
            [
                'exam_id' => $exam->id,
                'question_id' => $request->question_id
            ],
            [
                'answer' => $request->answer,
                'answered_at' => now(),
                'updated_at' => now()
            ]
        );
        
        return response()->json([
            'success' => true,
            'message' => 'Jawaban tersimpan'
        ]);
    }
    
    /**
     * Submit ujian
     * Route: POST /exam/{examScheduleId}/submit
     * Name: ujian.submit
     */
    public function submit(Request $request, $examScheduleId)
    {
        $user = Auth::user();
        
        $exam = Exam::where('user_id', $user->id)
            ->where('exam_schedule_id', $examScheduleId)
            ->firstOrFail();
        
        DB::beginTransaction();
        try {
            // Hitung nilai
            $score = $this->calculateScore($exam);
            
            // Update status ujian
            $exam->update([
                'finished_at' => now(),
                'status' => 'completed',
                'score' => $score
            ]);
            
            DB::commit();
            
            return redirect()->route('ujian.result', $examScheduleId)
                ->with('success', 'Ujian berhasil diselesaikan!');
                
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()
                ->with('error', 'Terjadi kesalahan saat submit ujian: ' . $e->getMessage());
        }
    }
    
    /**
     * Hasil ujian
     * Route: GET /exam/{examScheduleId}/result
     * Name: ujian.result
     */
    public function result($examScheduleId)
    {
        $user = Auth::user();
        
        $exam = Exam::with(['examSchedule'])
            ->where('user_id', $user->id)
            ->where('exam_schedule_id', $examScheduleId)
            ->firstOrFail();
        
        if (!$exam->finished_at) {
            return redirect()->route('ujian.questions', $examScheduleId)
                ->with('error', 'Ujian belum selesai.');
        }
        
        // Ambil jawaban user
        $answers = DB::table('exam_answers')
            ->where('exam_id', $exam->id)
            ->get();
        
        return view('camaba.exam.result', compact('exam', 'answers'));
    }
    
    /**
     * Auto submit jika waktu habis
     * Private method
     */
    private function autoSubmit($exam)
    {
        $score = $this->calculateScore($exam);
        
        $exam->update([
            'finished_at' => now(),
            'status' => 'completed',
            'score' => $score
        ]);
        
        return redirect()->route('ujian.result', $exam->exam_schedule_id)
            ->with('warning', 'Waktu ujian habis. Ujian otomatis disubmit.');
    }
    
    /**
     * Hitung nilai ujian
     * Private method
     */
    private function calculateScore($exam)
    {
        // Cek apakah tabel exam_answers ada
        if (!DB::getSchemaBuilder()->hasTable('exam_answers')) {
            return 0;
        }
        
        $answers = DB::table('exam_answers')
            ->where('exam_id', $exam->id)
            ->get();
        
        $correctAnswers = 0;
        $totalQuestions = $answers->count();
        
        foreach ($answers as $answer) {
            // Ambil jawaban benar dari tabel questions
            $question = DB::table('questions')
                ->where('id', $answer->question_id)
                ->first();
            
            if ($question && $answer->answer == $question->correct_answer) {
                $correctAnswers++;
            }
        }
        
        // Hitung score (dari 100)
        $score = $totalQuestions > 0 
            ? round(($correctAnswers / $totalQuestions) * 100, 2)
            : 0;
        
        return $score;
    }
}