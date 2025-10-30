<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
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

        return view('admin.pendaftaran-admin', compact('camaba'));
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

        return view('admin.detail-pendaftaran', compact('camaba'));
    }
}