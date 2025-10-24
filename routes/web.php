<?php

use App\Http\Controllers\CamabaController;
use App\Http\Controllers\Camaba\JadwalUjianController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmissionPathController;
use App\Http\Controllers\StudyProgramController;
use App\Http\Controllers\ProgramSelectionController;

Route::get('/', function () {
    return view('welcome');
});

// ================== DASHBOARD UNIVERSAL ==================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('dashboard.admin');
    } elseif ($user->hasRole('camaba')) {
        return redirect()->route('dashboard.camaba');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('admin.dashboard');
    })->name('dashboard.admin');
});

// ================== CAMABA ==================
Route::middleware(['auth', 'role:camaba'])->group(function () {
    Route::get('/dashboard/camaba', function () {
        return view('camaba.dashboard');
    })->name('dashboard.camaba');

    // Halaman form pertama
    Route::get('/camaba/pendaftaran', function () {
        return view('camaba.pendaftaran');
    })->name('pendaftaran');

    // Proses simpan sementara ke session
    Route::post('/camaba/pendaftaran', [CamabaController::class, 'store'])
        ->name('pendaftaran.store');

    // Halaman kedua (lanjutan)
    Route::get('/camaba/pendaftaran-lanjutan', [CamabaController::class, 'pendaftaranLanjutan'])
        ->name('pendaftaran-lanjutan');

     // ----- FORM JALUR MASUK -----
    Route::get('/camaba/data-jalur', [CamabaController::class, 'formJalurMasuk'])
        ->name('camaba.data-jalur');
    Route::post('/camaba/data-jalur', [CamabaController::class, 'simpanJalurMasuk'])
        ->name('camaba.data-jalur.simpan');

    // ----- FORM PROGRAM STUDI -----
    Route::get('/camaba/data-prodi', [CamabaController::class, 'formProgramStudi'])
        ->name('camaba.data-prodi');
    Route::post('/camaba/data-prodi', [CamabaController::class, 'simpanProgramStudi'])
        ->name('camaba.data-prodi.simpan');

     // ===== FORM PENDAFTARAN DETAIL =====
    Route::post('/camaba/data-diri', [CamabaController::class, 'simpanDataDiri'])
        ->name('camaba.data-diri.simpan');

    Route::post('/camaba/data-pendidikan', [CamabaController::class, 'simpanDataPendidikan'])
        ->name('camaba.data-pendidikan.simpan');

    Route::post('/camaba/data-keluarga', [CamabaController::class, 'simpanDataKeluarga'])
        ->name('camaba.data-keluarga.simpan');

    // Jadwal ujian
    Route::get('/jadwal-ujian', [JadwalUjianController::class, 'index'])
        ->name('jadwal.ujian');
});

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';