<?php

use Illuminate\Support\Facades\Route;

// ADMIN CONTROLLERS
use App\Http\Controllers\Admin\AdminExamController;
use App\Http\Controllers\Admin\AdminRegistrationController;
use App\Http\Controllers\Admin\ExamScheduleAdminController;
use App\Http\Controllers\Admin\QuestionController;
use App\Http\Controllers\Admin\ProfileController as AdminProfileController;
use App\Http\Controllers\Admin\QuestionGroupController;
use App\Http\Controllers\Admin\AdminResultController;

// CAMABA CONTROLLERS
use App\Http\Controllers\Camaba\ExamController;
use App\Http\Controllers\Camaba\CamabaController;
use App\Http\Controllers\Camaba\ExamScheduleController;
use App\Http\Controllers\Camaba\NotificationCamabaController;
// PROFILE
use App\Http\Controllers\ProfileController;


/*
|--------------------------------------------------------------------------
| LANDING PAGE
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
        return redirect()->route('dashboard.admin');
    }

    if ($user->hasRole('camaba')) {
        return redirect()->route('camaba.dashboard');
    }

    return view('dashboard');

})->middleware(['auth', 'verified'])->name('dashboard');


/*
|--------------------------------------------------------------------------
| ADMIN ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:admin'])->group(function () {

    Route::get('/dashboard/admin', fn() => view('admin.dashboard'))
        ->name('dashboard.admin');

    Route::get('/admin/dashboard/stats',
        [App\Http\Controllers\Admin\AdminDashboardController::class, 'getStats']
    )->name('admin.dashboard.stats');


    /*
    | PROFILE ADMIN
    */

    Route::prefix('admin')->name('admin.')->group(function () {

        Route::get('/profile',
            [AdminProfileController::class, 'index']
        )->name('profile');

        Route::get('/profile/edit',
            [AdminProfileController::class, 'edit']
        )->name('profile.edit');

        Route::put('/profile',
            [AdminProfileController::class, 'update']
        )->name('profile.update');

        Route::get('/profile/change-password',
            [AdminProfileController::class, 'changePassword']
        )->name('profile.change-password');


        /*
        | QUESTION GROUPS + QUESTIONS
        */

        Route::resource('question-groups',
            QuestionGroupController::class
        );

        Route::resource('questions',
            QuestionController::class);

    });


    /*
    | REGISTRATION ADMIN
    */


    Route::get('/admin/registration',
        [AdminRegistrationController::class, 'index']
    )->name('admin.registration');

    Route::get('/admin/registration/{id}',
        [AdminRegistrationController::class, 'show']
    )->name('admin.registration.show');

    Route::post('/admin/registration/{id}/exam-status',
        [AdminRegistrationController::class, 'updateExamStatus']
    )->name('admin.registration.update-status');

    Route::get('/admin/registration/{id}/pdf', [App\Http\Controllers\Admin\AdminRegistrationController::class, 'downloadPdf'])
    ->name('admin.registration.pdf');

    Route::get('/admin/registration/print/all',
        [AdminRegistrationController::class, 'print']
    )->name('admin.registration.print');

    Route::get('/admin/registration/export/excel',
        [AdminRegistrationController::class, 'export']
    )->name('admin.registration.export');


    /*
    | EXAM SCHEDULE ADMIN
    */

    Route::get('/admin/exam-schedule',
        [ExamScheduleAdminController::class, 'index']
    )->name('admin.exam-schedule-admin');

    Route::get('/admin/exam-schedule/create',
        [ExamScheduleAdminController::class, 'create']
    )->name('admin.exam-schedule-create');

    Route::post('/admin/exam-schedule',
        [ExamScheduleAdminController::class, 'store']
    )->name('admin.exam-schedule-store');

    Route::get('/admin/exam-schedule/{id}/edit',
        [ExamScheduleAdminController::class, 'edit']
    )->name('admin.exam-schedule-edit');

    Route::put('/admin/exam-schedule/{id}',
        [ExamScheduleAdminController::class, 'update']
    )->name('admin.exam-schedule-update');

    Route::delete('/admin/exam-schedule/{id}',
        [ExamScheduleAdminController::class, 'destroy']
    )->name('admin.exam-schedule-destroy');


    /*
    | EXAM APPROVAL
    */

    Route::get('/exam/notifications',
        [AdminExamController::class, 'notifications']
    )->name('exam.notifications');

    Route::post('/exam/{id}/approve',
        [AdminExamController::class, 'approve']
    )->name('admin.exam.approve');

    Route::post('/exam/{id}/reject',
        [AdminExamController::class, 'reject']
    )->name('admin.exam.reject');

    Route::post('/exam/bulk-approve',
        [AdminExamController::class, 'bulkApprove']
    )->name('admin.exam.bulk-approve');


    /*
    | RESULT ADMIN
    */

    Route::get('/admin/results',
        [AdminResultController::class, 'index']
    )->name('admin.results');

    Route::get('/admin/results/print',
        [AdminResultController::class, 'print']
    )->name('admin.results.print');

    Route::get('/admin/results/export-excel',
        [AdminResultController::class, 'exportExcel']
    )->name('admin.results.excel');

});


/*
|--------------------------------------------------------------------------
| CAMABA ROUTES
|--------------------------------------------------------------------------
*/

/*
|--------------------------------------------------------------------------
| CAMABA ROUTES
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'role:camaba'])
->prefix('camaba')
->name('camaba.')
->group(function () {

    // ======================
    // DASHBOARD
    // ======================
    Route::get('/dashboard', fn() => view('camaba.dashboard'))
        ->name('dashboard');


    // ======================
    // NOTIFICATIONS
    // ======================
    Route::get('/notifications',
        [NotificationCamabaController::class, 'index']
    )->name('notifications');

    Route::delete('/notifications/{id}',
        [NotificationCamabaController::class, 'delete']
    )->name('notifications.delete');


    // ======================
    // REGISTRATION AWAL
    // ======================
   Route::get('/registration',
    [CamabaController::class, 'registration']
)->name('registration');

    // ======================
    // FORM DATA DIRI
    // ======================
    Route::post('/personal-data/save',
        [CamabaController::class,'simpanDataDiri']
    )->name('personal-data.save');

    Route::post('/education-data/save',
        [CamabaController::class,'simpanDataPendidikan']
    )->name('education-data.save');

    Route::post('/family-data/save',
        [CamabaController::class,'simpanDataKeluarga']
    )->name('family-data.save');


    // ======================
    // FORM LANJUTAN
    // ======================
   Route::get('/registration-advanced',
    [CamabaController::class, 'pendaftaranLanjutan']
)->name('registration-advanced');

    Route::post('/admission-path/save',
        [CamabaController::class,'simpanJalurMasuk']
    )->name('admission-path.save');

    Route::post('/program-selection/save',
        [CamabaController::class,'simpanProgramStudi']
    )->name('program-selection.save');


    // ======================
    // JADWAL UJIAN
    // ======================
    Route::get('/exam-schedule',
        [ExamScheduleController::class, 'index']
    )->name('exam-schedule');

    Route::post('/exam-schedule',
        [ExamScheduleController::class, 'store']
    )->name('exam-schedule.store');


    // ======================
    // EXAM FEATURE
    // ======================
    Route::prefix('exam')->name('exam.')->group(function () {

        Route::get('/',
            [ExamController::class, 'index']
        )->name('index');

        Route::get('/start/{group}/{tes?}',
            [ExamController::class, 'showExam']
        )->name('start');

        Route::post('/start',
            [ExamController::class, 'start']
        )->name('begin');

        Route::get('/questions/{examId}/{groupId}',
            [ExamController::class, 'questions']
        )->name('questions');

        Route::post('/{examId}/save-answer',
            [ExamController::class, 'saveAnswer'])  
        ->name('saveAnswer');

        Route::post('/submit/{examId}',
            [ExamController::class, 'submit']
        )->name('submit');

        Route::get('/success/{examId}',
            [ExamController::class, 'success']
        )->name('success');

    });

});


/*
|--------------------------------------------------------------------------
| UNIVERSAL PROFILE
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/profile',
        [ProfileController::class, 'edit']
    )->name('profile.edit');

    Route::patch('/profile',
        [ProfileController::class, 'update']
    )->name('profile.update');

    Route::delete('/profile',
        [ProfileController::class, 'destroy']
    )->name('profile.destroy');

});


require __DIR__.'/auth.php';