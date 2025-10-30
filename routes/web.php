<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CamabaController;
use App\Http\Controllers\Camaba\ExamScheduleController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\ExamScheduleAdminController;
use App\Http\Controllers\Admin\AdminExamController; // ← TAMBAHAN BARU

// ================== MAIN PAGE ==================
Route::get('/', function () {
    return view('welcome');
});

// ================== UNIVERSAL DASHBOARD ==================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('camaba')) {
        return redirect()->route('dashboard.camaba');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// ================== PUBLIC DASHBOARD STATS (API) ==================
Route::get('/api/dashboard-stats', function () {
    return response()->json([
        'total' => \App\Models\Pendaftar::count(),
        'not_taken' => \App\Models\Pendaftar::where('status_ujian', 'belum')->count(),
        'completed' => \App\Models\Pendaftar::where('status_ujian', 'selesai')->count(),
    ]);
});

// ================== ADMIN ==================
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // ================== REGISTRATION ==================
    Route::get('/registration', [AdminRegistrationController::class, 'index'])->name('registration');
    Route::get('/registration/{id}', [AdminRegistrationController::class, 'show'])->name('registration.detail');
    Route::post('/registration/{id}/exam-status', [AdminRegistrationController::class, 'updateExamStatus'])->name('registration.update-status');
    Route::get('/registration/print/all', [AdminRegistrationController::class, 'print'])->name('registration.print');
    Route::get('/registration/export/excel', [AdminRegistrationController::class, 'export'])->name('registration.export');

    // ================== EXAM SCHEDULE ==================
    Route::get('/exam-schedule', [ExamScheduleAdminController::class, 'index'])->name('exam-schedule');
    Route::get('/exam-schedule/create', [ExamScheduleAdminController::class, 'create'])->name('exam-schedule.create');
    Route::post('/exam-schedule', [ExamScheduleAdminController::class, 'store'])->name('exam-schedule.store');
    Route::get('/exam-schedule/{id}/edit', [ExamScheduleAdminController::class, 'edit'])->name('exam-schedule.edit');
    Route::put('/exam-schedule/{id}', [ExamScheduleAdminController::class, 'update'])->name('exam-schedule.update');
    Route::delete('/exam-schedule/{id}', [ExamScheduleAdminController::class, 'destroy'])->name('exam-schedule.destroy');

    // ================== EXAM NOTIFICATIONS & APPROVAL (TAMBAHAN BARU) ==================
    Route::get('exam/notifications', [AdminExamController::class, 'notifications'])->name('exam.notifications');
    Route::post('exam/{id}/approve', [AdminExamController::class, 'approve'])->name('exam.approve');
    Route::post('exam/{id}/reject', [AdminExamController::class, 'reject'])->name('exam.reject');
    Route::post('exam/bulk-approve', [AdminExamController::class, 'bulkApprove'])->name('exam.bulk-approve');
});

// ================== CAMABA ==================

    Route::middleware(['auth', 'role:camaba'])->group(function() {
    Route::get('/exam-schedule', [ExamScheduleController::class, 'index'])->name('exam.schedule');
    Route::post('/exam-schedule', [ExamScheduleController::class, 'store'])->name('exam.schedule.store');
    Route::get('/dashboard/camaba', fn() => view('camaba.dashboard'))->name('dashboard.camaba');

    Route::get('/camaba/registration', fn() => view('camaba.registration'))->name('registration');
    Route::post('/camaba/registration', [CamabaController::class, 'store'])->name('registration.store');

    Route::get('/camaba/advanced-registration', [CamabaController::class, 'advancedRegistration'])->name('registration.advanced');

    // Entry path & study program data
    Route::get('/camaba/entry-path', [CamabaController::class, 'formEntryPath'])->name('camaba.entry-path');
    Route::post('/camaba/entry-path', [CamabaController::class, 'saveEntryPath'])->name('camaba.entry-path.save');

    Route::get('/camaba/study-program', [CamabaController::class, 'formStudyProgram'])->name('camaba.study-program');
    Route::post('/camaba/study-program', [CamabaController::class, 'saveStudyProgram'])->name('camaba.study-program.save');

    Route::post('/camaba/personal-data', [CamabaController::class, 'savePersonalData'])->name('camaba.personal-data.save');
    Route::post('/camaba/education-data', [CamabaController::class, 'saveEducationData'])->name('camaba.education-data.save');
    Route::post('/camaba/family-data', [CamabaController::class, 'saveFamilyData'])->name('camaba.family-data.save');

    // Exam schedule (camaba)
    Route::get('/exam-schedule', [ExamScheduleController::class, 'index'])->name('exam.schedule');
    Route::get('/exam-schedule', [ExamScheduleController::class, 'index'])->name('exam.schedule');

});

// ================== PROFILE ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ================== AUTH ==================
require __DIR__ . '/auth.php';
