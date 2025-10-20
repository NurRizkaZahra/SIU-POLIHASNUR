<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalUjianController extends Controller
{
    public function index()
    {
        $gelombang = [
            (object)[
                'id' => 1, 
                'nama' => 'Gelombang 1', 
                'tanggal_mulai' => '21-07-2025', 
                'tanggal_akhir' => '25-07-2025'
            ],
            (object)[
                'id' => 2, 
                'nama' => 'Gelombang 2', 
                'tanggal_mulai' => '01-08-2025', 
                'tanggal_akhir' => '15-08-2025'
            ],
            (object)[
                'id' => 3, 
                'nama' => 'Gelombang 3', 
                'tanggal_mulai' => '20-08-2025', 
                'tanggal_akhir' => '31-08-2025'
            ],
            (object)[
                'id' => 4, 
                'nama' => 'Gelombang 4', 
                'tanggal_mulai' => '01-09-2025', 
                'tanggal_akhir' => '15-09-2025'
            ],
        ];
        
        return view('camaba.jadwal-ujian', ['gelombang' => $gelombang]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'gelombang_id' => 'required|integer',
            'tanggal' => 'required|date'
        ]);

        // Simpan jadwal ujian ke database jika ada tabel
        // JadwalUjian::create([
        //     'user_id' => auth()->id(),
        //     'gelombang_id' => $validated['gelombang_id'],
        //     'tanggal_ujian' => $validated['tanggal']
        // ]);

        return response()->json([
            'success' => true,
            'message' => 'Jadwal ujian berhasil diajukan'
        ]);
    }
}