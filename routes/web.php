<?php

use App\Http\Controllers\ClassCatController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ClassSessionsController;
use App\Http\Controllers\EmployeesController;
use App\Http\Controllers\FileController;
// use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\QuestionController;
use App\Http\Controllers\QuestionsController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\StudyCatController;
use App\Http\Controllers\StudyDetController;
use App\Http\Controllers\StudyMatController;
use App\Http\Controllers\TestCatController;
use App\Http\Controllers\TestsController;
use App\Http\Controllers\TrainCtController;
use App\Http\Controllers\TrainCtsController;
use App\Http\Controllers\TrainersController;
use App\Http\Controllers\UsersController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    // Employees
    Route::controller(EmployeesController::class)->group(function () {
        Route::get('employees/index/{employees_kywd?}', 'index')->middleware(['permission:list pegawai'])->name('employees');
        // Route::post('participant/delete', 'delete')->middleware(['permissoin:delete pegawai'])->name('participant.delete');
        // Route::post('participant/recover', 'recover')->middleware(['permissoin:delete pegawai'])->name('participant.recover');
    });

    // Participants
    Route::controller(ParticipantsController::class)->group(function () {
        Route::get('participant/index/{participant_kywd?}', 'index')->middleware(['permission:list peserta'])->name('participant');
        // Route::post('participant/delete', 'delete')->middleware(['permissoin:delete pegawai'])->name('participant.delete');
        // Route::post('participant/recover', 'recover')->middleware(['permissoin:delete pegawai'])->name('participant.recover');
    });
    // Training Centers
    Route::controller(TrainCtsController::class)->group(function () {
        Route::get('traincts/index/{traincts_kywd?}', 'index')->middleware(['permission:list pusat pelatihan'])->name('traincts');
        Route::get('traincts/create', 'create')->middleware(['permission:create pusat pelatihan'])->name('traincts.create');
        Route::post('traincts/store', 'store')->middleware(['permission:create pusat pelatihan'])->name('traincts.store');
        Route::get('traincts/edit/{id}', 'edit')->middleware(['permission:edit pusat pelatihan'])->name('traincts.edit');
        Route::post('traincts/update/{id}', 'update')->middleware(['permission:edit pusat pelatihan'])->name('traincts.update');
        Route::post('traincts/delete', 'delete')->middleware(['permission:delete pusat pelatihan'])->name('traincts.delete');
        Route::post('traincts/recover', 'recover')->middleware(['permission:delete pusat pelatihan'])->name('traincts.recover');
    });
    // Instruktur / Pelatih
    Route::controller(TrainersController::class)->group(function () {
        Route::get('trainers/index/{trainers_kywd?}', 'index')->middleware(['permission:list pelatih'])->name('trainers');
        Route::get('trainers/create', 'create')->middleware(['permission:create pelatih'])->name('trainers.create');
        Route::post('trainers/selectpicker', 'trainers_selectpicker')->middleware(['permission:create pelatih|edit pelatih'])->name('trainers.selectpicker');
        Route::post('trainers/store', 'store')->middleware(['permission:create pelatih'])->name('trainers.store');
        Route::get('trainers/edit/{id}', 'edit')->middleware(['permission:edit pelatih'])->name('trainers.edit');
        Route::post('trainers/update/{id}', 'update')->middleware(['permission:edit pelatih'])->name('trainers.update');
        Route::post('trainers/delete', 'delete')->middleware(['permission:delete pelatih'])->name('trainers.delete');
        Route::post('trainers/recover', 'recover')->middleware(['permission:delete pelatih'])->name('trainers.recover');
    });
    // Classes Category
    Route::controller(ClassCatController::class)->group(function () {
        Route::get('classcat/index/{classcat_kywd?}', 'index')->middleware(['permission:list kategori kelas'])->name('classcat');
        Route::get('classcat/create', 'create')->middleware(['permission:create kategori kelas'])->name('classcat.create');
        Route::post('classcat/store', 'store')->middleware(['permission:create kategori kelas'])->name('classcat.store');
        Route::get('classcat/edit/{id}', 'edit')->middleware(['permission:edit kategori kelas'])->name('classcat.edit');
        Route::post('classcat/update/{id}', 'update')->middleware(['permission:edit kategori kelas'])->name('classcat.update');
        Route::post('classcat/delete', 'delete')->middleware(['permission:delete kategori kelas'])->name('classcat.delete');
        Route::post('classcat/recover', 'recover')->middleware(['permission:delete kategori kelas'])->name('classcat.recover');
    });
    // Classes
    Route::controller(ClassesController::class)->group(function () {
        Route::get('classes/index/{classes_kywd?}', 'index')->middleware(['permission:list master kelas'])->name('classes');
        Route::get('classes/create', 'create')->middleware(['permission:create master kelas'])->name('classes.create');
        Route::post('classes/store', 'store')->middleware(['permission:create master kelas'])->name('classes.store');
        Route::get('classes/edit/{id}', 'edit')->middleware(['permission:edit master kelas'])->name('classes.edit');
        Route::post('classes/update/{id}', 'update')->middleware(['permission:edit master kelas'])->name('classes.update');
        Route::post('classes/delete', 'delete')->middleware(['permission:delete master kelas'])->name('classes.delete');
        Route::post('classes/recover', 'recover')->middleware(['permission:delete master kelas'])->name('classes.recover');
    });
    // Class Sessions
    Route::controller(ClassSessionsController::class)->group(function () {
        Route::get('class_sessions/index/{class_sessions_kywd?}', 'index')->middleware(['permission:list sesi kelas'])->name('class_sessions');
        Route::get('class_sessions/create', 'create')->middleware(['permission:create sesi kelas'])->name('class_sessions.create');
        Route::post('class_sessions/participant_selectpicker', 'participant_selectpicker')->middleware(['permission:create sesi kelas|edit sesi kelas'])->name('class_sessions.participant_selectpicker');
        Route::post('class_sessions/store', 'store')->middleware(['permission:create sesi kelas'])->name('class_sessions.store');
        Route::get('class_sessions/edit/{id}', 'edit')->middleware(['permission:edit sesi kelas'])->name('class_sessions.edit');
        Route::post('class_sessions/update/{id}', 'update')->middleware(['permission:edit sesi kelas'])->name('class_sessions.update');
        Route::post('class_sessions/delete', 'delete')->middleware(['permission:delete sesi kelas'])->name('class_sessions.delete');
        Route::post('class_sessions/recover', 'recover')->middleware(['permission:delete sesi kelas'])->name('class_sessions.recover');
    });
    // Studies Category
    Route::controller(StudyCatController::class)->group(function () {
        Route::get('studycat/index/{studycat_kywd?}', 'index')->middleware(['permission:list kategori materi'])->name('studycat');
        Route::get('studycat/create', 'create')->middleware(['permission:create kategori materi'])->name('studycat.create');
        Route::post('studycat/store', 'store')->middleware(['permission:create kategori materi'])->name('studycat.store');
        Route::get('studycat/edit/{id}', 'edit')->middleware(['permission:edit kategori materi'])->name('studycat.edit');
        Route::post('studycat/update/{id}', 'update')->middleware(['permission:edit kategori materi'])->name('studycat.update');
        Route::post('studycat/delete', 'delete')->middleware(['permission:delete kategori materi'])->name('studycat.delete');
        Route::post('studycat/recover', 'recover')->middleware(['permission:delete kategori materi'])->name('studycat.recover');
    });
    // Studies
    Route::controller(StudiesController::class)->group(function () {
        Route::get('studies/index/{studies_kywd?}', 'index')->middleware(['permission:list bank materi'])->name('studies');
        Route::get('studies/create', 'create')->middleware(['permission:create bank materi'])->name('studies.create');
        Route::post('studies/store', 'store')->middleware(['permission:create bank materi'])->name('studies.store');
        Route::get('studies/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studies.edit');
        Route::post('studies/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studies.update');
        Route::post('studies/delete', 'delete')->middleware(['permission:delete bank materi'])->name('studies.delete');
        Route::post('studies/recover', 'recover')->middleware(['permission:delete bank materi'])->name('studies.recover');
    });
    // Studies Detail (permission is same as bank materi)
    Route::controller(StudyDetController::class)->group(function () {
        Route::get('studydet/create', 'create')->middleware(['permission:create bank materi'])->name('studydet.create');
        Route::post('studydet/store', 'store')->middleware(['permission:create bank materi'])->name('studydet.store');
        Route::get('studydet/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studydet.edit');
        Route::post('studydet/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studydet.update');
        Route::post('studydet/delete', 'delete')->middleware(['permission:delete bank materi'])->name('studydet.delete');
        Route::post('studydet/recover', 'recover')->middleware(['permission:delete bank materi'])->name('studydet.recover');
        Route::get('studydet/attachment', 'attachment')->name('studydet.attachment');
        Route::get('studydet/getdeleted', 'get_deleted')->name('studydet.getdeleted');
    });
    // Test Category
    Route::controller(TestCatController::class)->group(function () {
        Route::get('testcat/index/{testcat_kywd?}', 'index')->middleware(['permission:list kategori tes'])->name('testcat');
        Route::get('testcat/create', 'create')->middleware(['permission:create kategori tes'])->name('testcat.create');
        Route::post('testcat/store', 'store')->middleware(['permission:create kategori tes'])->name('testcat.store');
        Route::get('testcat/edit/{id}', 'edit')->middleware(['permission:edit kategori tes'])->name('testcat.edit');
        Route::post('testcat/update/{id}', 'update')->middleware(['permission:edit kategori tes'])->name('testcat.update');
        Route::post('testcat/delete', 'delete')->middleware(['permission:delete kategori tes'])->name('testcat.delete');
        Route::post('testcat/recover', 'recover')->middleware(['permission:delete kategori tes'])->name('testcat.recover');
    });
    // Tests
    Route::controller(TestsController::class)->group(function () {
        Route::get('tests/index/{tests_kywd?}', 'index')->middleware(['permission:list tes'])->name('tests');
        Route::get('tests/create', 'create')->middleware(['permission:create tes'])->name('tests.create');
        Route::post('tests/store', 'store')->middleware(['permission:create tes'])->name('tests.store');
        Route::get('tests/edit/{id}', 'edit')->middleware(['permission:edit tes'])->name('tests.edit');
        Route::post('tests/update/{id}', 'update')->middleware(['permission:edit tes'])->name('tests.update');
        Route::post('tests/delete', 'delete')->middleware(['permission:delete tes'])->name('tests.delete');
        Route::post('tests/recover', 'recover')->middleware(['permission:delete tes'])->name('tests.recover');
    });
    // Questions
    Route::controller(QuestionsController::class)->group(function () {
        Route::get('questions/index/{questions_kywd?}', 'index')->middleware(['permission:list pertanyaan'])->name('questions');
        Route::get('questions/create', 'create')->middleware(['permission:create pertanyaan'])->name('questions.create');
        Route::post('questions/store', 'store')->middleware(['permission:create pertanyaan'])->name('questions.store');
        Route::get('questions/edit/{id}', 'edit')->middleware(['permission:edit pertanyaan'])->name('questions.edit');
        Route::post('questions/update/{id}', 'update')->middleware(['permission:edit pertanyaan'])->name('questions.update');
        Route::post('questions/delete', 'delete')->middleware(['permission:delete pertanyaan'])->name('questions.delete');
        Route::post('questions/recover', 'recover')->middleware(['permission:delete pertanyaan'])->name('questions.recover');
    });
    // File
    Route::controller(FileController::class)->group(function () {
        Route::post('file/uploadatt', 'upload_study_attachment')->name('file.upload_studyatt');
    });
    // Users
    Route::controller(UsersController::class)->group(function () {
        Route::get('users/index/{users_kywd?}', 'index')->name('users');
        Route::get('users/edit/{id}', 'edit')->middleware(['permission:edit users'])->name('users.edit');
        Route::post('users/update/{id}', 'update')->middleware(['permission:edit users'])->name('users.update');
        Route::post('users/delete', 'delete')->name('users.delete');
    });
    // Roles
    Route::controller(RolesController::class)->group(function () {
        Route::get('roles/index/{roles_kywd?}', 'index')->middleware(['permission:list roles'])->name('roles');
        Route::get('roles/create', 'create')->middleware(['permission:create roles'])->name('roles.create');
        Route::post('roles/store', 'store')->middleware(['permission:create roles'])->name('roles.store');
        Route::get('roles/edit/{id}', 'edit')->middleware(['permission:edit roles'])->name('roles.edit');
        Route::post('roles/update/{id}', 'update')->middleware(['permission:edit roles'])->name('roles.update');
        Route::post('roles/delete', 'delete')->middleware(['permission:delete roles'])->name('roles.delete');
    });
    // Permissions
    Route::controller(PermissionController::class)->group(function () {
        Route::get('permissions/index/{permissions_kywd?}', 'index')->middleware(['permission:list permissions'])->name('permissions');
        Route::get('permissions/create/', 'create')->middleware(['permission:create permissions'])->name('permissions.create');
        Route::post('permissions/store/', 'store')->middleware(['permission:create permissions'])->name('permissions.store');
        Route::get('permissions/edit/{id}', 'edit')->middleware(['permission:edit permissions'])->name('permissions.edit');
        Route::post('permissions/update/{id}', 'update')->middleware(['permission:edit permissions'])->name('permissions.update');
        Route::post('permissions/delete', 'delete')->middleware(['permission:delete permissions'])->name('permissions.delete');
    });
});

require __DIR__ . '/auth.php';
