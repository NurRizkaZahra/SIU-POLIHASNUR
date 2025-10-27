<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CamabaController;
use App\Http\Controllers\Camaba\JadwalUjianController;
use App\Http\Controllers\Admin\AdminPendaftaranController;
use App\Http\Controllers\Admin\JadwalUjianAdminController;

// ================== HALAMAN UTAMA ==================
Route::get('/', function () {
    return view('welcome');
});

// ================== DASHBOARD UNIVERSAL ==================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('camaba')) {
        return redirect()->route('dashboard.camaba');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== API STATS (UMUM) ==================
Route::get('/api/dashboard-stats', function () {
    return response()->json([
        'total' => \App\Models\Pendaftar::count(),
        'belum' => \App\Models\Pendaftar::where('status_ujian', 'belum')->count(),
        'selesai' => \App\Models\Pendaftar::where('status_ujian', 'selesai')->count()
    ]);
});

// ================== ADMIN ==================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // ================== PENDAFTARAN ==================
    Route::get('/pendaftaran', [AdminPendaftaranController::class, 'index'])->name('pendaftaran');
    Route::get('/pendaftaran/{id}', [AdminPendaftaranController::class, 'show'])->name('pendaftaran.detail');
    Route::post('/pendaftaran/{id}/status-ujian', [AdminPendaftaranController::class, 'updateStatusUjian'])->name('pendaftaran.update-status');
    Route::get('/pendaftaran/cetak/all', [AdminPendaftaranController::class, 'print'])->name('pendaftaran.print');
    Route::get('/pendaftaran/export/excel', [AdminPendaftaranController::class, 'export'])->name('pendaftaran.export');

    // ================== JADWAL UJIAN ==================
    Route::get('/jadwal-ujian', [JadwalUjianAdminController::class, 'index'])->name('jadwal-ujian');
    Route::get('/jadwal-ujian/create', [JadwalUjianAdminController::class, 'create'])->name('jadwal-ujian.create');
    Route::post('/jadwal-ujian', [JadwalUjianAdminController::class, 'store'])->name('jadwal-ujian.store');
    Route::get('/jadwal-ujian/{id}/edit', [JadwalUjianAdminController::class, 'edit'])->name('jadwal-ujian.edit');
    Route::put('/jadwal-ujian/{id}', [JadwalUjianAdminController::class, 'update'])->name('jadwal-ujian.update');
    Route::delete('/jadwal-ujian/{id}', [JadwalUjianAdminController::class, 'destroy'])->name('jadwal-ujian.destroy');
});

// ================== CAMABA ==================
Route::middleware(['auth', 'role:camaba'])->group(function () {
    Route::get('/dashboard/camaba', fn() => view('camaba.dashboard'))->name('dashboard.camaba');

    Route::get('/camaba/pendaftaran', fn() => view('camaba.pendaftaran'))->name('pendaftaran');
    Route::post('/camaba/pendaftaran', [CamabaController::class, 'store'])->name('pendaftaran.store');

    Route::get('/camaba/pendaftaran-lanjutan', [CamabaController::class, 'pendaftaranLanjutan'])->name('pendaftaran-lanjutan');

    // Data jalur & prodi
    Route::get('/camaba/data-jalur', [CamabaController::class, 'formJalurMasuk'])->name('camaba.data-jalur');
    Route::post('/camaba/data-jalur', [CamabaController::class, 'simpanJalurMasuk'])->name('camaba.data-jalur.simpan');

    Route::get('/camaba/data-prodi', [CamabaController::class, 'formProgramStudi'])->name('camaba.data-prodi');
    Route::post('/camaba/data-prodi', [CamabaController::class, 'simpanProgramStudi'])->name('camaba.data-prodi.simpan');

    Route::post('/camaba/data-diri', [CamabaController::class, 'simpanDataDiri'])->name('camaba.data-diri.simpan');
    Route::post('/camaba/data-pendidikan', [CamabaController::class, 'simpanDataPendidikan'])->name('camaba.data-pendidikan.simpan');
    Route::post('/camaba/data-keluarga', [CamabaController::class, 'simpanDataKeluarga'])->name('camaba.data-keluarga.simpan');

    // Jadwal ujian (camaba)
    Route::get('/jadwal-ujian', [JadwalUjianController::class, 'index'])->name('jadwal.ujian');
});

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== AUTH ==================
require __DIR__ . '/auth.php';
