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
     * Halaman daftar kelompok ujian (exam-list)
     * DULU: render camaba.exam
     * SEKARANG: render camaba.exam-list
     */
    public function index()
{
    $user = auth()->user();

    $schedules = ExamSchedule::whereHas('exams', function ($query) use ($user) {
        $query->where('user_id', $user->id)
              ->whereIn('status', ['approved', 'in_progress', 'completed']);
    })
    ->orderBy('id', 'desc')
    ->get();

    $questionGroups = QuestionGroup::where('type', 'PSI')
        ->orderBy('id', 'asc')
        ->get();

    // ambil exam aktif user
    $exam = Exam::where('user_id', $user->id) 
        ->whereIn('status', ['approved', 'in_progress', 'completed'])
        ->latest()
        ->first();

    $completedTests = [
        'pengetahuan_umum' => false,
        'psikotes_1' => false,
        'psikotes_2' => false,
        'psikotes_3' => false,
        'psikotes_4' => false,
    ];

    if ($exam) {

        // cek apakah sudah pernah jawab soal PU
        $completedTests['pengetahuan_umum'] =
            ExamAnswer::where('exam_id', $exam->id)
            ->whereIn('question_id', function ($q) {
                $q->select('id')
                  ->from('questions')
                  ->whereIn('question_group_id', function ($qq) {
                      $qq->select('id')
                         ->from('question_groups')
                         ->where('type', 'PU');
                  });
            })
            ->exists();

        // cek psikotes 1–4
        $psiGroups = QuestionGroup::where('type', 'PSI')
            ->orderBy('id', 'asc')
            ->take(4)
            ->pluck('id');

        foreach ($psiGroups as $index => $groupId) {

            $completedTests['psikotes_' . ($index + 1)] =
                ExamAnswer::where('exam_id', $exam->id)
                ->whereIn('question_id', function ($q) use ($groupId) {
                    $q->select('id')
                      ->from('questions')
                      ->where('question_group_id', $groupId);
                })
                ->exists();
        }
    }

    return view('camaba.exam.index', compact(
        'schedules',
        'questionGroups',
        'completedTests'
    ));
}

    /**
     * Halaman konfirmasi sebelum mulai ujian (exam.blade.php yang lama)
     * Dipanggil saat user klik "Kerjakan" di exam-list
     * 
     * Query param:
     *   ?group=pu          → Pengetahuan Umum (tidak ada video)
     *   ?group=psi&tes=1   → Psikotes Tes 1 (ada video tutorial)
     *   ?group=psi&tes=2   → Psikotes Tes 2, dst.
     */
    public function showExam($group, $tes = null)
{
    $user = auth()->user();

    $schedule = ExamSchedule::whereHas('exams', function ($query) use ($user) {
    $query->where('user_id', $user->id)
          ->whereIn('status', ['approved', 'in_progress', 'completed']);
    })
    ->latest()
    ->first();

    $isPsikotes = ($group === 'psi');

    if ($isPsikotes && $tes) {

        $groupData = QuestionGroup::where('type', 'PSI')
            ->orderBy('id', 'asc')
            ->skip((int)$tes - 1)
            ->first();

        $examLabel = 'Psikotes Tes ' . $tes;

    } else {

        $groupData = QuestionGroup::where('type', 'PU')->first();

        $examLabel = 'Pengetahuan Umum';
    }

    $groupId = $groupData ? $groupData->id : null;

    $tutorialVideoUrl = null;

    if ($groupData) {

        $question = Question::where('question_group_id', $groupData->id)
            ->whereNotNull('video_tutorial')
            ->where('video_tutorial', '!=', '')
            ->first();

        if ($question && $question->video_tutorial) {

            $url = $question->video_tutorial;

            if (preg_match('/\/file\/d\/([a-zA-Z0-9_-]+)/', $url, $matches)) {

                $tutorialVideoUrl =
                    'https://drive.google.com/file/d/' .
                    $matches[1] .
                    '/preview';

            } else {

                $tutorialVideoUrl =
                    str_replace('/view', '/preview', $url);
            }
        }
    }

    return view('camaba.exam.start', compact(
        'schedule',
        'isPsikotes',
        'examLabel',
        'tutorialVideoUrl',
        'groupId'
    ));
}

    /**
     * Saat camaba klik "Mulai Ujian"
     * ⚠️ TIDAK DIUBAH SAMA SEKALI
     */
    public function start()
{
    $user = auth()->user();

    $examRequest = Exam::where('user_id', $user->id)
    ->whereIn('status', ['approved', 'in_progress', 'completed'])
    ->whereHas('examSchedule', function ($q) {
        $q->where('status', 'active')
          ->whereDate('start_date', '<=', now())
          ->whereDate('end_date', '>=', now());
    })
    ->latest()
    ->first();

    if (!$examRequest) {
        return back()->with('error', 'Anda belum memiliki jadwal ujian yang disetujui atau masa ujian tidak aktif.');
    }

    $exam = Exam::where('user_id', $user->id)
        ->where('exam_schedule_id', $examRequest->exam_schedule_id)
        ->whereIn('status', ['in_progress', 'completed'])
        ->first();

    if ($exam && $exam->status === 'completed') {

        // jangan redirect success dulu karena mungkin masih ada tes lain
        $exam->update([
            'status' => 'in_progress'
        ]);
    }

    if (!$exam) {

        $examRequest->update([
            'status' => 'in_progress',
            'start_time' => now()
        ]);

        \App\Models\Notification::where('user_id', $user->id)
            ->where('message', 'like', '%ujian%')
            ->where('is_read', false)
            ->update(['is_read' => true]);

        $exam = $examRequest;
    }

    // validasi group_id wajib ada
    if (!request('group_id')) {
        return back()->with('error', 'Group soal tidak ditemukan.');
    }

    // redirect ke halaman soal
    return redirect()->route('camaba.exam.questions', [
        'examId' => $exam->id,
        'groupId' => request('group_id')
    ]);
}
    /**
     * Tampilan halaman soal.
     * ⚠️ TIDAK DIUBAH SAMA SEKALI
     */
    public function questions($examId, $groupId)
{
    $exam = Exam::where('id', $examId)
        ->where('user_id', auth()->id())
        ->firstOrFail();

    if ($exam->status === 'completed') {
        return redirect()
            ->route('exam.success', ['examId' => $exam->id])
            ->with('error', 'Ujian sudah diselesaikan. Anda tidak bisa membuka soal lagi.');
    }

    $examSchedule = ExamSchedule::findOrFail($exam->exam_schedule_id);

    $questions = Question::with('group')
        ->where('question_group_id', $groupId)
        ->get()
        ->map(function ($question) {

            $choices = $question->answer_choices;
            $type = $question->group ? $question->group->type : 'PU';

            $formatted = [
                'id' => $question->id,
                'question_text' => $question->question_text,
                'question_image' => $question->question_image,
                'group' => $question->group,
            ];

            foreach (['A','B','C','D','E'] as $letter) {

    $key = 'option_' . strtolower($letter);
    $imageKey = $key . '_image';

    if (isset($choices[$letter])) {

        if ($type == 'PSI' && is_array($choices[$letter])) {

            $formatted[$key] = $choices[$letter]['text'] ?? '';
            $formatted[$imageKey] = $choices[$letter]['image'] ?? null;

        } else {

            $formatted[$key] = $choices[$letter];
            $formatted[$imageKey] = null;

        }

    } else {

        $formatted[$key] = '';
        $formatted[$imageKey] = null;

    }
}

            return (object) $formatted;
        })
        ->shuffle();

    $totalQuestions = $questions->count();

    $answeredCount = ExamAnswer::where('exam_id', $exam->id)
        ->whereIn('question_id', $questions->pluck('id'))
        ->count();

    $savedAnswers = ExamAnswer::where('exam_id', $exam->id)
        ->pluck('selected_answer', 'question_id')
        ->toArray();

    $timeRemaining = $exam->examSchedule->duration * 60;

    return view('camaba.exam.questions', [
        'exam'            => $exam,
        'examSchedule'    => $examSchedule,
        'questions'       => $questions,
        'totalQuestions'  => $totalQuestions,
        'answeredCount'   => $answeredCount,
        'unansweredCount' => $totalQuestions - $answeredCount,
        'savedAnswers'    => $savedAnswers,
        'timeRemaining'   => $timeRemaining,
        'groupId'         => $groupId
    ]);
}

    /**
     * Submit semua jawaban.
     * ⚠️ TIDAK DIUBAH SAMA SEKALI
     */
    public function submit(Request $request, $examId)
    {
        $user = auth()->user();

        $exam = Exam::where('id', $examId)
            ->where('user_id', $user->id)
            ->firstOrFail();

        if ($exam->status === 'completed') {
            return redirect()->route('exam.success', $exam->id)
                ->with('error', 'Ujian ini sudah selesai.');
        }

        foreach ($request->answers as $questionId => $answer) {

            $question = Question::with('group')->find($questionId);
            if (!$question) continue;

            $type  = $question->group ? $question->group->type : 'PU';
            $score = 0;

            if ($type == 'PU') {
                if (strtoupper($answer) == strtoupper($question->correct_answer)) {
                    $score = floatval($question->score);
                }
            }

            if ($type == 'PSI') {
                $choices  = $question->answer_choices;
                $selected = strtoupper($answer);
                if (isset($choices[$selected]['score'])) {
                    $score = floatval($choices[$selected]['score']);
                }
            }

            ExamAnswer::updateOrCreate(
                ['exam_id' => $exam->id, 'question_id' => $questionId],
                ['selected_answer' => $answer, 'score' => $score]
            );
        }

        $answers   = ExamAnswer::where('exam_id', $exam->id)->get();
        $scorePU   = 0;
        $scorePSI  = 0;
        $correctPU = 0;
        $totalPU   = 0;

        foreach ($answers as $ans) {
            $question = Question::with('group')->find($ans->question_id);
            if (!$question) continue;

            $type = $question->group ? $question->group->type : 'PU';

            if ($type == 'PU') {
                $totalPU++;
                if (strtoupper($ans->selected_answer) == strtoupper($question->correct_answer)) {
                    $correctPU++;
                }
            }

            if ($type == 'PSI') {
                $scorePSI += floatval($ans->score);
            }
        }

        if ($totalPU > 0) {
            $scorePU = $correctPU * (100 / $totalPU);
        }

        $iq = $this->convertIQ(round($scorePSI));

        $exam->update([
            'status'      => 'completed',
            'finished_at' => now(),
            'score_pu'    => round($scorePU, 2),
            'score_psi'   => round($scorePSI, 2),
            'iq'          => $iq
        ]);

      return redirect()->route('exam.success', [
    'examId' => $exam->id
])->with('group_id', $request->group_id);

    }
    private function convertIQ($score)
{
    $map = [
        16=>66,17=>70,18=>73,19=>76,20=>79,
        21=>81,22=>83,23=>84,24=>86,25=>87,
        26=>89,27=>91,28=>92,29=>94,30=>96,
        31=>97,32=>99,33=>102,34=>105,35=>107,
        36=>109,37=>118,38=>123,39=>127,40=>133,41=>139
    ];

    return $map[$score] ?? null;
}

    /**
     * Halaman hasil ujian camaba.
     * ⚠️ TIDAK DIUBAH SAMA SEKALI
     */
   public function success(Request $request, $examId)
{
    $groupId = session('group_id'); // FIX DISINI

    $exam = Exam::findOrFail($examId);

    $totalQuestions = Question::where('question_group_id', $groupId)->count();

    $answeredQuestions = ExamAnswer::where('exam_id', $examId)
        ->whereIn('question_id', function ($query) use ($groupId) {
            $query->select('id')
                  ->from('questions')
                  ->where('question_group_id', $groupId);
        })
        ->count();

    return view('camaba.exam.success', compact(
        'exam',
        'totalQuestions',
        'answeredQuestions'
    ));
}
}