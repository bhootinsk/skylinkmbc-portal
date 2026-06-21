<?php

use App\Http\Middleware\EnsureAdmin;
use App\Http\Middleware\EnsureClient;
use App\Http\Middleware\EnsureNotSuspended;
use App\Http\Middleware\RedirectIfAuthenticated;
use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Support\Facades\Route;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
        then: function () {
            Route::middleware('web')
                ->prefix('admin')
                ->name('admin.')
                ->group(base_path('routes/admin.php'));
        },
    )
    ->withMiddleware(function (Middleware $middleware) {
        $middleware->alias([
            'client' => EnsureClient::class,
            'admin.access' => EnsureAdmin::class,
            'not.suspended' => EnsureNotSuspended::class,
            'guest.client' => RedirectIfAuthenticated::class.':web',
            'guest.admin' => RedirectIfAuthenticated::class.':admin',
        ]);
    })
    ->withExceptions(function (Exceptions $exceptions) {
        //
    })->create();
