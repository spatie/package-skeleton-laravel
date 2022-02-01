<?php

namespace VendorName\Skeleton\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class SkeletonMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        return $next($request);
    }
}
