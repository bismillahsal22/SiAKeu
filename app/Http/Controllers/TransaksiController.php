<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTransaksiRequest;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Request as FacadesRequest;

class TransaksiController extends Controller
{
    private $viewIndex = 'tran_index';
    private $viewCreate = 'transaksi_form';
    private $viewEdit = 'transaksi_form';
    private $viewShow = 'tran_show';
    private $routePrefix = 'transaksi';

    public function index()
    {
        // Mengambil tahun ajaran dari user yang sedang login
        $tahunAjaranId = Auth::user()->tahun_ajaran_id;

        // Mengambil daftar siswa berdasarkan tahun ajaran yang dipilih
        $siswaList = Siswa::where('tahun_ajaran_id', $tahunAjaranId)
            ->orderBy('nama')
            ->get()
            ->mapWithKeys(function ($siswa) {
                return [$siswa->id => $siswa->nis . ' - ' . $siswa->nama];
            });
        
        return view('operator.' . $this->viewIndex, [
            'title' => 'Transaksi Pembayaran Siswa',
            'routePrefix' => $this->routePrefix,
            'siswaList' => $siswaList,  // Kirim data siswa ke view
        ]);
    }

    public function show(Request $request)
    {
        $siswaId = $request->input('siswa_id'); // Ambil siswa_id dari request
        $siswa = Siswa::find($siswaId); // Cari siswa berdasarkan siswa_id
        $tagihanList = $siswa ? Tagihan::where('siswa_id', $siswaId)->get() : [];// Ambil tagihan terkait siswa
        
        $model = new Pembayaran(); // Membuat instance baru jika tidak ada data yang diberikan
        // Kirim data ke view
        return view('operator.' . $this->viewIndex, [
            'title' => 'Transaksi Pembayaran Siswa',
            'routePrefix' => $this->routePrefix,
            'siswaList' => Siswa::where('tahun_ajaran_id', Auth::user()->tahun_ajaran_id)
                ->orderBy('nama')
                ->get()
                ->mapWithKeys(function ($siswa) {
                    return [$siswa->id => $siswa->nis . ' - ' . $siswa->nama];
                }),
            'siswa' => $siswa,
            'tagihanList' => $tagihanList,
            'model' => $model,
            'tagihan' => $tagihanList->first(),
        ]);
    }

    public function store(StoreTransaksiRequest $request)
    {
        $request->validate([
            'tagihan_id' => 'required|exists:tagihans,id',
            'tgl_bayar' => 'required|date',
            'jumlah_bayar' => 'required',
        ]);

        // Mencari tagihan yang akan dibayar
        $tagihan = Tagihan::find($request->input('tagihan_id'));

        // Mendapatkan tahun ajaran yang terkait dengan pengguna yang sedang login
        $tahunAjaranId = Auth::user()->tahun_ajaran_id;

        // Mengambil siswa_id dari tagihan terkait
        $siswaId = $tagihan->siswa_id;

        // Lanjutkan dengan proses pembayaran jika semua validasi terpenuhi
        $totalDibayar = $tagihan->pembayaran->sum('jumlah_bayar') + $request['jumlah_bayar'];
        $totalTagihan = $tagihan->detailTagihan()->sum('jumlah_bayar');
        $kekurangan = $totalTagihan - $tagihan->pembayaran->sum('jumlah_bayar');

        // Cek apakah pembayaran melebihi kekurangan
        if ($request['jumlah_bayar'] > $kekurangan) {
            flash('Jumlah pembayaran melebihi kekurangan bayar. Mohon periksa kembali.')->error();
            return back()->withInput();
        }

        // Jika pembayaran sama dengan kekurangan, status tagihan menjadi lunas
        if ($request['jumlah_bayar'] == $kekurangan) {
            $tagihan->status = 'Lunas';
        } else {
            $tagihan->status = 'Mengangsur';
        }

        // Menyimpan pembayaran
        $pembayaran = Pembayaran::create([
            'tagihan_id' => $tagihan->id,
            'tgl_bayar' => $request->input('tgl_bayar'),
            'jumlah_bayar' => $request->input('jumlah_bayar'),
            'metode_pembayaran' => 'Manual',
            'tahun_ajaran_id' => $tahunAjaranId,
            'siswa_id' => $siswaId,
        ]);
        $kasController = new KasController();
    
        flash('Pembayaran berhasil disimpan dan akan dicek kembali oleh Admin')->success();
        return back();
    }
}