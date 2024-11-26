<?php

namespace App\Http\Controllers;

use App\Models\Kas as Model;
use Illuminate\Http\Request;
use App\Http\Requests\StoreKasRequest;
use App\Http\Requests\UpdateKasRequest;
use App\Models\Pembayaran;
use App\Models\Tahun_Ajaran;
use Illuminate\Support\Facades\Storage;

class KasController extends Controller
{
    private $viewCreate = 'kas_form';
    private $viewEdit = 'kas_form';
    private $viewShow = 'kas_show';
    private $routePrefix = 'kas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    // Ambil semua data kas terbaru
    $models = Model::latest();

    // Ambil data tahun ajaran untuk dropdown
    $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');

    // Filter berdasarkan tahun ajaran jika request 'tahun_ajaran' ada
    if ($request->filled('tahun_ajaran')) {
        // Ambil data tahun ajaran berdasarkan id yang dipilih
        $tahunAjaranData = Tahun_Ajaran::find($request->tahun_ajaran);

        // Pastikan data tahun ajaran ditemukan dan memiliki tanggal mulai dan akhir
        if ($tahunAjaranData) {
            $tanggalMulai = $tahunAjaranData->tgl_mulai;
            $tanggalAkhir = $tahunAjaranData->tgl_akhir;

            // Filter data kas berdasarkan rentang tanggal mulai dan tanggal akhir tahun ajaran
            $models = $models->whereBetween('tanggal', [$tanggalMulai, $tanggalAkhir]);
        }
    }

    // Lakukan paginasi pada hasil
    $models = $models->paginate(50);

    // Kirim data ke view
    return view('admin.kas_index', [
        'models' => $models,
        'title' => 'Laporan Kas',
        'tahunAjaran' => $tahunAjaran,
    ]);
}


    
    public function pemasukan(Request $request)
    {
        // Mulai query untuk filter jenis pemasukan
        $pemasukan = Model::where('jenis', 'pemasukan')->latest();

        // Filter berdasarkan bulan jika ada input 'bulan'
        if ($request->filled('bulan')) {
            $pemasukan = $pemasukan->whereMonth('tanggal', $request->bulan);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $pemasukan->where('tahun_ajaran_id', $request->tahun_ajaran);
        }
        

        // Paginate hasil filter
        $pemasukan = $pemasukan->paginate(50);

        // Return ke view dengan data yang difilter
        return view('admin.pemasukan_index', [
            'pemasukan' => $pemasukan,
            'title' => 'Daftar Pemasukan Kas',
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    public function addPemasukanFromPembayaran($jumlah, $pembayaran_id)
    {
        // Mencari pembayaran berdasarkan ID
        $pembayaran = Pembayaran::findOrFail($pembayaran_id);

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

    public function getTotalPemasukan(Request $request)
    {
        $query = Model::where('jenis', 'Pemasukan');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        $totalPemasukan = $query->sum('jumlah');

        return view('admin.dashboard', [
            'totalPemasukan' => $totalPemasukan,
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    public function pengeluaran(Request $request)
    {
        $pengeluaran = Model::where('jenis', 'pengeluaran')->latest();

        if($request->filled('bulan')){
            $pengeluaran = $pengeluaran->whereMonth('tanggal', $request->bulan);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $pengeluaran->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        return view('admin.pengeluaran_index', [
            'pengeluaran' => $pengeluaran->paginate(50),
            'title' => 'Daftar Pengeluaran Kas',
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    public function getTotalPengeluaran(Request $request)
    {
        $query = Model::where('jenis', 'pengeluaran');

        if ($request->filled('bulan')) {
            $query->whereMonth('tanggal', $request->bulan);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        $totalPengeluaran = $query->sum('jumlah');

        return view('admin.dashboard', [
            'totalPengeluaran' => $totalPengeluaran,
            'tahunAjaran' => $tahunAjaran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $jenis = $request->query('jenis', 'pemasukan'); //mengambil nilai jenis dan set default pemasukan
        $validJenis = ['pemasukan', 'pengeluaran'];//hanya ada 2 jenis

        // Cek apakah jenis valid
        if (!in_array($jenis, $validJenis)) {
            $jenis = 'Pemasukan';
        }

        return view('admin.' . $this->viewCreate, [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix. '.store',
            'button' => 'Simpan',
            'jenis' => $jenis,
            'title' => 'Form Tambah ' . ucfirst($jenis)
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreKasRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreKasRequest $request)
    {
        $requestData = $request->validated();
        $requestData = $request->all();
        if($request->hasFile('foto')){
            $requestData['foto'] = $request->file('foto')->store('public');
        } 
        $requestData['user_id'] = auth()->user()->id;
        Model::create($requestData);

        if ($requestData['jenis'] === 'pemasukan') {
            flash('Pemasukan Berhasil Ditambahkan')->success();
            return redirect()->route('pemasukan.index');
        } elseif ($requestData['jenis'] === 'pengeluaran') {
            flash('Pengeluaran Berhasil Ditambahkan')->success();
            return redirect()->route('pengeluaran.index');
        }

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil disimpan');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function show(Model $kas)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        // Ambil data kas berdasarkan ID
        $kas = Model::findOrFail($id);
        $validJenis = ['pemasukan', 'pengeluaran'];

        // Jika jenis tidak valid, redirect ke halaman index
        if (!in_array($kas->jenis, $validJenis)) {
            return redirect()->route('kas.index')->with('error', 'Jenis kas tidak valid');
        }

        // Kirim data kas dan jenis ke view
        return view('admin.kas_form', [
            'model' => $kas,
            'jenis' => $kas->jenis,
            'method' => 'PUT',
            'button' => 'Update',
            'route' => [$this->routePrefix .'.update', $id],
            'title' => 'Form Edit ' . ucfirst($kas->jenis),
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateKasRequest  $request
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateKasRequest $request, $id)
    {
        // Validasi data dari request
        $requestData = $request->validated();
        // Ambil data kas berdasarkan ID
        $kas = Model::findOrFail($id);
        if($request->hasFile('foto')){
            if($kas->foto != null && Storage::exists($kas->foto))
            {
                Storage::delete($kas->foto);
            }
            $requestData['foto'] = $request->file('foto')->store('public');
        }

        // Perbarui data kas dengan data yang baru
        $kas->update($requestData);

        // Redirect sesuai jenis
        if ($kas->jenis === 'pemasukan') {
            return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil diperbarui');
        } elseif ($kas->jenis === 'pengeluaran') {
            return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil diperbarui');
        }

        // Redirect ke halaman index jika jenis tidak valid
        return redirect()->route('kas.index')->with('success', 'Data kas berhasil diperbarui');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Kas  $kas
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $kas = Model::findOrFail($id);
        $kas->delete();

        if ($kas->jenis === 'pemasukan') {
            return redirect()->route('pemasukan.index')->with('success', 'Data pemasukan berhasil dihapus');
        } elseif ($kas->jenis === 'pengeluaran') {
            return redirect()->route('pengeluaran.index')->with('success', 'Data pengeluaran berhasil dihapus');
        }

        return redirect()->route('kas.index')->with('success', 'Data kas berhasil dihapus');
    }

    public function print(Request $request)
    {
        $models = Model::latest()->get();

        // Filter berdasarkan bulan jika ada input 'bulan'
        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tanggal', $request->bulan);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $models = $models->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        return view('admin.cetak_kas', [
            'models' => $models,
        ]);
    }
}