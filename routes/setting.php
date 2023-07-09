<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\AdminController;

Route::middleware('admin')->group(function () {
    Route::get('admin/settings', [AdminController::class, 'settings'])->name('admin.settings');
    Route::post('admin/updateSettings', [AdminController::class, 'updateSettings'])->name('admin.updateSettings');
});