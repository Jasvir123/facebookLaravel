<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    // Route::get('admin/viewUsers', [RegisteredUserController::class, 'viewUsers'])->name('admin.viewUsers');
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
});

Route::middleware('user')->group(function () {
    Route::get('/user/dashboard', function () {
        return "<p>user dashboard</p>";
    });
});