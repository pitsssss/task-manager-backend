<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckUserRole
{

    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::user()->Role == 'admin'){
            return $next($request);}
        return response()->json(['message' => 'UnAuthurized, only admins can access'], 403);
    }
}
