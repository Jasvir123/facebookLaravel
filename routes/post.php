<?php

use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::middleware('auth')->group(function () {
    Route::get('createPost', [PostController::class, 'createPost'])->name('createPost');

    Route::post('storePost', [PostController::class, 'store'])->name('storePost');

    Route::get('posts', [PostController::class, 'index'])->name('posts');

    Route::post('storeComment', [PostController::class, 'storeComment'])->name('storeComment');
});

Route::middleware('admin')->group(function () {
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy');

});