<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\QuestionGroup;
use Illuminate\Http\Request;

class QuestionGroupController extends Controller
{
    /**
     * Tampilkan daftar kelompok soal
     */
    public function index()
    {
        $groups = QuestionGroup::orderBy('created_at', 'desc')->paginate(10);
        return view('admin.question-groups.index', compact('groups'));
    }

    /**
     * Form tambah kelompok soal
     */
    public function create()
    {
        return view('admin.question-groups.create');
    }

    /**
     * Simpan kelompok soal baru
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:PU,PSI',
            'video_tutorial' => 'nullable|url',
        ]);

        QuestionGroup::create($validated);

        return redirect()
            ->route('admin.question-groups.index')
            ->with('success', 'Kelompok soal berhasil ditambahkan!');
    }

    /**
     * Form edit kelompok soal
     */
    public function edit(QuestionGroup $questionGroup)
    {
        return view('admin.question-groups.edit', compact('questionGroup'));
    }

    /**
     * Update kelompok soal
     */
    public function update(Request $request, QuestionGroup $questionGroup)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|in:PU,PSI',
            'video_tutorial' => 'nullable|url',
        ]);

        $questionGroup->update($validated);

        return redirect()
            ->route('admin.question-groups.index')
            ->with('success', 'Kelompok soal berhasil diperbarui!');
    }

    /**
     * Hapus kelompok soal
     */
    public function destroy(QuestionGroup $questionGroup)
    {
        // Cek apakah ada soal dalam kelompok ini
        if ($questionGroup->questions()->count() > 0) {
            return redirect()
                ->back()
                ->with('error', 'Tidak dapat menghapus kelompok yang masih memiliki soal!');
        }

        $questionGroup->delete();

        return redirect()
            ->route('admin.question-groups.index')
            ->with('success', 'Kelompok soal berhasil dihapus!');
    }
}