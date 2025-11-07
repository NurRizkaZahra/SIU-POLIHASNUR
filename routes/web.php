<?php

use App\Http\Controllers\Admin\AdminExamController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\ExamScheduleAdminController;
use App\Http\Controllers\CamabaController;
use App\Http\Controllers\Camaba\JadwalUjianController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdmissionPathController;
use App\Http\Controllers\Camaba\ExamScheduleController;
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
    // ==================PROFILE ADMIN ==================
    Route::middleware(['auth', 'role:admin'])->group(function () {
    Route::get('/admin/profile', [AdminProfileController::class, 'index'])->name('admin.profile');
    Route::get('/admin/profile/edit', [AdminProfileController::class, 'edit'])->name('admin.profile.edit');
    Route::put('/admin/profile', [AdminProfileController::class, 'update'])->name('admin.profile.update');
    Route::get('/admin/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('admin.profile.change-password');
 });
    // ================== REGISTRATION ==================
    Route::get('/admin/registration', [AdminRegistrationController::class, 'index'])->name('admin.registration');
    Route::get('/admin/registration/{id}', [AdminRegistrationController::class, 'show'])->name('admin.registration.show');
    Route::post('/admin/registration/{id}/exam-status', [AdminRegistrationController::class, 'updateExamStatus'])->name('admin.registration.update-status');
    Route::get('/admin/registration/print/all', [AdminRegistrationController::class, 'print'])->name('admin.registration.print');
    Route::get('/admin/registration/export/excel', [AdminRegistrationController::class, 'export'])->name('admin.registration.export');

    //=================== EXAM SCHEDULE =================
    Route::get('/admin/exam-schedule', [ExamScheduleAdminController::class, 'index'])->name('admin.exam-schedule-admin');
    Route::get('/admin/exam-schedule/create', [ExamScheduleAdminController::class, 'create'])->name('admin.exam-schedule-create');
    Route::post('/admin/exam-schedule', [ExamScheduleAdminController::class, 'store'])->name('admin.exam-schedule-store');
    Route::get('/admin/exam-schedule/{id}/edit', [ExamScheduleAdminController::class, 'edit'])->name('admin.exam-schedule-edit');
    Route::put('/admin/exam-schedule/{id}', [ExamScheduleAdminController::class, 'update'])->name('admin.exam-schedule-update');
    Route::delete('/admin/exam-schedule/{id}', [ExamScheduleAdminController::class, 'destroy'])->name('admin.exam-schedule-destroy');

    //=================== QUESTION ======================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
    Route::resource('questions', QuestionController::class);
    });
    //notification
    Route::get('/exam/notifications', [AdminExamController::class, 'notifications'])->name('exam.notifications');
    Route::post('/exam/{id}/approve', [AdminExamController::class, 'approve'])->name('admin.exam.approve');
    Route::post('/exam/{id}/reject', [AdminExamController::class, 'reject'])->name('admin.exam.reject');
    Route::post('/exam/bulk-approve', [AdminExamController::class, 'bulkApprove'])->name('admin.exam.bulk-approve');
});
// ================== CAMABA ==================
Route::middleware(['auth', 'role:camaba'])->group(function () {
    Route::get('/dashboard/camaba', function () {
        return view('camaba.dashboard');
    })->name('dashboard.camaba');

    // Halaman form pertama
    Route::get('/camaba/registration', function () {
        return view('camaba.registration');
    })->name('camaba.registration');

    // Proses simpan sementara ke session
    Route::post('/camaba/registration', [CamabaController::class, 'store'])
        ->name('camaba.registration.store');

    // Halaman kedua (lanjutan)
    Route::get('/camaba/registration-advanced', [CamabaController::class, 'pendaftaranLanjutan'])
        ->name('camaba.registration-advanced');

     // ----- FORM JALUR MASUK -----
    Route::post('/camaba/data-jalur', [CamabaController::class, 'simpanJalurMasuk'])
        ->name('camaba.data-jalur.simpan');

    // ----- FORM PROGRAM STUDI -----
    Route::post('/camaba/data-prodi', [CamabaController::class, 'simpanProgramStudi'])
        ->name('camaba.data-prodi.simpan');

     // ===== FORM PENDAFTARAN DETAIL =====
    Route::post('/camaba/personal-data', [CamabaController::class, 'simpanDataDiri'])
        ->name('camaba.personal-data.save');

    Route::post('/camaba/education-data', [CamabaController::class, 'simpanDataPendidikan'])
        ->name('camaba.education-data.save');

    Route::post('/camaba/family-data', [CamabaController::class, 'simpanDataKeluarga'])
        ->name('camaba.family-data.save');

    // Jadwal ujian
    Route::get('/camaba/exam-schedule', [ExamScheduleController::class, 'index'])->name('camaba.exam-schedule');
    Route::post('/camaba/exam-schedule', [ExamScheduleController::class, 'store'])->name('camaba.exam-schedule.store');

});

    
// ================== PROFILE ==================
// Route::middleware('auth')->group(function () {
    // Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    // Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    // Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
// });

require __DIR__ . '/auth.php';