<?php

use App\Http\Controllers\Admin\Auth\AuthenticatedSessionController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\LectureController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\ReviewController;

Route::middleware('auth:admin')->group(function ()
{
    Route::controller(LectureController::class)->group(function () {
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::get('/lectures/{lecture}', 'show')->name('lecture.show');
    });
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/reviews', [ReviewController::class, 'index'])->name('review.index');
        Route::put('/reviews/{review}', [ReviewController::class, 'update'])->name('review.update');
        Route::delete('/reviews/{review}', [ReviewController::class, 'delete'])->name('review.delete');
        Route::get('/lectures/{lecture}/reviews/{review}/edit', [ReviewController::class, 'edit'])->name('review.edit');
    });
});

Route::get('/contacts/index', [ContactController::class, 'index'])->name('contact.index');

Route::middleware('guest')->group(function ()
{
    Route::get('login', [AuthenticatedSessionController::class, 'create'])->name('login');
    Route::post('login', [AuthenticatedSessionController::class, 'store']);
});

Route::middleware('auth:admin')->group(function () {
    Route::post('logout', [AuthenticatedSessionController::class, 'destroy'])->name('logout');
});

