<?php

use App\Http\Controllers\ClassCatController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\FileController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\StudyCatController;
use App\Http\Controllers\StudyDetController;
use App\Http\Controllers\StudyMatController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

// Route::get('/kursus', function () {
//     return view('welcome');
// });

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('academy_admin')->name('academy_admin.')->group(function () {
        Route::middleware('can:manage class category')->group(function () {
            Route::post('classcat/delete', [ClassCatController::class, 'delete'])->name('classcat.delete');
            Route::post('classcat/recover', [ClassCatController::class, 'recover'])->name('classcat.recover');
            Route::resource('classcat', ClassCatController::class);
        });
        Route::middleware('can:manage classes')->group(function () {
            Route::post('classes/delete', [ClassesController::class, 'delete'])->name('classes.delete');
            Route::post('classes/recover', [ClassesController::class, 'recover'])->name('classes.recover');
            Route::resource('classes', ClassesController::class);
        });
        Route::middleware('can:manage study category')->group(function () {
            Route::post('studycat/delete', [StudyCatController::class, 'delete'])->name('studycat.delete');
            Route::post('studycat/recover', [StudyCatController::class, 'recover'])->name('studycat.recover');
            Route::resource('studycat', StudyCatController::class);
        });
        Route::middleware('can:manage studies')->group(function () {
            Route::post('studies/delete', [StudiesController::class, 'delete'])->name('studies.delete');
            Route::post('studies/recover', [StudiesController::class, 'recover'])->name('studies.recover');
            Route::resource('studies', StudiesController::class);
        });
        Route::middleware('can:manage study detail')->group(function () {
            Route::get('studydet/attachment', [StudyDetController::class, 'attachment'])->name('studydet.attachment');
            Route::post('studydet/delete', [StudyDetController::class, 'delete'])->name('studydet.delete');
            Route::post('studydet/recover', [StudyDetController::class, 'recover'])->name('studydet.recover');
            Route::post('file/uploadatt', [FileController::class, 'upload_study_attachment'])->name('file.upload_studyatt');
            Route::get('studydet/getdeleted', [StudyDetController::class, 'get_deleted'])->name('studydet.getdeleted');
            Route::resource('studydet', StudyDetController::class);
        });
    });
});

require __DIR__ . '/auth.php';
