<?php

use App\Http\Controllers\AdminController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/showUsers', [AdminController::class, 'showUsers'])->name('admin.showUsers');
    Route::put('admin/user/toggle/{user}', [AdminController::class, 'userToggle'])->name('user.toggle');

});

Route::middleware('user')->group(function () {
    Route::get('/user/dashboard', function () {
        return "<p>user dashboard</p>";
    });
});