<?php

use App\Http\Controllers\User\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/createPost', [PostController::class, 'createPost'])->middleware(['auth', 'verified'])->name('createPost');

Route::post('/storePost', [PostController::class, 'storePost'])->middleware(['auth', 'verified'])->name('storePost');

Route::get('/posts', [PostController::class, 'viewPosts'])->middleware(['auth', 'verified'])->name('posts');

Route::post('/storeComment', [PostController::class, 'storeComment'])->middleware(['auth', 'verified'])->name('storeComment');