<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureClient
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user('web');

        if (! $user || ! $user->isClient()) {
            abort(403, 'Client access only.');
        }

        return $next($request);
    }
}
