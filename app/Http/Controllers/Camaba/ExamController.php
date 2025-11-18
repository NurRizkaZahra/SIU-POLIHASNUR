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
        $schedules = ExamSchedule::orderBy('start_date', 'asc')->get();
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

        $user = auth()->user();

        // Cari exam jika user pernah memulai
        $exam = Exam::where('user_id', $user->id)
                    ->where('exam_schedule_id', $request->exam_schedule_id)
                    ->first();

        if (!$exam) {
            // Buat exam baru
            $exam = Exam::create([
                'user_id'           => $user->id,
                'exam_schedule_id'  => $request->exam_schedule_id,
                'status'            => 'in_progress',
                'start_time'        => now()
            ]);
        }

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
    // 🔹 Ambil soal PU (acak per soal)
    // ================================
    $questionsPU = Question::whereHas('group', function($q) {
        $q->where('type', 'PU');
    })->inRandomOrder()->get();

    // ================================
    // 🔹 Ambil soal PSI per grup acak
    // ================================
    $psiGroups = QuestionGroup::where('type', 'PSI')->get();
    $questionsPSI = [];

    foreach ($psiGroups as $group) {
        $questionsPSI[$group->id] = Question::where('question_group_id', $group->id)
            ->inRandomOrder()
            ->get();
    }

    // ================================
    // 🔹 Gabungkan PU + PSI jadi satu list
    // ================================
    $questions = collect();

    // Tambah semua PU
    foreach ($questionsPU as $q) {
        $questions->push($q);
    }

    // Tambah semua PSI berurutan per grup
    foreach ($psiGroups as $group) {
        foreach ($questionsPSI[$group->id] as $q) {
            $questions->push($q);
        }
    }

    // ================================
    // 🔹 Hitung statistik
    // ================================
    $totalQuestions = $questions->count();

    $answeredCount = ExamAnswer::where('exam_id', $exam->id)->count();
    $unansweredCount = $totalQuestions - $answeredCount;

    // ================================
    // 🔹 Load jawaban tersimpan (untuk resume)
    // ================================
    $savedAnswers = ExamAnswer::where('exam_id', $exam->id)
        ->pluck('selected_answer', 'question_id')
        ->toArray();

    // ================================
    // 🔹 Waktu tersisa
    // ================================
    $timeRemaining = $exam->examSchedule->duration * 60; // misal durasi dalam menit

    return view('camaba.exam.questions', [
        'exam'             => $exam,
        'examSchedule'     => $examSchedule,
        'questionsPU'      => $questionsPU,
        'questionsPSI'     => $questionsPSI,
        'psiGroups'        => $psiGroups,
        'questions'        => $questions,
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

        foreach ($request->answers as $questionId => $answer) {
            ExamAnswer::updateOrCreate(
                [
                    'exam_id' => $exam->id,
                    'question_id' => $questionId,
                ],
                [
                    'selected_answer' => $answer,
                ]
            );
        }

        // Set ujian selesai
        $exam->update([
            'status' => 'completed',
            'end_time' => now()
        ]);

        return redirect()->route('exam.result', $exam->id)
            ->with('success', 'Ujian telah diselesaikan. Terima kasih!');
    }

    /**
     * Halaman hasil ujian camaba.
     */
    public function result($examId)
    {
        $user = auth()->user();

        $exam = Exam::with(['answers', 'examSchedule'])
            ->where('id', $examId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        return view('camaba.exam.result', compact('exam'));
    }
}
