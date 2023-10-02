<?php

use App\Http\Controllers\WelcomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LectureBookmarkController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewGoodController;
use App\Http\Controllers\ReportController;

Route::get('/', [WelcomeController::class, 'welcome']);

Route::middleware('auth')->group(function () {

    Route::controller(LectureController::class)->group(function () {
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::post('/lectures', 'store')->name('lecture.store');
        Route::get('/lectures/create', 'create')->name('lecture.create');
        Route::get('/lectures/{lecture}', 'show')->name('lecture.show');
    });

    Route::controller(ReviewController::class)->group(function () {
        Route::get('/reviews', [ReviewController::class, 'index'])->name('review.index');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'delete'])->name('review.delete');
        Route::post('/lectures/{lecture}/reviews', [ReviewController::class, 'store'])->name('review.store');
        Route::get('/lectures/{lecture}/reviews/create', [ReviewController::class, 'create'])->name('review.create');
        Route::get('/lectures/{lecture}/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    });

    Route::put('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'set'])->name('bookmark.set');
    Route::delete('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'remove'])->name('bookmark.remove');

    Route::post('/reviews/{review}/good', [ReviewGoodController::class, 'good'])->name('review.good');

    Route::post('/report', [ReportController::class, 'report'])->name('report');

    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';

