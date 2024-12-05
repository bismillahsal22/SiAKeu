<?php

namespace App\Http\Controllers;

use App\Charts\DashboardChart;
use App\Models\Kas;
use App\Models\Pembayaran;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Auth;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index(Request $request, DashboardChart $dashboardChart)
    {
        $tahunAjaranAktif = Tahun_Ajaran::where('status', 'aktif')->first();
    
        if (!$tahunAjaranAktif) {
            $data = [
                'siswa' => 0,
                'totalPemasukan' => 0,
                'totalPengeluaran' => 0,
                'sisaSaldo' => 0,
                'dataBayarBelumKonfirmasi' => collect(),
                'tagihanLunas' => 0,
                'tagihanMengangsur' => 0,
                'tagihanBaru' => 0,
                'totalTagihan' => 0,
                'tagihanBelumLunas' => 0,
                'dashboardChart' => $dashboardChart->build([0, 0]),
                'tahun_ajaran_aktif' => null
            ];
    
            return view('admin.dashboard', $data)->with('warning', 'Belum ada tahun ajaran aktif');
        }
    
        // Ambil tanggal mulai dan tanggal akhir dari tahun ajaran aktif
        $tanggalMulai = $tahunAjaranAktif->tgl_mulai;
        $tanggalAkhir = $tahunAjaranAktif->tgl_akhir;
    
        // Ambil jumlah siswa berdasarkan tahun ajaran aktif
        $data['siswa'] = Siswa::where('tahun_ajaran_id', $tahunAjaranAktif->id)
            ->where('status_siswa', '<>', 'Lulus')
            ->count();
    
        // Filter pemasukan berdasarkan tahun ajaran aktif
        $pemasukan = Kas::where('jenis', 'Pemasukan')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->get();
        $data['totalPemasukan'] = $pemasukan->sum('jumlah');
    
        // Filter pengeluaran berdasarkan tahun ajaran aktif
        $pengeluaran = Kas::where('jenis', 'pengeluaran')
            ->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir])
            ->get();
        $data['totalPengeluaran'] = $pengeluaran->sum('jumlah');
    
        // Hitung sisa saldo
        if ($pemasukan->isNotEmpty() || $pengeluaran->isNotEmpty()) {
            $data['sisaSaldo'] = $data['totalPemasukan'] - $data['totalPengeluaran'];
        } else {
            $data['sisaSaldo'] = 0;
        }
    
        // Pembayaran yang belum dikonfirmasi
        $data['dataBayarBelumKonfirmasi'] = Pembayaran::whereNull('tgl_konfirmasi')
            ->whereHas('tagihan', function ($query) use ($tahunAjaranAktif) {
                $query->where('tahun_ajaran_id', $tahunAjaranAktif->id);  
            })
            ->get();
    
        // Ambil tagihan dari siswa yang masih aktif pada tahun ajaran aktif
        $tagihanAktif = Tagihan::with('siswa')
        ->where('tahun_ajaran_id', $tahunAjaranAktif->id)  // Filter tagihan berdasarkan tahun ajaran aktif
        ->whereHas('siswa', function($query) {
            // Ambil hanya tagihan dari siswa yang masih aktif (status_siswa != 'Lulus')
            $query->where('status_siswa', '<>', 'Lulus');
        })
        ->get();

        // Ambil tagihan dari siswa yang masih aktif pada tahun ajaran sebelumnya
        $tagihanSebelumnya = Tagihan::with('siswa')
        ->whereHas('siswa', function($query) {
            // Ambil hanya tagihan dari siswa yang masih aktif
            $query->where('status_siswa', '<>', 'Lulus');
        })
        ->where('tahun_ajaran_id', '<>', $tahunAjaranAktif->id)  // Tagihan dari tahun ajaran yang berbeda (tahun ajaran sebelumnya)
        ->get();

        // Gabungkan tagihan dari tahun ajaran aktif dan tahun ajaran sebelumnya
        $tagihan = $tagihanAktif->merge($tagihanSebelumnya);
        
        // Menghitung jumlah tagihan berdasarkan status
        $data['tagihanLunas'] = $tagihan->where('status', 'Lunas')->count();
        $data['tagihanMengangsur'] = $tagihan->where('status', 'Mengangsur')->count();
        $data['tagihanBaru'] = $tagihan->where('status', 'Baru')->count();
    
        // Hitung total tagihan yang belum lunas
        $data['totalTagihan'] = $tagihan->count();
        $data['tagihanBelumLunas'] = $data['tagihanBaru'] + $data['tagihanMengangsur'];
    
        // Membuat chart berdasarkan data tagihan
        $data['dashboardChart'] = $dashboardChart->build([
            intval($data['tagihanLunas']),
            intval($data['tagihanBelumLunas']),
        ]);
    
        // Mengirim data ke view
        $data['tahun_ajaran_aktif'] = $tahunAjaranAktif;
    
        return view('admin.dashboard', $data);
    }
    
    public function showLandingPageWali()
    {
        return view('auth.login_app_wali');
    }
}