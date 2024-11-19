<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use App\Models\Pembayaran as Model;
use App\Http\Requests\StorePembayaranRequest;
use App\Models\ArsipTagihan;
use App\Models\Tahun_Ajaran;
use App\Notifications\GagalKonfirmasiNotification;
use App\Notifications\PembayaranKonfirmasiNotification;
use Illuminate\Http\Request;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {

        $models = Pembayaran::with(['tagihan.siswa']);

        if ($request->filled('q')) {
            $models = $models->whereHas('tagihan.siswa', function($query) use ($request) {
                $query->where('nama', 'like', '%' . $request->q . '%')
                    ->orWhere('nis', 'like', '%' . $request->q . '%');
            });
        }

        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tgl_bayar', $request->bulan);
        }

        if ($request->filled('tahun_ajaran')) {
            $models = $models->whereHas('tagihan', function($query) use ($request) {
                $query->where('tahun_ajaran_id', $request->tahun_ajaran);
            });
        }

        if ($request->filled('status')) {
            if ($request->status == 'Sudah_Konfirmasi') {
                $models = $models->whereNotNull('tgl_konfirmasi');
            } elseif ($request->status == 'Belum_Konfirmasi') {
                $models = $models->whereNull('tgl_konfirmasi');
            }
        }

        $models = $models->orderBy('tgl_konfirmasi', 'desc')->paginate(50);
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        return view('admin.pembayaran_index', [
            'models' => $models,
            'title' => 'Daftar Pembayaran Siswa',
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    // public function store(StorePembayaranRequest $request)
    // {
    //     $requestData = $request->validated();
    //     $requestData['tgl_konfirmasi'] = now();
    //     $requestData['metode_pembayaran'] = 'Manual';
    //     $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
    //     // $requestData['wali_id'] = $tagihan->siswa->wali_id ?? 0;
    //     // $totalDibayar = $tagihan->pembayaran->sum('jumlah_bayar') + $requestData['jumlah_bayar'];
        
    //     // if($totalDibayar >= $tagihan->detailTagihan()->sum('jumlah_bayar')){
    //     //     $tagihan->status = 'Lunas';
    //     // }else {
    //     //     $tagihan->status = 'Mengangsur';
    //     // }
    //     $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
    //     $totalDibayar = $tagihan->pembayaran->sum('jumlah_bayar') + $requestData['jumlah_bayar'];
    //     $totalTagihan = $tagihan->detailTagihan()->sum('jumlah_bayar');
    //     // Hitung kekurangan sebelum pembayaran baru
    //     $kekurangan = $totalTagihan - $tagihan->pembayaran->sum('jumlah_bayar');

    //     // Cek apakah pembayaran melebihi kekurangan
    //     if ($requestData['jumlah_bayar'] > $kekurangan) {
    //         flash('Jumlah pembayaran melebihi kekurangan bayar. Mohon periksa kembali.')->error();
    //         return back()->withInput();
    //     }

    //     // Jika pembayaran sama dengan kekurangan, status tagihan menjadi lunas
    //     if ($requestData['jumlah_bayar'] == $kekurangan) {
    //         $tagihan->status = 'Lunas';
    //     } else {
    //         $tagihan->status = 'Mengangsur'; // Jika tidak lunas, berarti masih mengangsur
    //     }
    //     // Ambil tahun ajaran yang aktif
    //     $activeYear = \App\Models\Tahun_Ajaran::where('status', 'aktif')->first();

    //     // Tambahkan tahun ajaran yang aktif ke dalam request data
    //     $requestData['tahun_ajaran_id'] = $activeYear->id;
    //     $tagihan->save();
    //     Pembayaran::create($requestData);


    //      // Tambahkan pemasukan ke kas
    //     $kasController = new KasController();
    //     $kasController->addPemasukanFromPembayaran($requestData['jumlah_bayar'], $requestData['tagihan_id']);
        
    //     flash('Pembayaran Berhasil Disimpan')->success();

    //     // Cek apakah user adalah admin atau operator berdasarkan atribut akses
    //     $user = auth()->user();
    //     if ($user->akses == 'admin') {
    //         // Redirect ke halaman admin.pembayaran_index jika admin
    //         return back();
    //     } elseif ($user->akses == 'operator') {
    //         // Tetap di halaman operator dengan flash message jika operator
    //         return back();
    //     }
    //     // return redirect()->route('admin.pembayaran.index');
    // }
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        $requestData['tgl_bayar'] = $request->tgl_bayar;
        $requestData['tgl_konfirmasi'] = now();
        $requestData['metode_pembayaran'] = 'Manual';
        
        // Ambil tahun ajaran yang aktif
        $activeYear = Tahun_Ajaran::where('status', 'aktif')->first();

        // Cek apakah tagihan ada untuk siswa
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        
        // Dapatkan tahun ajaran siswa
        $tahunAjaranSiswa = $tagihan->siswa->tahun_ajaran_id; // Asumsikan ID tahun ajaran siswa diambil dari relasi

        // // Logika untuk memeriksa tahun ajaran
        // if ($activeYear->id == $tahunAjaranSiswa) {
        //     // Pembayaran diperbolehkan jika tahun ajaran siswa sama dengan tahun ajaran aktif
        // } elseif ($activeYear->id > $tahunAjaranSiswa) {
        //     // Pembayaran diperbolehkan jika tahun ajaran aktif lebih besar (tahun berikutnya)
        // } else {
        //     // Pembayaran tidak diperbolehkan jika tahun ajaran aktif lebih kecil
        //     return redirect()->back()->withErrors(['error' => 'Pembayaran GAGAL karena tahun ajaran yang aktif adalah tahun ajaran sebelumnya.']);
        // }

        // Lanjutkan dengan proses pembayaran jika semua validasi terpenuhi
        $totalDibayar = $tagihan->pembayaran->sum('jumlah_bayar') + $requestData['jumlah_bayar'];
        $totalTagihan = $tagihan->detailTagihan()->sum('jumlah_bayar');
        $kekurangan = $totalTagihan - $tagihan->pembayaran->sum('jumlah_bayar');

        // Cek apakah pembayaran melebihi kekurangan
        if ($requestData['jumlah_bayar'] > $kekurangan) {
            flash('Jumlah pembayaran melebihi kekurangan bayar. Mohon periksa kembali.')->error();
            return back()->withInput();
        }

        // Jika pembayaran sama dengan kekurangan, status tagihan menjadi lunas
        if ($requestData['jumlah_bayar'] == $kekurangan) {
            $tagihan->status = 'Lunas';
        } else {
            $tagihan->status = 'Mengangsur'; // Jika tidak lunas, berarti masih mengangsur
        }

        $siswaId = $tagihan->siswa_id; // Ambil siswa_id dari tagihan
        $requestData['siswa_id'] = $siswaId; // Tambahkan ke request data
        // Tambahkan tahun ajaran yang aktif ke dalam request data
        $requestData['tahun_ajaran_id'] = $activeYear->id;
        $tagihan->save();
        $pembayaran = Pembayaran::create($requestData);
        
        // // Ambil semua pembayaran untuk siswa yang telah lulus
        // $pembayaran = Pembayaran::whereIn('nis', ArsipTagihan::pluck('nis'))->get();
        // Tambahkan pemasukan ke kas
        
        $kasController = new KasController();
        $kasController->addPemasukanFromPembayaran($requestData['jumlah_bayar'], $pembayaran->id);
        
        flash('Pembayaran Berhasil Disimpan')->success();

        // Cek apakah user adalah admin atau operator berdasarkan atribut akses
        $user = auth()->user();
        if ($user->akses == 'admin') {
            return back();
        } elseif ($user->akses == 'operator') {
            return back();
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return view('admin.pembayaran_show', [
            'title' => 'Detail Pembayaran',
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id],
            'pembayaran' => $pembayaran,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }
    public function addPemasukanFromPembayaran($jumlah, $pembayaran_id)
    {
        // Mencari pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);

        // Pastikan pembayaran sudah terkonfirmasi
        if ($pembayaran->tgl_konfirmasi === null) {
            // Pembayaran belum terkonfirmasi, kembalikan dan tidak melakukan apa-apa
            return; // Atau Anda bisa memberikan pesan error sesuai kebutuhan
        }

        // Ambil tahun ajaran dari pembayaran
        $tahunAjaranId = $pembayaran->tahun_ajaran_id;

        // Ambil nama tagihan, jika tidak ada set ke 'Tidak Diketahui'
        $namaTagihan = $pembayaran->tagihan->nama_tag ?? 'Tidak Diketahui';

        // Ambil tanggal bayar dari pembayaran yang baru saja dibuat
        $tanggalBayar = $pembayaran->tgl_bayar; // Ambil tanggal bayar yang baru

        // Simpan data ke tabel kas
        Model::create([
            'jenis' => 'pemasukan',
            'tanggal' => $tanggalBayar, // Simpan tanggal bayar terbaru
            'jumlah' => $jumlah,
            'keterangan' => $namaTagihan,
            'user_id' => auth()->user()->id,
            'tahun_ajaran_id' => $tahunAjaranId // Ambil dari pembayaran
        ]);
    }
    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $wali = $pembayaran->wali;
        $wali->notify(new PembayaranKonfirmasiNotification($pembayaran));
        // Cek apakah sudah dikonfirmasi
        if ($pembayaran->tgl_konfirmasi != null) {
            flash('Pembayaran ini sudah dikonfirmasi')->error();
            return back();
        }
        $pembayaran->tgl_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;

        // Tambahkan pemasukan ke kas
        $kasController = new KasController();
        $kasController->addPemasukanFromPembayaran($pembayaran->jumlah_bayar, $pembayaran->tagihan_id);

        $totalDibayar = $pembayaran->tagihan->pembayaran->sum('jumlah_bayar');
        if($totalDibayar >= $pembayaran->tagihan->detailTagihan()->sum('jumlah_bayar')){
            $pembayaran->tagihan->status = 'Lunas';
        } else {
            $pembayaran->tagihan->status = 'Mengangsur';
        }

        $pembayaran->save();
        $pembayaran->tagihan->save();
        flash('Data Pembayaran Berhasil Disimpan')->success();
        return back();
    }
    
    public function gagalKonfirmasi(Request $request, $id)
    {
        // Temukan pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($id);

        // Update status konfirmasi menjadi 'gagal' dan simpan pesan gagal
        $pembayaran->update([
        ]);

        // Dapatkan wali siswa yang terkait
        $wali = $pembayaran->wali;

        // Kirim notifikasi ke wali siswa jika diperlukan
        if ($wali) {
            $wali->notify(new GagalKonfirmasiNotification($request->pesan));
        }

        return redirect()->back()->with('success', 'Status pembayaran diperbarui dan pesan gagal konfirmasi telah dikirim ke wali siswa.');
    }
    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}