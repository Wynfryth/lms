<?php

use App\Http\Controllers\ClassCatController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FileController;
// use App\Http\Controllers\ParticipantController;
use App\Http\Controllers\ParticipantsController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RolesController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\StudyCatController;
use App\Http\Controllers\StudyDetController;
use App\Http\Controllers\StudyMatController;
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

    // Participants
    Route::controller(ParticipantsController::class)->group(function () {
        Route::get('participant/index/{participant_kywd?}', 'index')->middleware(['permission:list pegawai'])->name('participant');
        // Route::post('participant/delete', 'delete')->middleware(['permissoin:delete pegawai'])->name('participant.delete');
        // Route::post('participant/recover', 'recover')->middleware(['permissoin:delete pegawai'])->name('participant.recover');
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
        Route::get('classes/index/{classes_kywd?}', 'index')->middleware(['permission:list kelas'])->name('classes');
        Route::get('classes/create', 'create')->middleware(['permission:create kelas'])->name('classes.create');
        Route::post('classes/store', 'store')->middleware(['permission:create kelas'])->name('classes.store');
        Route::get('classes/edit/{id}', 'edit')->middleware(['permission:edit kelas'])->name('classes.edit');
        Route::post('classes/update/{id}', 'update')->middleware(['permission:edit kelas'])->name('classes.update');
        Route::post('classes/delete', 'delete')->middleware('delete kelas')->name('classes.delete');
        Route::post('classes/recover', 'recover')->middleware('delete kelas')->name('classes.recover');
    });
    // Studies Category
    Route::controller(StudyCatController::class)->group(function () {
        Route::get('studycat/index/{studycat_kywd?}', 'index')->middleware(['permission:list kategori materi'])->name('studycat');
        Route::get('studycat/create', 'create')->middleware(['permission:create kategori materi'])->name('studycat.create');
        Route::post('studycat/store', 'store')->middleware(['permission:create kategori materi'])->name('studycat.store');
        Route::get('studycat/edit/{id}', 'edit')->middleware(['permission:edit kategori materi'])->name('studycat.edit');
        Route::post('studycat/update/{id}', 'update')->middleware(['permission:edit kategori materi'])->name('studycat.update');
        Route::post('studycat/delete', 'delete')->name('studycat.delete');
        Route::post('studycat/recover', 'recover')->name('studycat.recover');
    });
    // Studies
    Route::controller(StudiesController::class)->group(function () {
        Route::get('studies/index/{studies_kywd?}', 'index')->middleware(['permission:list bank materi'])->name('studies');
        Route::get('studies/create', 'create')->middleware(['permission:create bank materi'])->name('studies.create');
        Route::post('studies/store', 'store')->middleware(['permission:create bank materi'])->name('studies.store');
        Route::get('studies/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studies.edit');
        Route::post('studies/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studies.update');
        Route::post('studies/delete', 'delete')->name('studies.delete');
        Route::post('studies/recover', 'recover')->name('studies.recover');
    });
    // Studies Detail (permission is same as bank materi)
    Route::controller(StudyDetController::class)->group(function () {
        Route::get('studydet/create', 'create')->middleware(['permission:create bank materi'])->name('studydet.create');
        Route::post('studydet/store', 'store')->middleware(['permission:create bank materi'])->name('studydet.store');
        Route::get('studydet/edit/{id}', 'edit')->middleware(['permission:edit bank materi'])->name('studydet.edit');
        Route::post('studydet/update/{id}', 'update')->middleware(['permission:edit bank materi'])->name('studydet.update');
        Route::post('studydet/delete', 'delete')->name('studydet.delete');
        Route::post('studydet/recover', 'recover')->name('studydet.recover');
        Route::get('studydet/attachment', 'attachment')->name('studydet.attachment');
        Route::get('studydet/getdeleted', 'get_deleted')->name('studydet.getdeleted');
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
        Route::get('roles/index/{roles_kywd?}', 'index')->name('roles');
        Route::get('roles/create', 'create')->name('roles.create');
        Route::post('roles/store', 'store')->name('roles.store');
        Route::get('roles/edit/{id}', 'edit')->name('roles.edit');
        Route::post('roles/update/{id}', 'update')->name('roles.update');
        Route::post('roles/delete', 'delete')->name('roles.delete');
    });
    // Permissions
    Route::controller(PermissionController::class)->group(function () {
        Route::get('permissions/index/{permissions_kywd?}', 'index')->name('permissions');
        Route::get('permissions/create/', 'create')->name('permissions.create');
        Route::post('permissions/store/', 'store')->name('permissions.store');
        Route::get('permissions/edit/{id}', 'edit')->name('permissions.edit');
        Route::post('permissions/update/{id}', 'update')->name('permissions.update');
        Route::post('permissions/delete', 'delete')->name('permissions.delete');
    });
});

require __DIR__ . '/auth.php';
