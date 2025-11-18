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
         $group = QuestionGroup::find($request->question_group_id);
    $rules = [
        'question_text' => 'required|string',
        'answer_choices' => 'required|array|size:5',
    ];

    // jika grup dipilih, baca type dari grup
    $type = $group ? $group->type : $request->type;

    // PSI wajib ada grup
    if ($type == 'PSI' && !$group) {
        return back()->withErrors(['question_group_id' => 'Soal PSI wajib memilih grup']);
    }

    if ($type == 'PU')
    {
        $rules['correct_answer'] = 'required|string|in:A,B,C,D,E';
        $rules['score'] = 'required|numeric|min:0.1';

        foreach (['A','B','C','D','E'] as $i) {
            $rules["answer_choices.$i"] = 'required|string';
        }
    }

    if ($type == 'PSI')
    {
        foreach (['A','B','C','D','E'] as $i) {
            $rules["answer_choices.$i.text"] = 'required|string';
            $rules["answer_choices.$i.score"] = 'required|numeric|min:1';
        }
    }

    $validated = $request->validate($rules);

    Question::create([
        'question_text' => $validated['question_text'],
        'answer_choices' => $validated['answer_choices'],
        'correct_answer' => $type == 'PU' ? $validated['correct_answer'] : null,
        'score' => $type == 'PU' ? $validated['score'] : null,
        'question_group_id' => $group ? $group->id : null,
    ]);

    return redirect()->route('admin.questions.index')->with('success', 'Soal berhasil ditambahkan!');
}

   public function edit(Question $question)
{
    $groups = QuestionGroup::all();
    
    return view('admin.questions.edit', compact('question', 'groups'));
}
    public function update(Request $request, Question $question)
    {
        // Cek grup soal
    $group = QuestionGroup::find($request->question_group_id);

    if (!$group) {
        return back()->withErrors(['question_group_id' => 'Pilih kelompok soal!']);
    }

    // Rules dasar
    $rules = [
        'question_text' => 'required|string',
        'question_group_id' => 'required|exists:question_groups,id',
        'answer_choices' => 'required|array|size:5',
    ];

    // Rules untuk PU (Pilihan Umum)
    if ($group->type == 'PU') {
        $rules['correct_answer'] = 'required|string|in:A,B,C,D,E';
        $rules['score'] = 'required|numeric|min:0.5';

        foreach (['A','B','C','D','E'] as $opt) {
            $rules["answer_choices.$opt"] = 'required|string';
        }
    }

    // Rules untuk PSI (Psikotes)
    if ($group->type == 'PSI') {
        foreach (['A','B','C','D','E'] as $opt) {
            $rules["answer_choices.$opt.text"] = 'required|string';
            $rules["answer_choices.$opt.score"] = 'required|integer|min:1';
        }
    }

    // Validasi
    $validated = $request->validate($rules);

    // Update data
    $question->update([
        'question_text' => $validated['question_text'],
        'answer_choices' => $validated['answer_choices'],
        'correct_answer' => $group->type == 'PU' ? $validated['correct_answer'] : null,
        'score' => $group->type == 'PU' ? $validated['score'] : null,
        'question_group_id' => $validated['question_group_id'],
    ]);

    return redirect()->route('admin.questions.index')
        ->with('success', 'Soal berhasil diperbarui!');
}
public function destroy($id)
{
    $question = Question::findOrFail($id);
    $question->delete();

    return redirect()->route('admin.questions.index')
                     ->with('success', 'Soal berhasil dihapus!');
}
}
