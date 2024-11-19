<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\User;
use Illuminate\Support\Facades\Auth;

class Tahun_Ajaran
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $tahunAjaran = 'Tahun Ajaran tidak dipilih';

        if (Auth::check()) {
            $user = Auth::user();
            if ($user->tahun_ajaran_id) {
                // Mengambil data tahun ajaran melalui relasi
                $tahunAjaranModel = \App\Models\Tahun_Ajaran::find($user->tahun_ajaran_id);

                if ($tahunAjaranModel) {
                    $tahunAjaran = $tahunAjaranModel->tahun_ajaran;
                } else {
                    $tahunAjaran = 'Tahun Ajaran tidak ditemukan';
                }
            }
        }

        // Membagikan variabel ke semua view
        view()->share('tahun_ajaran_terpilih', $tahunAjaran);

        // Menyimpan alert di session
        session()->put('alert', 'Tahun Ajaran ' . $tahunAjaran);
        
        return $next($request);
    }
}