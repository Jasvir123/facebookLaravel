<?php

use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('/createPost', [PostController::class, 'createPost'])->name('createPost');

    Route::post('/storePost', [PostController::class, 'storePost'])->name('storePost');

    Route::get('/posts', [PostController::class, 'viewPosts'])->name('posts');

    Route::post('/storeComment', [PostController::class, 'storeComment'])->name('storeComment');
});

Route::middleware('admin')->group(function () {
    Route::get('/deletePost/{post_id}', [PostController::class, 'deletePost'])->name('deletePost');
});