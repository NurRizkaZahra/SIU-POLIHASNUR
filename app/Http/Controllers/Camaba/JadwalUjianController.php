<?php

namespace App\Http\Controllers\Camaba;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class JadwalUjianController extends Controller
{
    public function index()
    {
        // arahkan ke view jadwal ujian
        return view('camaba.jadwal-ujian');
    }
}
