<?php

use App\Http\Controllers\HomeController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\LectureController;
use App\Http\Controllers\LectureBookmarkController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\ReviewGoodController;
use App\Http\Controllers\ReportController;
use App\Http\Controllers\ChatController;

Route::middleware(['throttle:request'])->group(function ()
{
    //トップページ
    Route::get('/', [HomeController::class, 'home']);

    //お問い合わせ
    Route::get('/contacts/create', [ContactController::class, 'create'])->name('contact.create');
    Route::post('/contacts', [ContactController::class, 'store'])->name('contact.store');

    //講義関連
    Route::controller(LectureController::class)->group(function () {
        Route::get('/lectures', 'index')->name('lecture.index');
        Route::post('/lectures', 'store')->name('lecture.store')->middleware('auth');
        Route::get('/lectures/create', 'create')->name('lecture.create')->middleware('auth');
        Route::get('/lectures/{lecture}', 'show')->name('lecture.show');
        Route::put('/lectures/{lecture}', 'update')->name('lecture.update')->middleware('auth');
        Route::delete('/lectures/{lecture}', 'destroy')->name('lecture.delete')->middleware('auth');
        Route::get('/lectures/{lecture}/edit', 'edit')->name('lecture.edit')->middleware('auth');
    });

    //講義ブックマーク
    Route::put('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'set'])
        ->name('bookmark.set')->middleware('auth');
    Route::delete('/lectures/{lecture}/bookmark', [LectureBookmarkController::class, 'remove'])
        ->name('bookmark.remove')->middleware('auth');

    //講義レビュー関連
    Route::controller(ReviewController::class)->group(function ()
    {
        Route::get('/reviews', 'index')->name('review.index');
        Route::middleware('auth')->group(function ()
        {
            Route::put('/reviews/{review}', 'update')->name('review.update');
            Route::delete('/reviews/{review}', 'delete')->name('review.delete');
            Route::post('/lectures/{lecture}/reviews', 'store')->name('review.store');
            Route::get('/lectures/{lecture}/reviews/create', 'create')->name('review.create');
            Route::get('/lectures/{lecture}/reviews/{review}/edit', 'edit')->name('review.edit');
        });
    });
    //講義レビューいいね
    Route::post('/reviews/{review}/good', [ReviewGoodController::class, 'good'])
        ->name('review.good')->middleware('auth');

    //チャット関連
    Route::controller(ChatController::class)->group(function ()
    {
        Route::get('/chats', 'index')->name('chat.index');
        Route::post('/chats', 'storeThread')->name('chat.thread.store');
        Route::get('/chats/{thread}', 'show')->name('chat.show');
        Route::post('/chats/{thread}', 'storeResponse')->name('chat.res.store');
    });

    //不適切な投稿の報告報告
    Route::post('/report', [ReportController::class, 'report'])->name('report')->middleware('auth');

    //プロフィール関連
    Route::middleware('auth')->group(function ()
    {
        Route::get('/profile/{user}', [ProfileController::class, 'show'])->name('profile.show');
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    });
});

require __DIR__.'/auth.php';