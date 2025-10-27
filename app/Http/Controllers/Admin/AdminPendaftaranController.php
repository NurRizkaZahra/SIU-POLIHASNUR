<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPendaftaranController extends Controller
{
    /**
     * Display halaman beranda admin
     */
    public function beranda()
    {
        return view('admin.beranda-admin');
    }

    /**
     * Display halaman pendaftaran admin
     */
    public function index()
    {
        return view('admin.pendaftaran-admin');
    }

    /**
     * API endpoint untuk mendapatkan data pendaftaran
     */
    public function getData()
    {
        try {
            $pendaftaran = Pendaftar::select(
                'id as no',
                'nama_lengkap as nama',
                'jalur_masuk as jalur',
                'pilihan_prodi as prodi',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function($item, $index) {
                $item->no = $index + 1; // Numbering
                unset($item->created_at);
                return $item;
            });

            return response()->json($pendaftaran);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint untuk statistik dashboard
     */
    public function getStats()
    {
        try {
            $total = Pendaftar::count();
            $belum = Pendaftar::where('status_ujian', 'belum')->count();
            $selesai = Pendaftar::where('status_ujian', 'selesai')->count();

            return response()->json([
                'total' => $total,
                'belum' => $belum,
                'selesai' => $selesai
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Gagal mengambil statistik',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display detail pendaftar
     */
    public function show($id)
    {
        try {
            $pendaftar = Pendaftar::findOrFail($id);
            return view('admin.pendaftaran-detail', compact('pendaftar'));
        } catch (\Exception $e) {
            return redirect()->route('admin.pendaftaran')
                ->with('error', 'Data pendaftar tidak ditemukan');
        }
    }

    /**
     * Update status ujian pendaftar
     */
    public function updateStatusUjian(Request $request, $id)
    {
        try {
            $request->validate([
                'status_ujian' => 'required|in:belum,selesai'
            ]);

            $pendaftar = Pendaftar::findOrFail($id);
            $pendaftar->status_ujian = $request->status_ujian;
            $pendaftar->save();

            return response()->json([
                'success' => true,
                'message' => 'Status ujian berhasil diupdate'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal update status ujian'
            ], 500);
        }
    }

    /**
     * Export data pendaftaran ke Excel/CSV
     */
    public function export(Request $request)
    {
        // Implementasi export jika diperlukan
        // Bisa menggunakan Laravel Excel package
    }

    /**
     * Print/Cetak data pendaftaran
     */
    public function print()
    {
        $pendaftaran = Pendaftar::orderBy('created_at', 'desc')->get();
        return view('admin.pendaftaran-print', compact('pendaftaran'));
    }
}