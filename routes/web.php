<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LectureBookmarkController;
use App\Http\Controllers\ReviewController;
use Illuminate\Foundation\Application;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', function () {
    return Inertia::render('Welcome', [
        'canLogin' => Route::has('login'),
        'canRegister' => Route::has('register'),
    ]);
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::middleware('auth')->group(function () {
Route::get('/lectures', [LectureController::class, 'index'])->name('lecture.index');
Route::get('/lectures/create', [LectureController::class, 'create'])->name('lecture.create');
Route::post('/lectures', [LectureController::class, 'store'])->name('lecture.store');

Route::get('/lectures/{lecture}/reviews', [ReviewController::class, 'index'])->name('review.index');
Route::get('/lectures/{lecture}/reviews/create', [ReviewController::class, 'create'])->name('review.create');
Route::post('/lectures/{lecture}/reviews', [ReviewController::class, 'store'])->name('review.store');

Route::put('/lectures/{lecture}/bookmark/set', [LectureBookmarkController::class, 'setBookmark'])->name('bookmark.set');
Route::delete('/lectures/{lecture}/bookmark/remove', [LectureBookmarkController::class, 'removeBookmark'])->name('bookmark.remove');
});

require __DIR__.'/auth.php';
