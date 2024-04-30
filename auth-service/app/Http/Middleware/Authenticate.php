<?php

namespace App\Http\Middleware;

use Closure;
use GuzzleHttp\Psr7\Response;
use Illuminate\Auth\Middleware\Authenticate as Middleware;
use Illuminate\Http\Request;

class Authenticate extends Middleware
{
    
    public function handle($request, Closure $next, ...$guards)
    {
        if(!auth()->check())
        {
            return response()->json(['status'=>'error', 'message'=>'Unauthorized'], 401);

        }
        return $next($request); 
    }
}
