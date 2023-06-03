<?php

use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\GourmetController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProblemController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    
    Route::controller(LectureController::class)->group(function () {
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::get('/lectures/create', 'create')->name('lecture.create');
        Route::post('/lectures', 'store')->name('lecture.store');
        Route::get('/lectures/{lecture}', 'show')->name('lecture.show');
        Route::get('/lectures/{lecture}/edit', 'edit')->name('lecture.edit');
        Route::put('/lectures/{lecture}', 'update')->name('lecture.update');
    });
    
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/lectures/{lecture}/reviews', 'index')->name('review.index');
        Route::get('/lectures/{lecture}/reviews/create', 'create')->name('review.create');
        Route::post('/lectures/{lecture}/reviews', 'store')->name('review.store');
        Route::get('/lectures/{lecture}/reviews/{review}', 'show')->name('review.show');
        Route::get('/lectures/{lecture}/reviews/{review}/edit', 'edit')->name('review.edit');
        Route::put('/lectures/{lecture}/reviews/{review}', 'update')->name('review.update');
    });

    Route::get('/problems', [ProblemController::class, 'index'])->name('problem.index');
    Route::get('/chats', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/gourmets', [GourmetController::class, 'index'])->name('gourmet.index');
});




require __DIR__.'/auth.php';
