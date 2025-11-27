<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule;
use App\Models\Exam;
use App\Models\Question;
use App\Models\QuestionGroup;
use App\Models\ExamAnswer;

class ExamController extends Controller
{
    /**
     * Halaman daftar jadwal ujian camaba
     */
public function index()
{
    $schedules = ExamSchedule::orderBy('id', 'desc')->get();
    return view('camaba.exam', compact('schedules'));
}
    /**
     * Saat camaba klik "Mulai Ujian"
     */
    public function start(Request $request)
    {
        $request->validate([
            'exam_schedule_id' => 'required|exists:exam_schedules,id'
        ]);

    $schedule = ExamSchedule::findOrFail($request->exam_schedule_id);
    $now = now();

    if ($now->lt($schedule->start_date)) {
        return back()->with('error', 'Ujian belum dibuka.');
    }

    if ($now->gt($schedule->end_date)) {
      return back()->with('error', 'Masa ujian telah berakhir.');
    }

        $user = auth()->user();

        // Cari exam jika user pernah memulai
        $exam = Exam::where('user_id', $user->id)
                    ->where('exam_schedule_id', $request->exam_schedule_id)
                    ->first();

        //🚫 BLOK kalau sudah selesai
        if ($exam && $exam->status === 'completed') {
        return redirect()
         ->route('exam.success', $exam->id)
         ->with('error', 'Anda sudah menyelesaikan ujian ini.');
       }

        if (!$exam) {
            // Buat exam baru
            $exam = Exam::create([
                'user_id'           => $user->id,
                'exam_schedule_id'  => $request->exam_schedule_id,
                'status'            => 'in_progress',
                'start_time'        => now()
            ]);
        }
        // Hapus jawaban lama biar bisa testing
        ExamAnswer::where('exam_id', $exam->id)->delete();

        // Redirect ke soal, menggunakan EXAM ID
        return redirect()
            ->route('exam.questions', $exam->id)
            ->with('success', 'Ujian dimulai. Selamat mengerjakan!');
    }

    /**
     * Tampilan halaman soal.
     */
  public function questions($examId)
{
    $exam = Exam::where('id', $examId)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    $examSchedule = ExamSchedule::findOrFail($exam->exam_schedule_id);

    // ================================
    // 🔹 Ambil SEMUA soal (PU + PSI) dengan relasi group
    // ================================
    $allQuestions = Question::with('group')
        ->get()
        ->map(function($question) {
            // Parse answer_choices
            $choices = $question->answer_choices; // sudah auto-cast jadi array
            
            // Tentukan tipe soal
            $type = $question->group ? $question->group->type : 'PU';
            
            // Format data untuk frontend
            $formatted = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'group' => $question->group, // Relasi group lengkap (untuk video, type, dll)
            ];
            
            // Extract options dari answer_choices
            foreach(['A', 'B', 'C', 'D', 'E'] as $letter) {
                $key = 'option_' . strtolower($letter);
                
                if (isset($choices[$letter])) {
                    if ($type == 'PSI' && is_array($choices[$letter])) {
                        // PSI: ambil dari nested object {"text": "...", "score": 3}
                        $formatted[$key] = $choices[$letter]['text'] ?? '';
                    } else {
                        // PU: langsung string "jawaban"
                        $formatted[$key] = $choices[$letter];
                    }
                } else {
                    $formatted[$key] = ''; // Fallback jika tidak ada
                }
            }
            
            return (object) $formatted; // Convert ke object biar sama dengan original
        });

    // ================================
    // 🔹 Pisahkan PU dan PSI untuk sorting
    // ================================
    $questionsPU = $allQuestions->filter(function($q) {
        return !$q->group || $q->group->type == 'PU';
    })->shuffle(); // Acak PU

    $questionsPSI = $allQuestions->filter(function($q) {
        return $q->group && $q->group->type == 'PSI';
    })->groupBy('group.id'); // Group berdasarkan grup PSI

    // ================================
    // 🔹 Gabungkan: PU dulu, lalu PSI per grup
    // ================================
    $questions = collect();

    // Tambah semua PU
    foreach ($questionsPU as $q) {
        $questions->push($q);
    }

    // Tambah PSI berurutan per grup
    foreach ($questionsPSI as $groupId => $groupQuestions) {
        $isFirstInGroup = true; //Flag untuk soal pertama

        foreach ($groupQuestions->shuffle() as $q) {
            //Tambahkan flag is_first_in_group // Acak dalam grup
            $q->is_first_in_group = $isFirstInGroup;

            $questions->push($q);

            $isFirstInGroup = false;
        }
    }

    // ================================
    // 🔹 Statistik
    // ================================
    $totalQuestions = $questions->count();
    $answeredCount = ExamAnswer::where('exam_id', $exam->id)->count();
    $unansweredCount = $totalQuestions - $answeredCount;

    // ================================
    // 🔹 Load jawaban tersimpan
    // ================================
    $savedAnswers = ExamAnswer::where('exam_id', $exam->id)
        ->pluck('selected_answer', 'question_id')
        ->toArray();

    // ================================
    // 🔹 Waktu tersisa
    // ================================
    $timeRemaining = $exam->examSchedule->duration * 60;

    return view('camaba.exam.questions', [
        'exam'             => $exam,
        'examSchedule'     => $examSchedule,
        'questions'        => $questions, // ← Collection sudah diformat!
        'totalQuestions'   => $totalQuestions,
        'answeredCount'    => $answeredCount,
        'unansweredCount'  => $unansweredCount,
        'savedAnswers'     => $savedAnswers,
        'timeRemaining'    => $timeRemaining,
    ]);
}

    /**
     * Submit semua jawaban.
     */
    public function submit(Request $request, $examId)
    {
        $user = auth()->user();

        $exam = Exam::where('id', $examId)
            ->where('user_id', $user->id)
            ->firstOrFail();

    // ================================
    // 1. SIMPAN JAWABAN + SKOR PER SOAL
    // ================================
    foreach ($request->answers as $questionId => $answer) {

        $question = Question::with('group')->find($questionId);
        if (!$question) continue;

        $type = $question->group ? $question->group->type : 'PU';
        $score = 0;

        // ------------ PU ------------
        if ($type == 'PU') {
            if (strtoupper($answer) == strtoupper($question->correct_answer)) {
                $score = floatval($question->score); //ambil dari db
            }else{
                $score = 0; // benar = 1 poin (bisa diubah)
            }
        }

        // ------------ PSI ------------
        if ($type == 'PSI') {
            $choices = $question->answer_choices; // sudah array
            $selected = strtoupper($answer);

            if (isset($choices[$selected]['score'])) {
                $score = floatval($choices[$selected]['score']);
            }
        }

        ExamAnswer::updateOrCreate(
            [
                'exam_id' => $exam->id,
                'question_id' => $questionId,
            ],
            [
                'selected_answer' => $answer,
                'score' => $score, // <= WAJIB
            ]
        );
    }

    // ================================
    // 2. HITUNG TOTAL SCORE PU & PSI
    // ================================
    $answers = ExamAnswer::where('exam_id', $exam->id)->get();

    $scorePU = 0;
    $scorePSI = 0;

    $correctPU = 0;
    $totalPU = 0;

    foreach ($answers as $ans) {
        $question = Question::with('group')->find($ans->question_id);
        if (!$question) continue;

        $type = $question->group ? $question->group->type : 'PU';

        // ---- PU ----
        if ($type == 'PU') {
            $totalPU++;
            if (strtoupper($ans->selected_answer) == strtoupper($question->correct_answer)) {
                $correctPU++;
            }
        }

        // ---- PSI ----
        if ($type == 'PSI') {
            $scorePSI += floatval($ans->score);
        }
    }

    // Hitung nilai PU dalam skala 100
    if ($totalPU > 0) {
        $scorePU = $correctPU * (100 / $totalPU);
    }

    // ================================
    // 3. SIMPAN KE TABEL exams
    // ================================
    $exam->update([
        'status' => 'completed',
       // 'end_time' => now(),//
        'finished_at' => now(),
        'score_pu' => round($scorePU, 2),
        'score_psi' => round($scorePSI, 2),
    ]);

    return redirect()->route('exam.success', $exam->id)
        ->with('success', 'Ujian telah diselesaikan. Terima kasih!');
}
    /**
     * Halaman hasil ujian camaba.
     */
    public function success($examId)
    {
        $user = auth()->user();

        $exam = Exam::with(['answers', 'examSchedule'])
            ->where('id', $examId)
            ->where('user_id', $user->id)
            ->where('status', 'completed')
            ->firstOrFail();

            // Hitung statistik
            $totalQuestions = Question::count();
            $answeredCount = ExamAnswer::where('exam_id', $exam->id)->count();

        return view('camaba.exam.success', compact('exam', 'totalQuestions', 'answeredCount'));
    }
}
