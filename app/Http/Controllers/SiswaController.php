<?php

namespace App\Http\Controllers;

use App\Models\ArsipTagihan;
use App\Models\User;
use App\Models\Kelas;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use \App\Models\Siswa as Model;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Illuminate\Support\Facades\Storage;

class SiswaController extends Controller
{
    private $viewIndex = 's_index';
    private $viewCreate = 's_form';
    private $viewEdit = 's_form';
    private $viewShow = 's_show';
    private $routePrefix = 'siswa';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // Ambil data siswa yang belum lulus, beserta relasi yang diperlukan
        $query = Siswa::with('wali', 'user', 'tahunAjaran', 'kelas')
            ->where('status_siswa', '!=', 'Lulus')
            ->orderBy('nama', 'asc');

        // Hitung total siswa yang belum lulus
        $totalSiswa = $query->count();

        // Filter berdasarkan tahun ajaran jika diberikan
        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $query->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

        // Filter berdasarkan kelas jika diberikan
        $kelas = Kelas::pluck('kelas', 'kelas');
        if ($request->filled('kelas')) {
            $query->where('kelas', $request->kelas);
        }

        if ($request->filled('q')) {
            $query = $query->search($request->q);
        }

        // Dapatkan hasil query dengan pagination
        $models = $query->paginate(settings()->get('app_pagination', 50));

        // Memindahkan siswa yang telah lulus ke dalam tabel arsip
        $siswaLulus = Siswa::where('status_siswa', 'Lulus')->get();
        foreach ($siswaLulus as $s) {
            // Simpan data siswa ke dalam tabel arsip
            ArsipTagihan::create([
                'nis' => $s->nis,
                'nama' => $s->nama,
                'kelas' => $s->kelas,
                'tahun_ajaran_id' => $s->tahun_ajaran_id,
                // Jika Anda ingin menyimpan jumlah bayar dari tagihan ke arsip,
                // pastikan untuk menambahkan logika yang relevan di sini
            ]);

            // Hapus siswa dari tabel siswa
            $s->delete();
        }

        // Kirim data ke view
        return view('admin.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Daftar Siswa',
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
            'totalSiswa' => $totalSiswa,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => new \App\Models\User(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
            'title' => 'Form Tambah Siswa',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
            'tahun_ajaran_id' => Tahun_Ajaran::pluck('tahun_ajaran', 'id'),
            'kelas' => Kelas::pluck('kelas', 'kelas'),
        ];
        return view('admin.' . $this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'wali_id' => 'nullable',
            'nama' => 'required',
            'nis' => 'required|unique:siswas',
            'tahun_ajaran_id' => 'required',
            'kelas' => 'required',
            'tempat_lahir' => 'required',
            'tgl_lahir' => 'required',
            'jk' => 'required',
            'nohp' => 'nullable',
            'alamat' => 'required',
            'ayah' => 'required',
            'ibu' => 'required',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
        ]);

        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['status_wali'] = 'ok';
        }

        $requestData['user_id'] = auth()->user()->id;
        $siswa = Model::create($requestData);
        flash('Siswa berhasil ditambahkan dan disimpan')->success();
        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $siswa = Siswa::with('tahunAjaran')->findOrFail($id);

        return view('admin.' . $this->viewShow, [
            'model' => $siswa,
            'title' => 'Detail Siswa',
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'Update',
            'title' => 'Form Edit Data Siswa',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
            'tahun_ajaran_id' => Tahun_Ajaran::pluck('tahun_ajaran', 'id'),
            'kelas' => Kelas::pluck('kelas', 'kelas'),
        ];
        return view('admin.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        if ($request->isMethod('post') && !$request->is('import/*')) {
            $requestData = $request->validate([
                'wali_id' => 'nullable',
                'nama' => 'required',
                'nis' => 'required|unique:siswas,nis,' . $id,
                'tahun_ajaran_id' => 'required',
                'kelas' => 'required',
                'tempat_lahir' => 'required',
                'tgl_lahir' => 'required',
                'jk' => 'required',
                'nohp' => 'nullable',
                'alamat' => 'required',
                'ayah' => 'required',
                'ibu' => 'required',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
            ]);
        } else {
            $requestData = $request->validate([
                'nama' => 'required',
                'nis' => 'required|unique:siswas,nis,' . $id,
                'tahun_ajaran_id' => 'required',
                'kelas' => 'nullable',
                'tempat_lahir' => 'nullable',
                'tgl_lahir' => 'nullable',
                'jk' => 'nullable',
                'nohp' => 'nullable',
                'alamat' => 'nullable',
                'ayah' => 'nullable',
                'ibu' => 'nullable',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:5000'
            ]);
        }

        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($model->foto != null && Storage::exists($model->foto)) {
                Storage::delete($model->foto);
            }
            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['status_wali'] = 'ok';
        }

        $requestData['user_id'] = auth()->user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data siswa berhasil diubah');
        return redirect()->route('siswa.index');
    }

    private function getNextKelas($kelasSaatIni)
    {
        $kelasMap = [
            'X-E1' => 'XI-F1',
            'XI-F1' => 'XII-IPA 1',
            'XII-IPA 1' => 'Lulus',
            'X-E2' => 'XI-F2',
            'XI-F2' => 'XII-IPA 2',
            'XII-IPA 2' => 'Lulus',
            'X-E3' => 'XI-F3',
            'XI-F3' => 'XII-IPA 3',
            'XII-IPA 3' => 'Lulus',
            'X-E4' => 'XI-F4',
            'XI-F4' => 'XII-IPA 4',
            'XII-IPA 4' => 'Lulus',
            'X-E5' => 'XI-F5',
            'XI-F5' => 'XII-IPS 1',
            'XII-IPS 1' => 'Lulus',
            'X-E6' => 'XI-F6',
            'XI-F6' => 'XII-IPS 2',
            'XII-IPS 2' => 'Lulus',
            'X-E5' => 'XI-F5',
            'XI-F5' => 'XII-IPS 3',
            'XII-IPS 3' => 'Lulus',
            
        ];

        return $kelasMap[$kelasSaatIni] ?? null;
    }

    public function naikKelas(Request $request)
    {
        $tahunAjaranSekarang = Tahun_Ajaran::where('status', 'aktif')->first();
        if (!$tahunAjaranSekarang) {
            flash('Tahun ajaran aktif tidak ditemukan.')->error();
            return redirect()->back();
        }

        // Cek apakah kenaikan kelas sudah dilakukan pada tahun ajaran ini
        $tahunAjaranSudahDigunakan = Siswa::where('tahun_ajaran_id', $tahunAjaranSekarang->id)
            ->where('naik_kelas', true)
            ->exists();

        if ($tahunAjaranSudahDigunakan) {
            flash('Kenaikan kelas sudah dilakukan untuk tahun ajaran ini.')->error();
            return redirect()->back();
        }

        // Ambil semua siswa yang belum lulus
        $siswas = Siswa::where('status_siswa', '!=', 'Lulus')->get();

        if ($siswas->isEmpty()) {
            flash('Tidak ada siswa yang dapat dinaikkan kelas.')->info();
            return redirect()->back();
        }

        foreach ($siswas as $siswa) {
            $kelasSaatIni = $siswa->kelas;
            $kelasNaik = $this->getNextKelas($kelasSaatIni);

            \Log::info("Kenaikan kelas: {$siswa->nis} dari {$kelasSaatIni} ke {$kelasNaik}");

            if ($kelasNaik === null) {
                // Log warning jika kelas tidak ditemukan dalam mapping
                flash("Kelas {$kelasSaatIni} tidak ditemukan dalam mapping kenaikan kelas.")->warning();
                continue;
            }

            // Jika siswa berada di kelas 12 (XII IPA, XII IPS)
            if (strpos($kelasSaatIni, 'XII') !== false) {
                $tahunAjaranLulus = $siswa->tahun_ajaran_id;
                $kelasLulus = $siswa->kelas;
                $siswa->status_siswa = 'Lulus';

                // Logika arsip tagihan dan penghapusan siswa
                $tagihans = $siswa->tagihan()->whereIn('status', ['Baru', 'Mengangsur', 'Lunas'])->get();
                if ($tagihans->isNotEmpty()) {
                    foreach ($tagihans as $tagihan) {
                        // Proses arsip
                        ArsipTagihan::updateOrCreate(
                            ['nis' => $siswa->nis, 'tahun_ajaran_id' => $tahunAjaranLulus],
                            [
                                'nama' => $siswa->nama,
                                'kelas' => $kelasLulus, 
                                'jumlah_tag' => $tagihan->jumlah,
                                'jumlah_bayar' => $tagihan->pembayaran()->sum('jumlah_bayar'),
                                'kekurangan' => $tagihan->jumlah - $tagihan->pembayaran()->sum('jumlah_bayar'),
                                'status' => $tagihan->status,
                            ]
                        );
                        Pembayaran::where('tagihan_id', $tagihan->id)->delete();
                        $tagihan->delete();
                    }
                } else {
                    // Arsip siswa tanpa tagihan
                    ArsipTagihan::create([
                        'nis' => $siswa->nis,
                        'nama' => $siswa->nama,
                        'kelas' => $kelasLulus,
                        'tahun_ajaran_id' => $tahunAjaranLulus,
                        'jumlah_tag' => 0,
                        'jumlah_bayar' => 0,
                        'kekurangan' => 0,
                        'status' => 'Lulus',
                    ]);
                }
                $siswa->delete();
            } else {
                $siswa->kelas = $kelasNaik;
                $siswa->naik_kelas = true;
                $siswa->tahun_ajaran_id = $tahunAjaranSekarang->id;
                $siswa->save();
            }
        }

        flash('Kelas siswa berhasil dinaikkan.')->success();
        return redirect()->route('siswa.index');
    }

}