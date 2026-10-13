<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckPermission
{
    public function handle(Request $request, Closure $next, $level): Response
    {
        if (!auth()->check() || auth()->user()->permission < (int) $level) {
            abort(403, '沒有權限');
        }

        return $next($request);
    }
}