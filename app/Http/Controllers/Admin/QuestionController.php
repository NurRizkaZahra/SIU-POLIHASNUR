<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Question;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        $questions = Question::with('group')->paginate(10);
        return view('admin.questions.index', compact('questions'));
    }

    public function create()
    {
        $groups = QuestionGroup::all(); // untuk dropdown group PSI
        return view('admin.questions.create', compact('groups'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
            'score' => 'required|integer|min:1',
            'question_group_id' => 'nullable|exists:question_groups,id',
            
            // JSON input
            'answer_choices' => 'required|array|size:5',
            'answer_choices.A' => 'required|string',
            'answer_choices.B' => 'required|string',
            'answer_choices.C' => 'required|string',
            'answer_choices.D' => 'required|string',
            'answer_choices.E' => 'required|string',
        ]);

        Question::create([
            'question_text' => $validated['question_text'],
            'answer_choices' => json_encode($validated['answer_choices']),
            'correct_answer' => $validated['correct_answer'],
            'score' => $validated['score'],
            'question_group_id' => $validated['question_group_id'],
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil ditambahkan!');
    }

   public function edit(Question $question)
{
    $groups = QuestionGroup::all();
    
    return view('admin.questions.edit', compact('question', 'groups'));
}
    public function update(Request $request, Question $question)
    {
        $validated = $request->validate([
            'question_text' => 'required|string',
            'correct_answer' => 'required|string|in:A,B,C,D,E',
            'score' => 'required|integer|min:1',
            'question_group_id' => 'nullable|exists:question_groups,id',

            'answer_choices' => 'required|array|size:5',
            'answer_choices.A' => 'required|string',
            'answer_choices.B' => 'required|string',
            'answer_choices.C' => 'required|string',
            'answer_choices.D' => 'required|string',
            'answer_choices.E' => 'required|string',
        ]);

        $question->update([
            'question_text' => $validated['question_text'],
            'answer_choices' => json_encode($validated['answer_choices']),
            'correct_answer' => $validated['correct_answer'],
            'score' => $validated['score'],
            'question_group_id' => $validated['question_group_id'],
        ]);

        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil diperbarui!');
    }

    public function destroy(Question $question)
    {
        $question->delete();
        
        return redirect()->route('admin.questions.index')
            ->with('success', 'Soal berhasil dihapus!');
    }
}
