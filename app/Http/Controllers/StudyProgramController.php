<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StudyProgram;

class StudyProgramController extends Controller
{
    // Menampilkan semua program studi
    public function index()
    {
        $programs = StudyProgram::all();
        return view('admin.program_study.index', compact('programs'));
    }

    // Menyimpan data baru
    public function store(Request $request)
    {
        $request->validate([
            'program_name' => 'required|string|max:255',
        ]);

        StudyProgram::create([
            'program_name' => $request->program_name,
        ]);

        return redirect()->back()->with('success', 'Program Studi berhasil ditambahkan!');
    }

    // Menghapus program studi
    public function destroy($id)
    {
        $program = StudyProgram::findOrFail($id);
        $program->delete();

        return redirect()->back()->with('success', 'Program Studi berhasil dihapus!');
    }
}
