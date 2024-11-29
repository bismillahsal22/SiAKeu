<?php

namespace App\Http\Controllers;

use App\Models\ArsipTagihan;
use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class LaporanArsipController extends Controller
{
    public function index(Request $request)
    {
        $arsip = ArsipTagihan::query();
        $title = "";
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        $selectedTahunAjaran = $request->input('tahun_ajaran_id');

        if ($selectedTahunAjaran) {
            $models = ArsipTagihan::where('tahun_ajaran_id', $selectedTahunAjaran)->get();
        } else {
            $models = ArsipTagihan::all();
        }

        $totalSiswa = $models->count();
        $jumlahLunas = $models->where('status', 'Lunas')->count();
        $jumlahMengangsur = $models->where('status', 'Mengangsur')->count();
        $belumMembayar = $models->where('status', 'Baru')->count();

        $totalTagihan = $models->sum('jumlah_tag');
        $totalPembayaran = $models->sum('jumlah_bayar');
        $totalKekurangan = $totalTagihan - $totalPembayaran;

        return view('admin.cetak_arsip', [
            'title' => 'LAPORAN ARSIP SISWA TAHUN AJARAN :' . ' ' . Tahun_Ajaran::find($selectedTahunAjaran)?->tahun_ajaran ?? 'Semua Tahun',
            'tahunAjaran' => $tahunAjaran,
            'models' => $models,
            'selectedTahunAjaran' => $selectedTahunAjaran,
            'totalSiswa' => $totalSiswa,
            'jumlahLunas' => $jumlahLunas,
            'jumlahMengangsur' => $jumlahMengangsur,
            'belumMembayar' => $belumMembayar,
            'totalTagihan' => $totalTagihan,
            'totalPembayaran' => $totalPembayaran,
            'totalKekurangan' => $totalKekurangan,
        ]);
    } 
}