<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class LaporanTagihanController extends Controller
{
    public function index(Request $request)
    {
        $tagihan = Tagihan::query();
        $title = "";

        // Ambil semua tahun ajaran
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');

        // Jika tahun ajaran dipilih, filter berdasarkan tahun ajaran tersebut
        if ($request->filled('tahun_ajaran_id')) {
            $tagihan = $tagihan->where('tahun_ajaran_id', $request->tahun_ajaran_id);
            $tahunAjaranTerpilih = $tahunAjaran->get($request->tahun_ajaran_id);
            $title .= " Tahun Ajaran " . $tahunAjaranTerpilih;
        } else {
            // Jika tidak ada tahun ajaran yang dipilih, ambil tahun ajaran aktif
            $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();

            if ($tahunAjaranAktif) {
                // Filter berdasarkan tahun ajaran aktif
                $tagihan = $tagihan->where('tahun_ajaran_id', $tahunAjaranAktif->id);
                $title .= " Tahun Ajaran " . $tahunAjaranAktif->tahun_ajaran;
            } else {
                // Jika tidak ada tahun ajaran aktif, kosongkan data
                $tagihan = collect(); // Tidak menampilkan data jika tidak ada tahun ajaran aktif
            }
        }

        // Filter berdasarkan bulan (jika ada)
        if ($request->filled('bulan')) {
            $tagihan = $tagihan->whereMonth('tgl_tagihan', $request->bulan);
            $title .= " Bulan " . ubahNamaBulan($request->bulan);
        }

        // Filter berdasarkan status tagihan (jika ada)
        if ($request->filled('status')) {
            $tagihan = $tagihan->where('status', $request->status);
            $title .= " Status Tagihan " . $request->status;
        }

        // Filter berdasarkan kelas siswa yang sudah naik kelas
        if ($request->filled('kelas')) {
            // Ambil siswa yang berada di kelas yang dipilih
            $kelasNaik = Kelas::where('kelas', $request->kelas)->first();

            if ($kelasNaik) {
                $tagihan = $tagihan->whereIn('siswa_id', function($query) use ($kelasNaik) {
                    $query->select('id')->from('siswas')->where('kelas', $kelasNaik->kelas);
                });
                $title .= " " . $kelasNaik->kelas;
            }
        }

        // Ambil data tagihan sesuai filter
        $tagihan = $tagihan->get();

        // Hitung rekapitulasi
        $totalTagihan = $tagihan->sum('jumlah');

        return view('admin.laporan_tag_index', compact('tagihan', 'title', 'tahunAjaran', 'totalTagihan'));
    } 
}