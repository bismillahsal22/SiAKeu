<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class CheckAkses
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle($request, Closure $next, ...$roles)
    {
        // If user is authenticated but doesn't have the right role, redirect to a different page.
        if (Auth::check() && !in_array($request->user()->akses, $roles)) {
            return redirect()->route('unauthorized'); // or another page
        }

        // If user is not authenticated, redirect to login
        if (!Auth::check()) {
            return redirect()->route('login');
        }
        
        return $next($request);
    }
}