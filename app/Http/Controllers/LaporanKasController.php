<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class LaporanKasController extends Controller
{
    public function index(Request $request)
    {
        $kas = Kas::query();
        $title = "";
        if($request->filled('bulan')){
            $kas = $kas->whereMonth('tanggal', $request->bulan);
            $title = "Bulan " . ubahNamaBulan($request->bulan);
        }
        // Filter berdasarkan tahun ajaran
        // Ambil semua tahun ajaran
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');

        // Jika tahun ajaran dipilih, filter berdasarkan tahun ajaran tersebut
        if ($request->filled('tahun_ajaran_id')) {
            $kas = $kas->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            $tahunAjaranTerpilih = $tahunAjaran->get($request->tahun_ajaran_id);
            $title .= " Tahun Ajaran " . $tahunAjaranTerpilih;
        } else {
            // Jika tidak ada tahun ajaran yang dipilih, ambil tahun ajaran aktif
            $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();

            if ($tahunAjaranAktif) {
                // Filter berdasarkan tahun ajaran aktif
                $kas = $kas->where('tahun_ajaran_id', $tahunAjaranAktif->id);
                $title .= " Tahun Ajaran " . $tahunAjaranAktif->tahun_ajaran;
            } else {
                // Jika tidak ada tahun ajaran aktif, kosongkan data
                $kas = collect(); // Tidak menampilkan data jika tidak ada tahun ajaran aktif
            }
        }

        
        // Inisialisasi saldo awal
        $saldo_awal = 0;

        // Mengambil semua data kas dan menghitung saldo kumulatif
        $kas = $kas->get()->map(function ($item) use (&$saldo_awal) {
            $item->pemasukan = $item->jenis === 'pemasukan' ? $item->jumlah : 0;
            $item->pengeluaran = $item->jenis === 'pengeluaran' ? $item->jumlah : 0;
            
            // Hitung saldo berdasarkan pemasukan/pengeluaran
            $saldo_awal += $item->pemasukan - $item->pengeluaran;
            $item->saldo = $saldo_awal;
            
            return $item;
        });
        // Hitung total pemasukan dan pengeluaran
    $totalPemasukan = $kas->sum('pemasukan');
    $totalPengeluaran = $kas->sum('pengeluaran');
    $totalSaldo = $totalPemasukan - $totalPengeluaran;

    return view('admin.cetak_kas', compact('kas', 'title','totalPemasukan', 'totalPengeluaran', 'totalSaldo'));
    }
}