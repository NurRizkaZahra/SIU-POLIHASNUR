<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Hitung semua statistik dashboard.
     */
    private function calculateStats()
    {
        // Total user kecuali admin ID=2
        $totalPendaftar = DB::table('users')
            ->where('id', '!=', 2)
            ->count();

        // User yang sudah selesai ujian (punya finished_at)
        $selesaiUjian = DB::table('exams')
            ->whereNotNull('finished_at')
            ->distinct()
            ->count('user_id');

        // Hitung belum ujian
        $belumUjian = max(0, $totalPendaftar - $selesaiUjian);

        return [
            'totalPendaftar' => $totalPendaftar,
            'selesaiUjian'   => $selesaiUjian,
            'belumUjian'     => $belumUjian,
        ];
    }

    /**
     * Dashboard page
     */
    public function index()
{
    try {
        $totalPendaftar = DB::table('users')
            ->where('id', '!=', 2) // admin id = 2
            ->count();

        $selesaiUjian = DB::table('exams')
            ->whereNotNull('finished_at')
            ->distinct()
            ->count('user_id');

        $belumUjian = max(0, $totalPendaftar - $selesaiUjian);

        return view('admin.dashboard', compact(
            'totalPendaftar',
            'belumUjian',
            'selesaiUjian'
        ));
    } catch (\Exception $e) {
        return view('admin.dashboard', [
            'totalPendaftar' => 0,
            'belumUjian' => 0,
            'selesaiUjian' => 0
        ]);
    }
}


    /**
     * Dashboard AJAX Stats API
     */
    public function getStats()
    {
        try {
            $stats = $this->calculateStats();

            return response()->json([
                'success' => true,
                'total'   => $stats['totalPendaftar'],
                'belum'   => $stats['belumUjian'],
                'selesai' => $stats['selesaiUjian']
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
