<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use Illuminate\Http\Request;

class AdminResultController extends Controller
{
    public function index()
    {
        $results = Exam::with('user')->get();

        return view('admin.result', compact('results'));
    }

    public function print()
    {
        // nanti untuk fitur cetak
    }
}
