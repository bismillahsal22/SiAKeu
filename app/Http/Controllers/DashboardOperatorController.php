<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardOperatorController extends Controller
{
    public function index(Request $request)
    {
        $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();

        if (!$tahunAjaranAktif) {
            flash('Tahun ajaran aktif tidak ditemukan')->error();
            return redirect()->back();
        }
        $data['tahunAjaran'] = $tahunAjaranAktif->tahun_ajaran;
        $data['siswa'] = Siswa::where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->count();

        $pembayaran = Pembayaran::where('tagihan_id', $tahunAjaranAktif->id)->get();
        $data['totalSiswaSudahBayar'] = $pembayaran->count();
        $data['totalPembayaran'] = $pembayaran->sum('jumlah_bayar');

        $pemasukan = Kas::where('jenis', 'Pemasukan')
            ->whereBetween('tanggal', [$tahunAjaranAktif->tgl_mulai, $tahunAjaranAktif->tgl_akhir])
            ->get();
        $data['totalPemasukan'] = $pemasukan->sum('jumlah');

        $pengeluaran = Kas::where('jenis', 'Pengeluaran')
            ->whereBetween('tanggal', [$tahunAjaranAktif->tgl_mulai, $tahunAjaranAktif->tgl_akhir])
            ->get();
        $data['totalPengeluaran'] = $pengeluaran->sum('jumlah');

        $data['sisaSaldo'] = $data['totalPemasukan'] - $data['totalPengeluaran'];

        return view('operator.dashboard_operator', $data);
    }
}