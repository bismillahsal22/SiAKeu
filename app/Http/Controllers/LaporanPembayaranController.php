<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $tagihan = Tagihan::query();
        $pembayaran = Pembayaran::query();
        $title = "";
        if($request->filled('bulan')){
            $pembayaran = $pembayaran->whereMonth('tgl_bayar', $request->bulan);
            $title = "Bulan " . ubahNamaBulan($request->bulan);
        }

       // Filter berdasarkan tahun ajaran
        // Ambil semua tahun ajaran
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran_id')) {
            $pembayaran = $pembayaran->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            $tahunAjaranTerpilih = $tahunAjaran->get($request->tahun_ajaran_id);
            $title .= " Tahun Ajaran " . $tahunAjaranTerpilih;            
        }
        
        if ($request->filled('status_konfirmasi')) {
            $pembayaran = $pembayaran->where('status_konfirmasi', $request->status_konfirmasi);
            $title = "Status Konfirmasi " .$request->status_konfirmasi;
        }

        $totalTagihan = $tagihan->sum('jumlah');
        $totalPembayaran = $pembayaran->sum('jumlah_bayar');
        $pembayaran = $pembayaran->get();
        return view('admin.laporan_bayar_index', compact('pembayaran', 'title', 'totalPembayaran', 'totalTagihan'));
    }
}