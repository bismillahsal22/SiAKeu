<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;
        $tahunAjaran = $request->input('tahun_ajaran'); // Ambil tahun ajaran yang dipilih
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                $user = Auth::user();

                switch ($user->akses) {
                    case 'admin':
                        return redirect()->route('admin.dashboard');
                    case 'operator':
                        return redirect()->route('operator.dashboard');
                    case 'wali':
                        return redirect()->route('wali.w_dashboard');
                    default:
                        return redirect('/');
                }
            }
        }

        return $next($request);
    }
}