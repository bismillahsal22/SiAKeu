<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Models\ArsipTagihan;
use App\Models\Kas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardAdminController extends Controller
{
    // public function index(Request $request, DashboardChart $dashboardChart)
    // {
    //     $tahun = date('Y');
    //     $bulan = date('m');
    //     $data['siswa'] = Siswa::count();
    //     $pembayaran = Pembayaran::whereYear('tgl_bayar', $tahun)
    //         ->whereMonth('tgl_bayar', $bulan)->get();
    //     $data['totalPembayaran'] = $pembayaran->sum('jumlah_bayar');
    //     // Hitung total pengeluaran bulan dan tahun ini
    //     $pengeluaran = Kas::where('jenis', 'Pemasukan')
    //     ->whereYear('tanggal', $tahun)
    //     ->whereMonth('tanggal', $bulan)
    //     ->get();

    //     $data['totalPemasukan'] = $pengeluaran->sum('jumlah');
    //     // Hitung total pengeluaran bulan dan tahun ini
    //     $pengeluaran = Kas::where('jenis', 'pengeluaran')
    //     ->whereYear('tanggal', $tahun)
    //     ->whereMonth('tanggal', $bulan)
    //     ->get();

    //     $data['totalPengeluaran'] = $pengeluaran->sum('jumlah');

    //     // Hitung sisa saldo (pemasukan - pengeluaran)
    //     $data['sisaSaldo'] = $data['totalPemasukan'] - $data['totalPengeluaran'];
    //      // Ambil tahun ajaran dari query string
    //     $data['tahun_ajaran_terpilih'] = $request->query('tahun_ajaran', 'Tahun Ajaran tidak dipilih');
    //     $data['dataBayarBelumKonfirmasi'] = Pembayaran::whereNull('tgl_konfirmasi')->get();

    //     $tagihan = Tagihan::with('siswa')->whereYear('tgl_tagihan', $tahun)
    //         ->whereMonth('tgl_tagihan', $bulan)->get();

    //     $tagihanBelumBayar = $tagihan->where('status','<>', 'Lunas');
    //     $tagihanSudahBayar = $tagihan->where('status', 'Lunas');

    //     $data['totalTagihan'] = $tagihan->count();
    //     $data['tagihanBelumBayar'] = $tagihanBelumBayar;
    //     $data['tagihanSudahBayar'] = $tagihanSudahBayar;
        
    //     //chart
    //     $data['dashboardChart'] = $dashboardChart->build([
    //         $tagihanBelumBayar->count(),
    //         $tagihanSudahBayar->count(),
            
    //     ]);
        
    //     return view('admin.dashboard', $data);
    // }
    // public function index(Request $request, DashboardChart $dashboardChart)
    // {
    //     // Ambil tahun ajaran aktif
    //     $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();

    //     if (!$tahunAjaranAktif) {
    //         return redirect()->back()->with('error', 'Tahun ajaran aktif tidak ditemukan.');
    //     }

    //     // Ambil tanggal mulai dan tanggal akhir dari tahun ajaran aktif
    //     $tanggalMulai = $tahunAjaranAktif->tgl_mulai;
    //     $tanggalAkhir = $tahunAjaranAktif->tgl_akhir;

    //     // Ambil jumlah siswa berdasarkan tahun ajaran aktif
    //     $data['siswa'] = Siswa::where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //                         ->where('status_siswa', '<>', 'Lulus')
    //                         ->count();

    //     // Filter pemasukan berdasarkan tahun ajaran aktif
    //     $pemasukan = Kas::where('jenis', 'Pemasukan')
    //         ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
    //         ->get();

    //     $data['totalPemasukan'] = $pemasukan->sum('jumlah');

    //     // Filter pengeluaran berdasarkan tahun ajaran aktif
    //     $pengeluaran = Kas::where('jenis', 'pengeluaran')
    //         ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
    //         ->get();
        
    //     $data['totalPengeluaran'] = $pengeluaran->sum('jumlah');

    //     // Hitung sisa saldo jika ada pemasukan atau pengeluaran
    //     if ($pemasukan->isNotEmpty() || $pengeluaran->isNotEmpty()) {
    //         $data['sisaSaldo'] = $data['totalPemasukan'] - $data['totalPengeluaran'];
    //     } else {
    //         $data['sisaSaldo'] = 0; // Tidak ada saldo jika tidak ada pemasukan atau pengeluaran
    //     }

    //     // Pembayaran yang belum dikonfirmasi
    //     $data['dataBayarBelumKonfirmasi'] = Pembayaran::whereNull('tgl_konfirmasi')
    //         ->whereHas('tagihan', function ($query) use ($tahunAjaranAktif) {
    //             $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);
    //         })->get();

    //     // Ambil tagihan dari siswa yang masih aktif (tabel Tagihan)
    //     $tagihan = Tagihan::with('siswa')
    //         ->where('tahun_ajaran_id', $tahunAjaranAktif->id)
    //         ->get();

    //     // Menghitung jumlah tagihan berdasarkan status
    //     $data['tagihanLunas'] = $tagihan->where('status', 'Lunas')->count();
    //     $data['tagihanMengangsur'] = $tagihan->where('status', 'Mengangsur')->count();
    //     $data['tagihanBaru'] = $tagihan->where('status', 'Baru')->count();

    //     // Hitung total tagihan yang belum lunas
    //     $data['totalTagihan'] = $tagihan->count();
    //     $data['tagihanBelumLunas'] = $data['tagihanBaru'] + $data['tagihanMengangsur'];

    //     // Chart
    //     $data['dashboardChart'] = $dashboardChart->build([
    //         $data['tagihanLunas'],
    //         $data['tagihanBelumLunas'],
    //     ]);

    //     // Pass tahun ajaran aktif ke view
    //     $data['tahun_ajaran_aktif'] = $tahunAjaranAktif;

    //     return view('admin.dashboard', $data);
    // }
}