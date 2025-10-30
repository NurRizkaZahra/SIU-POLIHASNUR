<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ExamSchedule; // <--- tambahkan ini

class ExamScheduleController extends Controller
{
    public function index()
    {
        $gelombang = ExamSchedule::orderBy('start_date', 'desc')->get();

        if (auth()->check() && auth()->user()->hasRole('admin')) {
            return view('admin.exam-schedule-admin', compact('gelombang'));
        }

        return view('camaba.exam-schedule', compact('gelombang'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gelombang_id' => 'required|integer',
            'tanggal' => 'required|date'
        ]);

        // Bisa simpan pengajuan di tabel khusus atau kirim notifikasi admin

        return response()->json([
            'success' => true,
            'message' => 'Jadwal ujian telah berhasil diajukan!'
        ]);
    }
}
