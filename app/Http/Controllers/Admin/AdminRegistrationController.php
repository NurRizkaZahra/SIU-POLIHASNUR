<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Barryvdh\DomPDF\Facade\Pdf;

class AdminRegistrationController extends Controller
{
    /**
     * Display halaman beranda admin
     */
    public function beranda()
    {
        return view('admin.dashboard');
    }

    /**
     * Display halaman pendaftaran admin
     */
    public function index()
    {
        $camaba = User::role('camaba')
            ->with([
                'personalData',
                'educationData',
                'familyData',
                'admissionPath',
                'programSelection.program1',
                'programSelection.program2',
            ])
            ->get();

        return view('admin.registration-admin', compact('camaba'));
    }

    public function show($id)
    {

        $camaba = \App\Models\User::with([
            'personalData',
            'educationData',
            'familyData',
            'admissionPath',
            'programSelection.program1',
            'programSelection.program2',
        ])->findOrFail($id);


        return view('admin.registration-details', compact('camaba'));
    }

    public function downloadPdf($id)
    {
        $camaba = User::with([
            'personalData',
            'educationData',
            'familyData',
            'admissionPath',
            'programSelection.program1',
            'programSelection.program2'
        ])->findOrFail($id);

        $pdf = Pdf::loadView('admin.pdf-detail', compact('camaba'));

        return $pdf->download('detail-pendaftar.pdf');
    }
}
