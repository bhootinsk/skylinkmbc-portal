<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureNotSuspended
{
    public function handle(Request $request, Closure $next, string $guard = 'web'): Response
    {
        $user = $request->user($guard);

        if ($user?->is_suspended) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route($guard === 'admin' ? 'admin.login' : 'login')
                ->withErrors(['email' => 'Your account has been suspended. Please contact admin@skylinkmbc.biz.']);
        }

        return $next($request);
    }
}
