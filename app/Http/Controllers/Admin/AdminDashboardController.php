<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class AdminDashboardController extends Controller
{
    /**
     * Dashboard page
     */
    public function index()
    {
        try {
            // Total pendaftar (role = camaba)
            $totalPendaftar = User::role('camaba')->count();

            // User UNIK yang sudah selesai ujian - DIPERBAIKI
            $selesaiUjian = DB::table('exams')
                ->join('users', 'exams.user_id', '=', 'users.id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.name', 'camaba')
                ->where('model_has_roles.model_type', 'App\\Models\\User')
                ->whereNotNull('exams.finished_at')
                ->pluck('exams.user_id')
                ->unique()
                ->count();

            // Belum ujian
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
            // Total pendaftar
            $totalPendaftar = User::role('camaba')->count();

            // Selesai ujian - DIPERBAIKI
            $selesaiUjian = DB::table('exams')
                ->join('users', 'exams.user_id', '=', 'users.id')
                ->join('model_has_roles', 'users.id', '=', 'model_has_roles.model_id')
                ->join('roles', 'model_has_roles.role_id', '=', 'roles.id')
                ->where('roles.name', 'camaba')
                ->where('model_has_roles.model_type', 'App\\Models\\User')
                ->whereNotNull('exams.finished_at')
                ->pluck('exams.user_id')
                ->unique()
                ->count();

            $belumUjian = max(0, $totalPendaftar - $selesaiUjian);

            return response()->json([
                'success' => true,
                'total'   => $totalPendaftar,
                'belum'   => $belumUjian,
                'selesai' => $selesaiUjian
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}