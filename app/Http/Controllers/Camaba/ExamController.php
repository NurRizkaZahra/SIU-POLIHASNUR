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

        $user = auth()->user();

        // 🔒 NEW RULE:
        // CEK apakah user sudah pernah memilih jadwal ujian
        $alreadyTookSchedule = Exam::where('user_id', $user->id)
            ->exists();

        if (!$alreadyTookSchedule) {
            // User baru pertama kali → izinkan pilih jadwal
            // (tidak ada tindakan, lanjut)
        } else {
            //User SUDAH PERNAH memilih jadwal → dilarang ganti jadwal lain
            $existingSchedule = Exam::where('user_id', $user->id)->first();

            if ($existingSchedule->exam_schedule_id != $request->exam_schedule_id) {
                return back()->with('error', 'Anda sudah memilih jadwal ujian sebelumnya dan tidak dapat mengganti jadwal.');
           }
       }

        $schedule = ExamSchedule::findOrFail($request->exam_schedule_id);
        $now = now();

        if ($now->lt($schedule->start_date)) {
            return back()->with('error', 'Ujian belum dibuka.');
        }

        if ($now->gt($schedule->end_date)) {
            return back()->with('error', 'Masa ujian telah berakhir.');
        }

        // Cek apakah user sudah pernah ujian
        $exam = Exam::where('user_id', $user->id)
                    ->where('exam_schedule_id', $request->exam_schedule_id)
                    ->first();
        // 🔒 NEW RULE:
        // Jika sudah selesai → TIDAK BOLEH mulai lagi
        if ($exam && $exam->status === 'completed') {
            return redirect()
                ->route('exam.success', $exam->id)
                ->with('error', 'Anda sudah menyelesaikan ujian dan tidak dapat mengulang.');
        }

        // Jika belum pernah, buat ujian baru
        if (!$exam) {
            $exam = Exam::create([
                'user_id'           => $user->id,
                'exam_schedule_id'  => $request->exam_schedule_id,
                'status'            => 'in_progress',
                'start_time'        => now()
            ]);
        }

        // Hapus jawaban lama hanya jika status masih in_progress
        ExamAnswer::where('exam_id', $exam->id)->delete();

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

        // 🔒 NEW RULE:
        // Jika sudah selesai → tidak boleh buka soal lagi
        if ($exam->status === 'completed') {
            return redirect()
                ->route('exam.success', $exam->id)
                ->with('error', 'Ujian sudah diselesaikan. Anda tidak bisa membuka soal lagi.');
        }

        $examSchedule = ExamSchedule::findOrFail($exam->exam_schedule_id);

        // ============================================
        // Ambil semua soal + format PU & PSI
        // ============================================
        $allQuestions = Question::with('group')
            ->get()
            ->map(function($question) {

                $choices = $question->answer_choices;
                $type = $question->group ? $question->group->type : 'PU';

                $formatted = [
                    'id' => $question->id,
                    'question_text' => $question->question_text,
                    'group' => $question->group,
                ];

                foreach(['A','B','C','D','E'] as $letter) {
                    $key = 'option_' . strtolower($letter);

                    if (isset($choices[$letter])) {
                        if ($type == 'PSI' && is_array($choices[$letter])) {
                            $formatted[$key] = $choices[$letter]['text'] ?? '';
                        } else {
                            $formatted[$key] = $choices[$letter];
                        }
                    } else {
                        $formatted[$key] = '';
                    }
                }

                return (object) $formatted;
            });

        // Pisahkan PU & PSI
        $questionsPU = $allQuestions->filter(fn($q) => !$q->group || $q->group->type == 'PU')->shuffle();
        $questionsPSI = $allQuestions->filter(fn($q) => $q->group && $q->group->type == 'PSI')->groupBy('group.id');

        $questions = collect();

        foreach ($questionsPU as $q) $questions->push($q);

        foreach ($questionsPSI as $groupQuestions) {
            $isFirst = true;
            foreach ($groupQuestions->shuffle() as $q) {
                $q->is_first_in_group = $isFirst;
                $questions->push($q);
                $isFirst = false;
            }
        }

        $totalQuestions = $questions->count();
        $answeredCount = ExamAnswer::where('exam_id', $exam->id)->count();
        $savedAnswers = ExamAnswer::where('exam_id', $exam->id)->pluck('selected_answer', 'question_id')->toArray();
        $timeRemaining = $exam->examSchedule->duration * 60;

        return view('camaba.exam.questions', [
            'exam'             => $exam,
            'examSchedule'     => $examSchedule,
            'questions'        => $questions,
            'totalQuestions'   => $totalQuestions,
            'answeredCount'    => $answeredCount,
            'unansweredCount'  => $totalQuestions - $answeredCount,
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

        // 🔒 NEW RULE:
        // Jika sudah selesai → tidak boleh submit lagi
        if ($exam->status === 'completed') {
            return redirect()->route('exam.success', $exam->id)
                ->with('error', 'Ujian ini sudah selesai.');
        }

        foreach ($request->answers as $questionId => $answer) {

            $question = Question::with('group')->find($questionId);
            if (!$question) continue;

            $type = $question->group ? $question->group->type : 'PU';
            $score = 0;

            if ($type == 'PU') {
                if (strtoupper($answer) == strtoupper($question->correct_answer)) {
                    $score = floatval($question->score);
                }
            }

            if ($type == 'PSI') {
                $choices = $question->answer_choices;
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

        // Hitung hasil
        $answers = ExamAnswer::where('exam_id', $exam->id)->get();

        $scorePU = 0;
        $scorePSI = 0;
        $correctPU = 0;
        $totalPU = 0;

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

        // Finalize ujian
        $exam->update([
            'status' => 'completed',
            'finished_at' => now(),
            'score_pu' => round($scorePU, 2),
            'score_psi' => round($scorePSI, 2),
        ]);

        return redirect()->route('exam.success', $exam->id)
            ->with('success', 'Ujian telah diselesaikan.');
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

        $totalQuestions = Question::count();
        $answeredCount = ExamAnswer::where('exam_id', $exam->id)->count();

        return view('camaba.exam.success', compact('exam', 'totalQuestions', 'answeredCount'));
    }
}
