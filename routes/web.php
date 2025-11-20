<?php

use Illuminate\Support\Facades\Route;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AdminExamController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\ExamScheduleAdminController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\QuestionGroupController;;
use App\Http\Controllers\AdmissionPathController;
use App\Http\Controllers\Admin\AdminResultController;


// CAMABA CONTROLLERS
use App\Http\Controllers\Camaba\ExamController;
use App\Http\Controllers\Camaba\CamabaController as CamabaCamabaController;
use App\Http\Controllers\Camaba\ExamScheduleController;
use App\Http\Controllers\Camaba\JadwalUjianController;

// PROFILE
use App\Http\Controllers\ProfileController;

Route::get('/', function () {
    return view('welcome');
});

// ================== UNIVERSAL DASHBOARD ==================
Route::get('/dashboard', function () {
    $user = auth()->user();

    if ($user->hasRole('admin')) {
        return redirect()->route('dashboard.admin');
    }

    if ($user->hasRole('camaba')) {
        return redirect()->route('dashboard.camaba');
    }

    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');


// ================== ADMIN ==================
Route::middleware(['auth', 'role:admin'])->group(function () {

    // ----- DASHBOARD -----
    Route::get('/dashboard/admin', fn() => view('admin.dashboard'))
        ->name('dashboard.admin');

    Route::get('/admin/dashboard/stats', [App\Http\Controllers\Admin\AdminDashboardController::class, 'getStats'])
    ->name('admin.dashboard.stats');

    // ----- PROFILE ADMIN -----
    Route::prefix('admin')->name('admin.')->group(function () {
        Route::get('/profile', [AdminProfileController::class, 'index'])->name('profile');
        Route::get('/profile/edit', [AdminProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [AdminProfileController::class, 'update'])->name('profile.update');
        Route::get('/profile/change-password', [AdminProfileController::class, 'changePassword'])->name('profile.change-password');

        // ----- QUESTIONS -----
        Route::resource('questions', QuestionController::class);
    });

    // ----- REGISTRATION -----
    Route::get('/admin/registration', [AdminRegistrationController::class, 'index'])->name('admin.registration');
    Route::get('/admin/registration/{id}', [AdminRegistrationController::class, 'show'])->name('admin.registration.show');
    Route::post('/admin/registration/{id}/exam-status', [AdminRegistrationController::class, 'updateExamStatus'])->name('admin.registration.update-status');
    Route::get('/admin/registration/print/all', [AdminRegistrationController::class, 'print'])->name('admin.registration.print');
    Route::get('/admin/registration/export/excel', [AdminRegistrationController::class, 'export'])->name('admin.registration.export');

    // ----- EXAM SCHEDULE ADMIN -----
    Route::get('/admin/exam-schedule', [ExamScheduleAdminController::class, 'index'])->name('admin.exam-schedule-admin');
    Route::get('/admin/exam-schedule/create', [ExamScheduleAdminController::class, 'create'])->name('admin.exam-schedule-create');
    Route::post('/admin/exam-schedule', [ExamScheduleAdminController::class, 'store'])->name('admin.exam-schedule-store');
    Route::get('/admin/exam-schedule/{id}/edit', [ExamScheduleAdminController::class, 'edit'])->name('admin.exam-schedule-edit');
    Route::put('/admin/exam-schedule/{id}', [ExamScheduleAdminController::class, 'update'])->name('admin.exam-schedule-update');
    Route::delete('/admin/exam-schedule/{id}', [ExamScheduleAdminController::class, 'destroy'])->name('admin.exam-schedule-destroy');

    //=================== QUESTION ======================
    Route::middleware(['auth'])->prefix('admin')->name('admin.')->group(function () {
        // Question Groups
    Route::resource('question-groups', QuestionGroupController::class);
    Route::resource('questions', QuestionController::class);
    });
    //notification
    Route::get('/exam/notifications', [AdminExamController::class, 'notifications'])->name('exam.notifications');
    Route::post('/exam/{id}/approve', [AdminExamController::class, 'approve'])->name('admin.exam.approve');
    Route::post('/exam/{id}/reject', [AdminExamController::class, 'reject'])->name('admin.exam.reject');
    Route::post('/exam/bulk-approve', [AdminExamController::class, 'bulkApprove'])->name('admin.exam.bulk-approve');

    Route::get('/admin/results', [AdminResultController::class, 'index'])->name('admin.results');
    Route::get('/admin/results/print', [AdminResultController::class, 'print'])->name('admin.results.print');
});


// ================== CAMABA ==================
Route::middleware(['auth', 'role:camaba'])->group(function () {

    Route::get('/dashboard/camaba', fn() => view('camaba.dashboard'))->name('dashboard.camaba');

    // ----- NOTIFIKASI CAMABA -----
    Route::get('/camaba/notifications', [ExamScheduleController::class, 'notifications'])
        ->name('camaba.notifications');
    
    // Mulai Ujian (POST)
    Route::post('/camaba/exam/start', [ExamController::class, 'start'])->name('exam.start');

    Route::get('/camaba/exam/{examScheduleId}/questions', [ExamController::class, 'questions'])
    ->name('exam.questions');

    Route::post('/camaba/exam/{examScheduleId}/submit', [ExamController::class, 'submit'])
    ->name('exam.submit');

    Route::get('/camaba/exam/{examScheduleId}/result', [ExamController::class, 'result'])
    ->name('exam.result');

    Route::delete('/camaba/notifications/{id}', [ExamScheduleController::class, 'deleteNotification'])
    ->name('notifikasi.delete');


    // ----- REGISTRATION -----
    Route::get('/camaba/registration', fn() => view('camaba.registration'))->name('camaba.registration');
    Route::post('/camaba/registration', [CamabaCamabaController::class, 'store'])->name('camaba.registration.store');

    Route::get('/camaba/registration-advanced', [CamabaCamabaController::class, 'pendaftaranLanjutan'])->name('camaba.registration-advanced');

    Route::post('/camaba/data-jalur', [CamabaCamabaController::class, 'simpanJalurMasuk'])->name('camaba.data-jalur.simpan');
    Route::post('/camaba/data-prodi', [CamabaCamabaController::class, 'simpanProgramStudi'])->name('camaba.data-prodi.simpan');
    Route::post('/camaba/personal-data', [CamabaCamabaController::class, 'simpanDataDiri'])->name('camaba.personal-data.save');
    Route::post('/camaba/education-data', [CamabaCamabaController::class, 'simpanDataPendidikan'])->name('camaba.education-data.save');
    Route::post('/camaba/family-data', [CamabaCamabaController::class, 'simpanDataKeluarga'])->name('camaba.family-data.save');

    // ----- JADWAL UJIAN -----
    Route::get('/camaba/exam-schedule', [ExamScheduleController::class, 'index'])->name('camaba.exam-schedule');
    Route::post('/camaba/exam-schedule', [ExamScheduleController::class, 'store'])->name('camaba.exam-schedule.store');

    // ----- UJIAN -----
    Route::get('/camaba/exam', [ExamController::class, 'index'])->name('camaba.exam');
    Route::post('/exam/start', [ExamController::class, 'start'])->name('ujian.start');
    Route::get('/exam/{examScheduleId}/questions', [ExamController::class, 'questions'])->name('ujian.questions');
    Route::post('/exam/{examScheduleId}/answer', [ExamController::class, 'answer'])->name('ujian.answer');
    Route::post('/exam/{examScheduleId}/submit', [ExamController::class, 'submit'])->name('ujian.submit');
    Route::get('/exam/{examScheduleId}/result', [ExamController::class, 'result'])->name('ujian.result');
});


// ================== PROFILE UNIVERSAL ==================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

require __DIR__ . '/auth.php';
