<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pendaftar;
use Illuminate\Http\Request;

class AdminRegistrationController extends Controller
{
    /**
     * Display admin dashboard page
     */
    public function dashboard()
    {
        return view('admin.dashboard-admin');
    }

    /**
     * Display registration management page
     */
    public function index()
    {
        return view('admin.registration-admin');
    }

    /**
     * API endpoint to fetch registration data
     */
    public function getData()
    {
        try {
            $registrations = Pendaftar::select(
                'id as no',
                'nama_lengkap as name',
                'jalur_masuk as entry_path',
                'pilihan_prodi as study_program',
                'created_at'
            )
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(function ($item, $index) {
                $item->no = $index + 1; // numbering
                unset($item->created_at);
                return $item;
            });

            return response()->json($registrations);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve data',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * API endpoint for dashboard statistics
     */
    public function getStats()
    {
        try {
            $total = Pendaftar::count();
            $notTaken = Pendaftar::where('status_ujian', 'belum')->count();
            $completed = Pendaftar::where('status_ujian', 'selesai')->count();

            return response()->json([
                'total' => $total,
                'not_taken' => $notTaken,
                'completed' => $completed
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => 'Failed to retrieve statistics',
                'message' => $e->getMessage()
            ], 500);
        }
    }

    /**
     * Display registration detail
     */
    public function show($id)
    {
        try {
            $registrant = Pendaftar::findOrFail($id);
            return view('admin.registration-detail', compact('registrant'));
        } catch (\Exception $e) {
            return back()->with('error', 'Data not found: ' . $e->getMessage());
        }
    }
}
