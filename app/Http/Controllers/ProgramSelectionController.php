<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProgramSelection;
use App\Models\StudyProgram;
use Illuminate\Support\Facades\Auth;

class ProgramSelectionController extends Controller
{
    public function index()
    {
        // ambil semua program studi untuk ditampilkan di dropdown
        $programs = StudyProgram::all();
        $selection = ProgramSelection::where('user_id', Auth::id())->first();

        return view('camaba.program_selection', compact('programs', 'selection'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'id_program_1' => 'required|different:id_program_2',
            'id_program_2' => 'nullable',
        ]);

        ProgramSelection::updateOrCreate(
            ['user_id' => Auth::id()],
            [
                'id_program_1' => $request->id_program_1,
                'id_program_2' => $request->id_program_2,
            ]
        );

        return redirect()->back()->with('success', 'Pilihan program studi berhasil disimpan!');
    }
}
