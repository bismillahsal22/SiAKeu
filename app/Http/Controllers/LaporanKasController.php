<?php

namespace App\Http\Controllers;

use App\Models\Kas;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class LaporanKasController extends Controller
{
    public function index(Request $request)
    {
        $kas = Kas::query();
        $title = "Laporan Kas";

        // Filter berdasarkan bulan jika ada di request
        if ($request->filled('bulan')) {
            $kas = $kas->whereMonth('tanggal', $request->bulan);
            $title .= " Bulan " . ubahNamaBulan($request->bulan); // Fungsi ubahNamaBulan mengubah angka bulan menjadi nama bulan
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        $tahunAjaranId = $request->filled('tahun_ajaran_id') ? $request->tahun_ajaran_id : null;

        // Jika tahun ajaran dipilih, filter berdasarkan tahun ajaran tersebut
        if ($tahunAjaranId) {
            $tahunAjaranData = Tahun_Ajaran::find($tahunAjaranId);

            if ($tahunAjaranData) {
                $tanggalMulai = Carbon::parse($tahunAjaranData->tgl_mulai)->startOfDay();
                $tanggalAkhir = Carbon::parse($tahunAjaranData->tgl_akhir)->endOfDay();

                // Filter kas berdasarkan rentang tanggal tahun ajaran yang dipilih
                $kas = $kas->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);

                // Menambahkan informasi tahun ajaran yang dipilih ke judul
                $title .= " Tahun Ajaran " . $tahunAjaranData->tahun_ajaran;
            }
        } else {
            // Jika tidak ada tahun ajaran yang dipilih, ambil tahun ajaran aktif
            $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();

            if ($tahunAjaranAktif) {
                // Ambil rentang tanggal mulai dan akhir dari tahun ajaran aktif
                $tanggalMulai = Carbon::parse($tahunAjaranAktif->tgl_mulai)->startOfDay();
                $tanggalAkhir = Carbon::parse($tahunAjaranAktif->tgl_akhir)->endOfDay();

                // Filter kas berdasarkan tahun ajaran aktif
                $kas = $kas->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);

                // Menambahkan informasi tahun ajaran aktif ke judul
                $title .= " Tahun Ajaran " . $tahunAjaranAktif->tahun_ajaran;
            } else {
                // Jika tidak ada tahun ajaran aktif, kosongkan data
                $kas = collect(); // Tidak menampilkan data jika tidak ada tahun ajaran aktif
                $title .= " (Tidak Ada Tahun Ajaran Aktif)";
            }
        }

        // Inisialisasi saldo awal
        $saldo_awal = 0;

        // Mengambil semua data kas dan menghitung saldo kumulatif
        $kas = $kas->get()->map(function ($item) use (&$saldo_awal) {
            // Tentukan pemasukan dan pengeluaran berdasarkan jenis
            $item->pemasukan = $item->jenis === 'pemasukan' ? $item->jumlah : 0;
            $item->pengeluaran = $item->jenis === 'pengeluaran' ? $item->jumlah : 0;
            
            // Hitung saldo berdasarkan pemasukan dan pengeluaran
            $saldo_awal += $item->pemasukan - $item->pengeluaran;
            $item->saldo = $saldo_awal;

            return $item;
        });

        // Hitung total pemasukan dan pengeluaran
        $totalPemasukan = $kas->sum('pemasukan');
        $totalPengeluaran = $kas->sum('pengeluaran');
        $totalSaldo = $totalPemasukan - $totalPengeluaran;

        // Return view dengan data yang sudah diproses
        return view('admin.cetak_kas', compact('kas', 'title', 'totalPemasukan', 'totalPengeluaran', 'totalSaldo', 'tahunAjaran', 'tahunAjaranId'));
    }
}