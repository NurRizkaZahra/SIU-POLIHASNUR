<?php

use App\Http\Controllers\CamabaController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

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

    // fallback kalau user belum punya role
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/dashboard/admin', function () {
        return view('admin.dashboard'); // file: resources/views/admin/dashboard.blade.php
    })->name('dashboard.admin');
});

// ================== CAMABA ==================
Route::middleware(['auth', 'role:camaba'])->group(function () {
    Route::get('/dashboard/camaba', function () {
        return view('camaba.dashboard'); // file: resources/views/camaba/dashboard.blade.php
    })->name('dashboard.camaba');

    //halaman form pertama
    Route::get('/camaba/pendaftaran', function(){
        return view('camaba.pendaftaran');
    })->name('pendaftaran');

    //proses simpan sementara ke session
    Route::post('/camaba/pendaftaran', [CamabaController::class, 'simpanSementara'])
    ->name('pendaftaran.simpan');

    //halaman kedua (Lanjutan)
    Route::get('/camaba/pendaftaran-lanjutan', [CamabaController::class, 'pendaftaranLanjutan'])
    ->name('pendaftaran-lanjutan');

    // Tambahkan route POST biar form-nya gak error
    Route::post('/camaba/pendaftaran-lanjutan', function () {
        return back()->with('success', 'Data berhasil disimpan (dummy).');
    })->name('pendaftaran-lanjutan.store');

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';