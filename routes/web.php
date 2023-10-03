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

Route::middleware('auth')->group(function ()
{
    //講義関連
    Route::controller(LectureController::class)->group(function () {
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::post('/lectures', 'store')->name('lecture.store');
        Route::get('/lectures/create', 'create')->name('lecture.create');
        Route::get('/lectures/{lecture}', 'show')->name('lecture.show');
        Route::put('/lectures/{lecture}', 'update')->name('lecture.update');
        Route::delete('/lectures/{lecture}', 'destroy')->name('lecture.delete');
        Route::get('/lectures/{lecture}/edit', 'edit')->name('lecture.edit');
    });

    //講義レビュー関連
    Route::controller(ReviewController::class)->group(function () {
        Route::get('/reviews', 'index')->name('review.index');
        Route::put('/reviews/{review}', 'update')->name('review.update');
        Route::delete('/reviews/{review}', 'delete')->name('review.delete');
        Route::post('/lectures/{lecture}/reviews', 'store')->name('review.store');
        Route::get('/lectures/{lecture}/reviews/create', 'create')->name('review.create');
        Route::get('/lectures/{lecture}/reviews/{review}/edit', 'edit')->name('review.edit');
    });

    //講義ブックマーク
    Route::put('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'set'])->name('bookmark.set');
    Route::delete('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'remove'])->name('bookmark.remove');

    //講義レビューいいね
    Route::post('/reviews/{review}/good', [ReviewGoodController::class, 'good'])->name('review.good');

    //不適切な投稿の報告報告
    Route::post('/report', [ReportController::class, 'report'])->name('report');

    //プロフィール編集
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

//お問い合わせ
Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

require __DIR__.'/auth.php';