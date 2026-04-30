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

        /**
         * CEK PENGETAHUAN UMUM
         */
        $totalPU = Question::whereHas('group', function ($q) {
            $q->where('type', 'PU');
        })->count();

        $answeredPU = ExamAnswer::where('exam_id', $exam->id)
            ->whereIn('question_id', function ($q) {

                $q->select('id')
                  ->from('questions')
                  ->whereIn('question_group_id', function ($qq) {

                      $qq->select('id')
                         ->from('question_groups')
                         ->where('type', 'PU');

                  });

            })
            ->count();

        $completedTests['pengetahuan_umum'] =
            ($answeredPU == $totalPU);


        /**
         * CEK PSIKOTES 1–4
         */
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
                ->count()
                ==
                Question::where('question_group_id', $groupId)->count();
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

    // ambil exam yang valid
    $exam = Exam::where('user_id', $user->id)
        ->whereIn('status', ['approved', 'in_progress'])
        ->whereHas('examSchedule', function ($q) {
            $q->where('status', 'active')
              ->whereDate('start_date', '<=', now())
              ->whereDate('end_date', '>=', now());
        })
        ->latest()
        ->first();

    if (!$exam) {
        return back()->with('error', 'Anda belum memiliki jadwal ujian yang disetujui atau masa ujian tidak aktif.');
    }

    // ✅ kalau masih approved → mulai ujian
    if ($exam->status === 'approved') {
        $exam->update([
            'status' => 'in_progress',
            'started_at' => now()
        ]);

        // tandai notifikasi sudah dibaca
        \App\Models\Notification::where('user_id', $user->id)
            ->where('message', 'like', '%ujian%')
            ->where('is_read', false)
            ->update(['is_read' => true]);
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
            ->route('camaba.exam.success', ['examId' => $exam->id])
            ->with('error', 'Ujian sudah diselesaikan. Anda tidak bisa membuka soal lagi.');
    }

    $examSchedule = ExamSchedule::findOrFail($exam->exam_schedule_id);

    $questions = Question::with('group')
        ->where('question_group_id', $groupId)
        ->orderBy('id')
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

        });

    $totalQuestions = $questions->count();

    $answeredCount = ExamAnswer::where('exam_id', $exam->id)
        ->whereIn('question_id', $questions->pluck('id'))
        ->count();

    $savedAnswers = ExamAnswer::where('exam_id', $exam->id)
        ->pluck('selected_answer', 'question_id')
        ->toArray();

   $group = QuestionGroup::findOrFail($groupId);


/**
 * VALIDASI: PU wajib selesai sebelum PSI
 */
if ($group->type == 'PSI') {

    $totalPU = Question::whereHas('group', function ($q) {
        $q->where('type', 'PU');
    })->count();

    $answeredPU = ExamAnswer::where('exam_id', $exam->id)
    ->whereIn('question_id', function ($q) {

        $q->select('id')
          ->from('questions')
          ->whereIn('question_group_id', function ($qq) {

              $qq->select('id')
                 ->from('question_groups')
                 ->where('type', 'PU');

          });

    })
    ->count();

    if ($answeredPU < $totalPU) {

        return redirect()
            ->route('camaba.exam.index')
            ->with('error', 'Selesaikan Pengetahuan Umum terlebih dahulu.');
    }
}


/**
 * VALIDASI: harus selesaikan PSI sebelumnya dulu
 */
$previousGroup = QuestionGroup::where('type', $group->type)
    ->where('id', '<', $groupId)
    ->orderBy('id', 'desc')
    ->first();

if ($previousGroup) {

    $previousTotal = Question::where(
        'question_group_id',
        $previousGroup->id
    )->count();

    $previousAnswered = ExamAnswer::where('exam_id', $exam->id)
        ->whereIn('question_id', function ($q) use ($previousGroup) {

            $q->select('id')
              ->from('questions')
              ->where('question_group_id', $previousGroup->id);

        })
        ->count();

    if ($previousAnswered < $previousTotal) {

        return redirect()
            ->route('camaba.exam.index')
            ->with('error', 'Selesaikan tes sebelumnya terlebih dahulu.');
    }
}


$timeRemaining = $group->duration * 60;

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

    $groupId = $request->group_id;

    if (!$groupId) {
        return back()->with('error', 'Group soal tidak ditemukan.');
    }

    $exam = Exam::where('id', $examId)
        ->where('user_id', $user->id)
        ->firstOrFail();

    if ($exam->status === 'completed') {
        return redirect()->route('camaba.exam.success', $exam->id)
            ->with('error', 'Ujian ini sudah selesai.');
    }

    if (!$request->has('answers')) {
        return back()->with('error', 'Jawaban tidak ditemukan.');
    }

    /**
     * 🔥 SIMPAN JAWABAN
     */
    foreach ($request->answers as $questionId => $answer) {

        $question = Question::with('group')->find($questionId);
        if (!$question) continue;

        $type  = $question->group->type ?? 'PU';
        $answer = strtoupper($answer); // ✅ FIX WAJIB
        $score = 0;

        // ✅ PU
        if ($type == 'PU') {
            if ($answer == strtoupper($question->correct_answer)) {
                $score = floatval($question->score ?? 0);
            }
        }

        // ✅ PSI
      if ($type == 'PSI') {
    if (trim(strtoupper($answer)) == trim(strtoupper($question->correct_answer))) {
        $score = floatval($question->score ?? 0);
    }
}

        ExamAnswer::updateOrCreate(
            [
                'exam_id' => $exam->id,
                'question_id' => $questionId
            ],
            [
                'selected_answer' => $answer,
                'score' => $score
            ]
        );
    }

    /**
     * 🔥 HITUNG SCORE PU
     */
    $totalPU = Question::whereHas('group', function ($q) {
        $q->where('type', 'PU');
    })->count();

    $correctPU = ExamAnswer::where('exam_id', $exam->id)
        ->join('questions', 'questions.id', '=', 'exam_answers.question_id')
        ->join('question_groups', 'question_groups.id', '=', 'questions.question_group_id')
        ->where('question_groups.type', 'PU')
        ->whereColumn('exam_answers.selected_answer', 'questions.correct_answer')
        ->count();

        
    $scorePU = $totalPU > 0 ? ($correctPU / $totalPU) * 100 : 0;

    /**
     * 🔥 HITUNG SCORE PSI
     */
    $scorePSI = ExamAnswer::where('exam_id', $exam->id)
    ->join('questions', 'questions.id', '=', 'exam_answers.question_id')
    ->join('question_groups', 'question_groups.id', '=', 'questions.question_group_id')
    ->where('question_groups.type', 'PSI')
    ->sum('exam_answers.score') ?? 0;

    /**
     * 🔥 HITUNG PROGRESS PSI
     */
    $psiGroups = QuestionGroup::where('type', 'PSI')->pluck('id');
    $completedPsiGroups = 0;

    foreach ($psiGroups as $psiGroupId) {

        $total = Question::where('question_group_id', $psiGroupId)->count();

        $answered = ExamAnswer::where('exam_id', $exam->id)
            ->whereIn('question_id', function ($q) use ($psiGroupId) {
                $q->select('id')
                  ->from('questions')
                  ->where('question_group_id', $psiGroupId);
            })
            ->count();

        if ($total > 0 && $total == $answered) {
            $completedPsiGroups++;
        }
    }

    /**
     * 🔥 HITUNG IQ
     */
    $iq = null;

    if ($completedPsiGroups == count($psiGroups)) {
        $iq = $this->convertIQ(round($scorePSI));
    }
    $answeredPU = ExamAnswer::where('exam_id', $exam->id)
    ->join('questions', 'questions.id', '=', 'exam_answers.question_id')
    ->join('question_groups', 'question_groups.id', '=', 'questions.question_group_id')
    ->where('question_groups.type', 'PU')
    ->count();

$status = ($answeredPU == $totalPU && $completedPsiGroups == count($psiGroups))
    ? 'completed'
    : 'in_progress';
    /**
     * 🔥 UPDATE EXAM (INI YANG PENTING)
     */
    $exam->update([
        'status' => $status,
        'finished_at' => $status === 'completed' ? now() : null,
        'score_pu' => round($scorePU, 2),
        'score_psi' => round($scorePSI, 2),
        'iq' => $iq
    ]);

    session(['group_id' => $groupId]);

    return redirect()->route('camaba.exam.success', [
        'examId' => $exam->id
    ]);
}
public function saveAnswer(Request $request, $examId)
{
    $data = $request->json()->all();

    $questionId = $data['question_id'] ?? null;
    $answer     = strtoupper($data['selected_answer'] ?? '');

    if (!$questionId || !$answer) {
        return response()->json(['success' => false, 'msg' => 'Data kosong']);
    }

    $exam = Exam::findOrFail($examId);

    $question = Question::with('group')->find($questionId);
    if (!$question) {
        return response()->json(['success' => false, 'msg' => 'Soal tidak ditemukan']);
    }

    $type = $question->group->type ?? 'PU';
    $score = 0;

    if ($type == 'PU') {
        if ($answer == strtoupper($question->correct_answer)) {
            $score = floatval($question->score ?? 0);
        }
    }

   if ($type == 'PSI') {
    if (trim(strtoupper($answer)) == trim(strtoupper($question->correct_answer))) {
        $score = floatval($question->score ?? 0);
    }
}

    ExamAnswer::updateOrCreate(
        [
            'exam_id' => $examId,
            'question_id' => $questionId
        ],
        [
            'selected_answer' => $answer,
            'score' => $score
        ]
    );

    return response()->json(['success' => true]);
}
    /**
     * Halaman hasil ujian camaba.
     * ⚠️ TIDAK DIUBAH SAMA SEKALI
     */
   public function success(Request $request, $examId)
{
    $exam = Exam::with('examSchedule')->findOrFail($examId);

    /**
     * Ambil group_id dari session
     */
    $groupId = session('group_id');

    /**
     * Jika session kosong → ambil group terakhir yang dikerjakan
     */
    if (!$groupId) {

        $groupId = ExamAnswer::where('exam_id', $examId)
            ->join('questions', 'questions.id', '=', 'exam_answers.question_id')
            ->orderBy('exam_answers.updated_at', 'desc')
            ->value('questions.question_group_id');
    }

    /**
     * Jika masih kosong juga → fallback ke group pertama exam
     */
    if (!$groupId) {

        $groupId = QuestionGroup::orderBy('id', 'asc')->value('id');
    }

    /**
     * Ambil data group
     */
    $group = QuestionGroup::find($groupId);

    /**
     * Hitung total soal dalam group
     */
    $totalQuestions = Question::where('question_group_id', $groupId)->count();

    /**
     * Hitung jumlah soal yang dijawab user dalam group
     */
    $answeredQuestions = ExamAnswer::where('exam_id', $examId)
        ->whereIn('question_id', function ($query) use ($groupId) {

            $query->select('id')
                  ->from('questions')
                  ->where('question_group_id', $groupId);

        })
        ->count();

    /**
     * Ambil durasi group
     */
    $duration = $group->duration ?? 0;

    $nextGroup = QuestionGroup::where('type', $group->type)
    ->where('id', '>', $group->id)
    ->orderBy('id')
    ->first();
    /**
     * Kirim ke view
     */
    return view('camaba.exam.success', compact(
        'exam',
        'group',
        'totalQuestions',
        'answeredQuestions',
        'duration',
        'nextGroup'
    ));
}
private function convertIQ($score)
{
    $map = [
        16=>66,17=>70,18=>73,19=>76,20=>79,
        21=>81,22=>83,23=>84,24=>86,25=>87,
        26=>89,27=>91,28=>92,29=>94,30=>96,
        31=>97,32=>99,33=>102,34=>105,35=>107,
        36=>109,37=>111,38=>113,39=>115,40=>117,
        41=>119,42=>121,43=>123,44=>125,45=>127,
        46=>129,47=>131,48=>133,49=>135,50=>137,
        51=>139,52=>141,53=>143,54=>145
    ];

    if ($score < 16) {
        return 65;
    }

    if ($score > 54) {
        return 146;
    }

    return $map[$score];
}
}