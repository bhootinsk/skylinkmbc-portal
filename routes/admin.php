<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\Auth\LoginController as AdminLoginController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\FileController as AdminFileController;
use App\Http\Controllers\Admin\UserController as AdminUserController;
use Illuminate\Support\Facades\Route;

Route::middleware('guest.admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'create'])->name('login');
    Route::post('login', [AdminLoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware(['auth:admin', 'admin.access', 'not.suspended:admin', 'idle.timeout:admin'])->group(function () {
    Route::get('/', AdminDashboardController::class)->name('dashboard');
    Route::post('logout', [AdminLoginController::class, 'destroy'])->name('logout');

    Route::resource('users', AdminUserController::class)->except(['show']);
    Route::patch('users/{user}/suspend', [AdminUserController::class, 'suspend'])->name('users.suspend');
    Route::patch('users/{user}/activate', [AdminUserController::class, 'activate'])->name('users.activate');

    Route::get('files', [AdminFileController::class, 'index'])->name('files.index');
    Route::get('files/create', [AdminFileController::class, 'create'])->name('files.create');
    Route::post('files', [AdminFileController::class, 'store'])->name('files.store');
    Route::get('files/{file}/download', [AdminFileController::class, 'download'])->name('files.download');
    Route::delete('files/{file}', [AdminFileController::class, 'destroy'])->name('files.destroy');

    Route::get('activity', [ActivityLogController::class, 'index'])->name('activity.index');
});
