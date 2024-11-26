<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Models\Tahun_Ajaran as Tahun_Ajaran_Model;

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
        // Ambil data tahun ajaran aktif dari database
        $tahunAjaranModel = Tahun_Ajaran_Model::where('status', 'aktif')->first();

        if ($tahunAjaranModel) {
            // Jika ditemukan, set nilai tahun ajaran
            $tahunAjaran = $tahunAjaranModel->tahun_ajaran;
        } else {
            // Jika tidak ditemukan, set pesan tahun ajaran tidak ditemukan
            $tahunAjaran = 'Tahun Ajaran tidak ditemukan';
            session()->put('alert', 'Tahun Ajaran tidak ditemukan');
        }

        // Membagikan variabel tahun ajaran ke semua view
        view()->share('tahun_ajaran_terpilih', $tahunAjaran);

        // Cek apakah tahun ajaran valid atau ada masalah, dan tampilkan alert
        if ($tahunAjaran == 'Tahun Ajaran tidak ditemukan') {
            session()->put('alert', 'Tahun Ajaran ' . $tahunAjaran);
        } else {
            // Jika tahun ajaran ditemukan, hapus alert jika ada
            session()->forget('alert');
        }

        return $next($request);
    }
}
