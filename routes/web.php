<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LectureBookmarkController;
use App\Http\Controllers\ContactController;
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
    
    Route::controller(LectureController::class)->group(function () { 
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::post('/lectures', 'store')->name('lecture.store');
        Route::get('/lectures/create', 'create')->name('lecture.create');
        Route::get('/lectures/{lecture_id}', 'show')->name('lecture.show');
    });
    Route::controller(ReviewController::class)->group(function () { 
        Route::get('/lectures/{lecture}/reviews/create', [ReviewController::class, 'create'])->name('review.create');
        Route::post('/lectures/{lecture}/reviews', [ReviewController::class, 'store'])->name('review.store');
    });
    
    Route::put('/lectures/{lecture}/bookmark/set', [LectureBookmarkController::class, 'setBookmark'])->name('bookmark.set');
    Route::delete('/lectures/{lecture}/bookmark/remove', [LectureBookmarkController::class, 'removeBookmark'])->name('bookmark.remove');

});

Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';
