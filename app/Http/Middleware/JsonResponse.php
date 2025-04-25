<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class JsonResponse
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Only set Accept header if it's not already set
        if (!$request->headers->has('Accept')) {
            $request->headers->set('Accept', 'application/json');
        }
        
        return $next($request);
    }
} 