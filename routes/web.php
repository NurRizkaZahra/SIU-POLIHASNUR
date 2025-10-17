<?php

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

    Route::get('/camaba/pendaftaran', function () {
        return view('camaba.pendaftaran');
    })->name('pendaftaran');

    Route::get('/camaba/jadwal-ujian', function () {
        return view('camaba.jadwal-ujian');
    })->name('jadwal.ujian');
});

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__.'/auth.php';
