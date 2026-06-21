<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    public function handle(Request $request, Closure $next, string ...$guards): Response
    {
        $guards = $guards ?: [null];

        foreach ($guards as $guard) {
            if (auth()->guard($guard)->check()) {
                $user = auth()->guard($guard)->user();

                if ($guard === 'admin' || $user?->isStaff()) {
                    return redirect()->route('admin.dashboard');
                }

                return redirect()->route('client.dashboard');
            }
        }

        return $next($request);
    }
}
