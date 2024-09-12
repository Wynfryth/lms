<?php

use App\Http\Controllers\ClassCatController;
use App\Http\Controllers\ClassesController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\StudiesController;
use App\Http\Controllers\StudyCatController;
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
            Route::resource('classcat', ClassCatController::class);
            Route::post('classcat/delete', [ClassCatController::class, 'delete'])->name('classcat.delete');
            Route::post('classcat/recover', [ClassCatController::class, 'recover'])->name('classcat.recover');
        });
        Route::middleware('can:manage classes')->group(function () {
            Route::resource('classes', ClassesController::class);
            Route::post('classes/delete', [ClassesController::class, 'delete'])->name('classes.delete');
            Route::post('classes/recover', [ClassesController::class, 'recover'])->name('classes.recover');
        });
        Route::middleware('can:manage study category')->group(function () {
            Route::resource('studycat', StudyCatController::class);
            Route::post('studycat/delete', [StudyCatController::class, 'delete'])->name('studycat.delete');
            Route::post('studycat/recover', [StudyCatController::class, 'recover'])->name('studycat.recover');
        });
        Route::middleware('can:manage studies')->group(function () {
            Route::resource('studies', StudiesController::class);
            Route::post('studies/delete', [StudiesController::class, 'delete'])->name('studies.delete');
            Route::post('studies/recover', [StudiesController::class, 'recover'])->name('studies.recover');
        });
        Route::middleware('can:manage study material')->group(function () {
            Route::resource('studymat', StudyMatController::class);
            Route::post('studymat/delete', [StudyMatController::class, 'delete'])->name('studymat.delete');
            Route::post('studymat/recover', [StudyMatController::class, 'recover'])->name('studymat.recover');
        });
    });
});

require __DIR__ . '/auth.php';
