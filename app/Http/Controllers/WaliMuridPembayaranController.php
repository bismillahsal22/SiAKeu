<?php

namespace App\Http\Controllers;

use Auth;
use Notification;
use App\Models\Bank;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\WaliBank;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Notifications\PembayaranNotification;

class WaliMuridPembayaranController extends Controller
{
    public function index()
    {
        $models = Pembayaran::latest()->orderBy('tgl_konfirmasi', 'desc')->paginate(50);
        $data['models'] = $models;
        return view('wali_siswa.pembayaran_index', $data);
    }

    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->markAsRead();
        return view('wali_siswa.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id]
        ]);
    }

    public function create(Request $request)
    {
        $data['listwalibank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');

        $data['tagihan'] = Tagihan::WaliSiswa()->findOrFail($request->tagihan_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['title'] = 'Konfirmasi Transfer';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id');
        $data['listBank'] = Bank::pluck('nama_bank', 'id');

        if ($request->bank_sekolah_id != '') {
            $data['bankPilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }
        $data['url'] = route('wali.pembayaran.create', [
            'tagihan_id' => $request->tagihan_id,
        ]);
        return view('wali_siswa.pembayaran_form', $data);
    }
    
    public function store(Request $request)
    {
        // Validasi input untuk bank pengirim harus diisi
        if ($request->wali_bank_id == '' && $request->nomor_rekening == '') {
            flash('Silahkan Pilih Bank Pengirim Milik Anda')->error();
            return back();
        }

        // Jika pengguna membuat rekening baru
        if ($request->nama_rekening != '' && $request->nomor_rekening != '') {
            $bankId = $request->bank_id;
            $bank = Bank::findOrFail($bankId);

            // Validasi dan simpan data rekening baru
            $requestDataBank = $request->validate([
                'nama_rekening' => 'required',
                'nomor_rekening' => 'required',
            ]);

            // Simpan rekening baru untuk wali murid
            $waliBank = WaliBank::firstOrCreate(
                $requestDataBank,
                [
                    'nama_rekening' => $requestDataBank['nama_rekening'],
                    'wali_id' => Auth::user()->id,
                    'kode' => $bank->sandi_bank,
                    'nama_bank' => $bank->nama_bank,
                ]
            );

            // Gunakan rekening baru yang baru saja dibuat
            $waliBankId = $waliBank->id;

        } else {
            // Jika menggunakan rekening yang sudah ada
            $waliBankId = $request->wali_bank_id;
            $waliBank = WaliBank::findOrFail($waliBankId);
        }

        // Validasi pembayaran
        $jumlahBayar = str_replace('.', '', $request->jumlah_bayar);

        // Cek apakah pembayaran sudah pernah dilakukan
        $validasiPembayaran = Pembayaran::where('jumlah_bayar', $jumlahBayar)
            ->where('tagihan_id', $request->tagihan_id)
            ->first();

        if ($validasiPembayaran != null) {
            flash('Data Pembayaran ini sudah pernah dilakukan. Akan segera diKonfirmasi oleh pihak sekolah');
            return back();
        }

        // Validasi input pembayaran
        $request->validate([
            'tgl_bayar' => 'required',
            'bukti_bayar' => 'required|image|mimes:jpeg,png,jpg|max:5000',
        ]);

        // Simpan bukti pembayaran
        $buktiBayar = $request->file('bukti_bayar')->store('public');
        // Data untuk disimpan dalam tabel pembayaran
        $dataPembayaran = [
            'bank_sekolah_id' => $request->bank_sekolah_id,
            'wali_bank_id' => $waliBankId,  // Gunakan ID rekening baru atau yang dipilih
            'tagihan_id' => $request->tagihan_id,
            'wali_id' => auth()->user()->id,
            'tgl_bayar' => $request->tgl_bayar . ' ' . date('H:i:s'),
            'jumlah_bayar' => $jumlahBayar,
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'Transfer',
            'user_id' => 0,
        ];

        // Mulai transaksi untuk simpan pembayaran
        DB::beginTransaction();
        try {
            // Simpan pembayaran ke database
            $pembayaran = Pembayaran::create($dataPembayaran);

            // Kirim notifikasi ke admin
            $userAdmin = User::where('akses', 'admin')->get();
            Notification::send($userAdmin, new PembayaranNotification($pembayaran));

            DB::commit();
        } catch (\Throwable $th) {
            DB::rollback();
            flash('Konfirmasi pembayaran gagal disimpan')->error();
            return back();
        }

        // Tampilkan pesan sukses dan redirect ke halaman pembayaran
        flash('Pembayaran berhasil Disimpan dan akan segera di Konfirmasi oleh Pihak Sekolah')->success();
        return redirect()->route('wali.pembayaran.show', $pembayaran->id);
    }
    

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->tgl_konfirmasi != null) {
            flash('Data Pembayaran ini sudah dikonfirmasi, tidak dapat dihapus')->error();
            return back();
        }
        \Storage::delete($pembayaran->bukti_bayar);
        $pembayaran->delete();;
        flash('Data Pembayaran berhasil Dihapus')->error();
        return redirect()->route('wali.pembayaran.index');
    }
}