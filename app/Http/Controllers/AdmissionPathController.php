<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdmissionPath;
use Illuminate\Support\Facades\Auth;


class AdmissionPathController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'path_name' => 'required|string|max:255',
        ]);

        AdmissionPath::updateOrCreate(
            ['id_user' => Auth::id()],
            ['path_name' => $request->path_name]
        );

        return redirect()->back()->with('success', 'Data Jalur Masuk berhasil disimpan!');
    }
}
