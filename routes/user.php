<?php

use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::middleware('admin')->group(function () {
    Route::get('admin/dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
    Route::get('admin/showUsers', [AdminController::class, 'showUsers'])->name('admin.showUsers');
    Route::put('admin/user/toggle/{user}', [AdminController::class, 'userToggle'])->name('user.toggle');
    Route::get('admin/user/edit/{user}', [AdminController::class, 'editUser'])->name('admin.user.edit');
    Route::patch('admin/user/edit', [AdminController::class, 'updateUser'])->name('admin.user.update');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile/view/{user}', [ProfileController::class, 'index'])->name('profile.view');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});