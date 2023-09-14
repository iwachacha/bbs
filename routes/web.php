<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
        'laravelVersion' => Application::VERSION,
        'phpVersion' => PHP_VERSION,
    ]);
});

Route::get('/home', function () {
    return Inertia::render('Home');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/lectures', [LectureController::class, 'index'])->name('lecture.index');
Route::get('/lectures/create', [LectureController::class, 'create'])->name('lecture.create');
Route::post('/lectures', [LectureController::class, 'store'])->name('lecture.store');

Route::get('/lectures/{ lecture }/reviews/create', [ReviewController::class, 'create'])->name('review.create');

require __DIR__.'/auth.php';
