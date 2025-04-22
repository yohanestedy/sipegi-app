<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AdminAtauKader
{
    public function handle(Request $request, Closure $next): Response
    {
        if (Auth::check()) {
            $role = Auth::user()->role;
            if ($role === 'super_admin' || $role === 'kader_posyandu') {
                return $next($request);
            }
        }

        return redirect()->back();
    }
}
