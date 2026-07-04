<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class QuestionController extends Controller
{
    public function index(Request $request)
    {
        $groupId = $request->group_id;

        $query = Question::with('group');

        if ($groupId) {
            $query->where('question_group_id', $groupId);
        }

        $questions = $query->paginate(10);

        $group = null;

        if ($groupId) {
            $group = QuestionGroup::find($groupId);
        }

        return view(
            'admin.questions.index',
            compact('questions', 'group', 'groupId')
        );
    }

    public function create()
    {
        $groups = QuestionGroup::all(); // untuk dropdown group PSI
        return view('admin.questions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $group = QuestionGroup::find($request->question_group_id);

        if (!$group) {
            return back()->withErrors([
                'question_group_id' => 'Pilih kelompok soal!'
            ]);
        }

        $type = $group->type;

        // =====================
        // VALIDATION RULES
        // =====================

        $rules = [
            'question_text' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D,E',
            'score' => 'required|numeric|min:0.1',
        ];

        if ($type === 'PU') {

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                $rules["answer_choices.$opt"] = 'required|string';
            }
        } else { // PSI

            $rules['question_image'] =
                'required|image|mimes:jpg,jpeg,png|max:2048';

            $rules['video_tutorial'] =
                'required|url';

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                $rules["answer_choices.$opt.image"] =
                    'required|image|mimes:jpg,jpeg,png|max:2048';
            }
        }

        $validated = $request->validate($rules);


        // =====================
        // HANDLE ANSWER CHOICES
        // =====================

        $answerChoices = [];

        if ($type === 'PSI') {

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {

                $path = $request
                    ->file("answer_choices.$opt.image")
                    ->store('psi_answers', 'public');

                $answerChoices[$opt] = [
                    'image' => $path
                ];
            }
        } else {

            $answerChoices = $request->input('answer_choices');
        }


        // =====================
        // HANDLE QUESTION IMAGE
        // =====================

        $questionImage = null;

        if ($type === 'PSI') {

            $questionImage = $request
                ->file('question_image')
                ->store('question_images', 'public');
        }


        // =====================
        // HANDLE VIDEO (URL ONLY)
        // =====================

        $videoTutorial = null;

        if ($type === 'PSI') {

            $videoTutorial = $validated['video_tutorial'];
        }


        // =====================
        // CREATE QUESTION
        // =====================

        Question::create([
            'question_text' => $validated['question_text'],
            'question_image' => $questionImage,
            'video_tutorial' => $videoTutorial,
            'answer_choices' => $answerChoices,
            'correct_answer' => $validated['correct_answer'],
            'score' => $validated['score'],
            'question_group_id' => $group->id,
        ]);


        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Soal berhasil ditambahkan!');
    }
    public function edit(Question $question)
    {
        $groups = QuestionGroup::all();

        // ambil tipe soal dari relasi group
        $currentType = $question->group->type ?? 'PU';

        return view('admin.questions.edit', compact(
            'question',
            'groups',
            'currentType'
        ));
    }
    public function update(Request $request, Question $question)
    {
        $group = QuestionGroup::find($request->question_group_id);

        if (!$group) {
            return back()->withErrors([
                'question_group_id' => 'Pilih kelompok soal!'
            ]);
        }

        $type = $group->type;

        $rules = [
            'question_text' => 'required|string',
            'correct_answer' => 'required|in:A,B,C,D,E',
            'score' => 'nullable|numeric|min:0.1',
        ];

        // =====================
        // VALIDASI PU
        // =====================

        if ($type === 'PU') {

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                $rules["answer_choices.$opt"] = 'required|string';
            }

            $rules['score'] = 'required|numeric|min:0.1';
        }

        // =====================
        // VALIDASI PSI
        // =====================

        if ($type === 'PSI') {

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {
                $rules["answer_choices.$opt.image"] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
            }

            $rules['question_image'] = 'nullable|image|mimes:jpg,jpeg,png|max:2048';
        }

        $validated = $request->validate($rules);

        // =====================
        // HANDLE QUESTION IMAGE
        // =====================

        $questionImage = $question->question_image;

        if ($request->hasFile('question_image')) {

            if ($questionImage) {
                Storage::disk('public')->delete($questionImage);
            }

            $questionImage = $request->file('question_image')
                ->store('question_images', 'public');
        }
        // =====================
        // HANDLE VIDEO TUTORIAL
        // =====================
        $videoTutorial = $question->video_tutorial;

        if ($request->filled('video_tutorial')) {
            $videoTutorial = $request->video_tutorial;
        }

        // =====================
        // HANDLE ANSWER CHOICES
        // =====================

        $answerChoices = [];

        if ($type === 'PSI') {

            $oldChoices = $question->answer_choices ?? [];

            foreach (['A', 'B', 'C', 'D', 'E'] as $opt) {

                if ($request->hasFile("answer_choices.$opt.image")) {

                    if (isset($oldChoices[$opt]['image'])) {
                        Storage::disk('public')->delete($oldChoices[$opt]['image']);
                    }

                    $path = $request->file("answer_choices.$opt.image")
                        ->store('psi_answers', 'public');

                    $answerChoices[$opt] = [
                        'image' => $path
                    ];
                } else {

                    $answerChoices[$opt] = $oldChoices[$opt] ?? null;
                }
            }
        } else {

            $answerChoices = $validated['answer_choices'];
        }

        // =====================
        // UPDATE DATA
        // =====================

        $question->update([
            'question_text' => $validated['question_text'],
            'question_image' => $questionImage,
            'video_tutorial' => $videoTutorial,
            'answer_choices' => $answerChoices,
            'correct_answer' => $validated['correct_answer'],
            'score' => $validated['score'] ?? 1,
            'question_group_id' => $group->id,
        ]);

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Soal berhasil diperbarui!');
    }
    public function destroy(Question $question)
    {
        // =====================
        // HAPUS JAWABAN PSI
        // =====================
        if ($question->group && $question->group->type === 'PSI' && is_array($question->answer_choices)) {

            foreach ($question->answer_choices as $choice) {

                if (isset($choice['image'])) {
                    Storage::disk('public')->delete($choice['image']);
                }
            }
        }

        // =====================
        // HAPUS GAMBAR SOAL
        // =====================
        if ($question->question_image) {
            Storage::disk('public')->delete($question->question_image);
        }

        // =====================
        // HAPUS VIDEO TUTORIAL
        // =====================
        if ($question->video_tutorial) {
            Storage::disk('public')->delete($question->video_tutorial);
        }

        // =====================
        // HAPUS DATA
        // =====================
        $question->delete();

        return redirect()
            ->route('admin.questions.index')
            ->with('success', 'Soal berhasil dihapus!');
    }
}
