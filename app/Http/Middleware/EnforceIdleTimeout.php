<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnforceIdleTimeout
{
    public function handle(Request $request, Closure $next, string $guard = 'web'): Response
    {
        $timeoutSeconds = config('portal.idle_timeout_minutes') * 60;
        $sessionKey = "portal.last_activity.{$guard}";
        $lastActivity = $request->session()->get($sessionKey);

        if ($lastActivity !== null && (time() - $lastActivity) >= $timeoutSeconds) {
            Auth::guard($guard)->logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            return redirect()
                ->route($guard === 'admin' ? 'admin.login' : 'login')
                ->with('status', 'You were signed out due to inactivity.');
        }

        $request->session()->put($sessionKey, time());

        return $next($request);
    }
}
