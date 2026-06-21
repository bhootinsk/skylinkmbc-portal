<?php

use App\Http\Controllers\Client\Auth\LoginController as ClientLoginController;
use App\Http\Controllers\Client\DashboardController as ClientDashboardController;
use App\Http\Controllers\Client\FileController as ClientFileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware('guest.client')->group(function () {
    Route::get('login', [ClientLoginController::class, 'create'])->name('login');
    Route::post('login', [ClientLoginController::class, 'store'])->middleware('throttle:5,1');
});

Route::middleware(['auth:web', 'client', 'not.suspended:web', 'idle.timeout:web'])->group(function () {
    Route::get('dashboard', ClientDashboardController::class)->name('client.dashboard');
    Route::post('logout', [ClientLoginController::class, 'destroy'])->name('logout');

    Route::post('files', [ClientFileController::class, 'store'])->name('client.files.store');
    Route::get('files/{file}/download', [ClientFileController::class, 'download'])->name('client.files.download');
    Route::delete('files/{file}', [ClientFileController::class, 'destroy'])->name('client.files.destroy');
});
