<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CamabaController;
use App\Http\Controllers\Camaba\ExamScheduleController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\ExamScheduleAdminController;
use App\Http\Controllers\Admin\AdminExamController;
use App\Models\Registration; // ✅ FIX: gunakan model baru

/*
|--------------------------------------------------------------------------
| MAIN PAGE
|--------------------------------------------------------------------------
*/
Route::get('/', function () {
    return view('welcome');
});

/*
|--------------------------------------------------------------------------
| UNIVERSAL DASHBOARD
|--------------------------------------------------------------------------
*/
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('admin.dashboard');
    } elseif ($user->hasRole('camaba')) {
        return redirect()->route('camaba.dashboard');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| PUBLIC DASHBOARD STATS (API)
|--------------------------------------------------------------------------
*/
Route::get('/api/dashboard-stats', function () {
    return response()->json([
        'total' => Registration::count(),
        'not_taken' => Registration::where('status_ujian', 'belum')->count(),
        'completed' => Registration::where('status_ujian', 'selesai')->count(),
    ]);
});

/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('admin')->name('admin.')->middleware(['auth', 'role:admin'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('admin.dashboard'))->name('dashboard');

    // Registration Management
    Route::get('/registration', [AdminRegistrationController::class, 'index'])->name('registration');
    Route::get('/registration/{id}', [AdminRegistrationController::class, 'show'])->name('registration.detail');
    Route::post('/registration/{id}/exam-status', [AdminRegistrationController::class, 'updateExamStatus'])->name('registration.update-status');
    Route::get('/registration/print/all', [AdminRegistrationController::class, 'print'])->name('registration.print');
    Route::get('/registration/export/excel', [AdminRegistrationController::class, 'export'])->name('registration.export');

    // Exam Schedule
    Route::get('/exam-schedule', [ExamScheduleAdminController::class, 'index'])->name('exam-schedule');
    Route::get('/exam-schedule/create', [ExamScheduleAdminController::class, 'create'])->name('exam-schedule.create');
    Route::post('/exam-schedule', [ExamScheduleAdminController::class, 'store'])->name('exam-schedule.store');
    Route::get('/exam-schedule/{id}/edit', [ExamScheduleAdminController::class, 'edit'])->name('exam-schedule.edit');
    Route::put('/exam-schedule/{id}', [ExamScheduleAdminController::class, 'update'])->name('exam-schedule.update');
    Route::delete('/exam-schedule/{id}', [ExamScheduleAdminController::class, 'destroy'])->name('exam-schedule.destroy');

    // Exam Notifications & Approval
    Route::get('/exam/notifications', [AdminExamController::class, 'notifications'])->name('exam.notifications');
    Route::post('/exam/{id}/approve', [AdminExamController::class, 'approve'])->name('exam.approve');
    Route::post('/exam/{id}/reject', [AdminExamController::class, 'reject'])->name('exam.reject');
    Route::post('/exam/bulk-approve', [AdminExamController::class, 'bulkApprove'])->name('exam.bulk-approve');
});

/*
/*
|--------------------------------------------------------------------------
| CAMABA ROUTES
|--------------------------------------------------------------------------
*/
Route::prefix('camaba')->name('camaba.')->middleware(['auth', 'role:camaba'])->group(function () {

    // Dashboard
    Route::get('/dashboard', fn() => view('camaba.dashboard'))->name('dashboard');

    // --- Registration ---
    Route::get('/registration', fn() => view('camaba.registration'))->name('registration');
    Route::post('/registration', [CamabaController::class, 'store'])->name('registration.store');
    Route::get('/advanced-registration', [CamabaController::class, 'pendaftaranLanjutan'])->name('registration.advanced');

    // --- Personal Data ---
    Route::get('/personal-data', [CamabaController::class, 'showPersonalData'])->name('personal-data.show');
    Route::post('/personal-data', [CamabaController::class, 'savePersonalData'])->name('personal-data.save');

    // --- Education Data ---
    Route::get('/education-data', [CamabaController::class, 'showEducationData'])->name('education-data.show');
    Route::post('/education-data', [CamabaController::class, 'saveEducationData'])->name('education-data.save');

    // --- Family Data ---
    Route::get('/family-data', [CamabaController::class, 'showFamilyData'])->name('family-data.show');
    Route::post('/family-data', [CamabaController::class, 'saveFamilyData'])->name('family-data.save');

    // --- Entry Path ---
    Route::get('/entry-path', [CamabaController::class, 'formEntryPath'])->name('entry-path');
    Route::post('/entry-path', [CamabaController::class, 'saveEntryPath'])->name('entry-path.save');

    // --- Study Program ---
    Route::get('/study-program', [CamabaController::class, 'formStudyProgram'])->name('study-program');
    Route::post('/study-program', [CamabaController::class, 'saveStudyProgram'])->name('study-program.save');

    // --- Exam Schedule ---
    Route::get('/exam-schedule', [ExamScheduleController::class, 'index'])->name('exam-schedule');
    Route::post('/exam-schedule', [ExamScheduleController::class, 'store'])->name('exam-schedule.store');
});


/*
|--------------------------------------------------------------------------
| AUTH ROUTES
|--------------------------------------------------------------------------
*/
require __DIR__ . '/auth.php';
