<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Jenis_Pembayaran;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Models\DetailTagihan;
use App\Models\Pembayaran;
use App\Models\Tagihan;
use App\Notifications\TagihanNotification;
use Notification;

class TagihanController extends Controller
{
    private $viewIndex = 'tag_index';
    private $viewCreate = 'tag_form';
    private $viewEdit = 'tag_form';
    private $viewShow = 'tag_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Model::orderBy('tgl_tagihan', 'asc');;
        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tgl_tagihan', $request->bulan);
        }
        // Filter berdasarkan kelas jika diberikan
        $kelas = Kelas::pluck('kelas', 'kelas');
        if ($request->filled('kelas')) {
            $models = $models->where('kelas', $request->kelas);
        }

        // Mengambil data tahun ajaran
        // $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        // if ($request->filled('tahun_ajaran')) {
        //     $models = $models->where('tahun_ajaran_id', $request->tahun_ajaran);
        // }

        if ($request->filled('q')) {
            $models = $models->search($request->q);
        }

        if ($request->filled('status')) {
            $models = $models->where('status', $request->status);
        }

        return view('admin.' . $this->viewIndex, [
            'models' => $models->paginate(50),
            'routePrefix' => $this->routePrefix,
            'title' => 'Daftar Tagihan Siswa',
            'kelas' => $kelas,
            // 'tahunAjaran' => $tahunAjaran,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $siswa = Siswa::all();
        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'Simpan',
            'title' => 'Form Tambah Tagihan Siswa',
            'nama' => Siswa::where('status_siswa', '!=', 'Lulus')->pluck('nama', 'nama'),
            'nama_tag' => 'Sumbangan Sukarela Orang Tua',
        ];
        return view('admin.' . $this->viewCreate, $data);
    }

    public function getSiswaDetails(Request $request)
    {
        $siswa = Siswa::where('nama', $request->nama)->with('tahunAjaran')->first();

        if ($siswa) {
            return response()->json([
                'nis' => $siswa->nis,
                'kelas' => $siswa->kelas,
                'tahun_ajaran' => $siswa->tahunAjaran ? $siswa->tahunAjaran->tahun_ajaran : null, // Kembalikan nama tahun ajaran
                'tahun_ajaran_id' => $siswa->tahun_ajaran_id, // Tetap mengembalikan ID untuk penyimpanan
            ]);
        }
        return response()->json(null);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        $requestData = $request->validated();
        // Memastikan NIS diatur dengan benar
        if ($requestData['nis'] === '-') {
            $requestData['nis'] = 'NIS_TIDAK_TERSEDIA'; // Ganti dengan nilai khusus
        }

        $siswa = Siswa::query();
        $tahunAjaranId = $requestData['tahun_ajaran_id'];
        $kelas = Kelas::query();

        // Proses pencarian siswa
        if ($requestData['nama'] != '') {
            $siswa->where('nama', $requestData['nama']);
        }
        if ($requestData['nis'] != '') {
            $siswa->where('nis', $requestData['nis']);
        }
        if ($requestData['kelas'] != '') {
            $kelas->where('kelas', $requestData['kelas']);
        }
        $siswa = $siswa->get();
        $kelas = $kelas->get();

        // Proses penyimpanan tagihan
        foreach ($siswa as $itemSiswa) {
            foreach ($kelas as $itemKelas) {
                $requestData['siswa_id'] = $itemSiswa->id;
                $requestData['tahun_ajaran_id'] = $tahunAjaranId;
                $requestData['status'] = 'Baru';

                // Cek tagihan yang sudah ada
                $tglTagihan = Carbon::parse($requestData['tgl_tagihan']);
                $bulanTagihan = $tglTagihan->format('m');
                $tahunTagihan = $tglTagihan->format('Y');
                $tglTagihan = Carbon::parse($requestData['tgl_tagihan'])->format('Y-m-d');
                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->whereMonth('tgl_tagihan', Carbon::parse($tglTagihan)->format('m'))
                    ->whereYear('tgl_tagihan', Carbon::parse($tglTagihan)->format('Y'))
                    ->first();

                if (
                    $cekTagihan == null
                ) {
                    $requestData['tgl_tagihan'] = $tglTagihan;
                    $tagihan = Model::create($requestData);
                    $wali = \App\Models\User::whereIn('id', $siswa->pluck('wali_id'))->get();
                    Notification::send($wali, new TagihanNotification($tagihan));

                    // Simpan detail tagihan
                    DetailTagihan::create([
                        'tagihan_id' => $tagihan->id,
                        'nama_bayar' => $requestData['nama_tag'],
                        'jumlah_bayar' => $requestData['jumlah'],
                    ]);
                }
            }
        }

        flash('Tagihan Berhasil Ditambahkan')->success();
        return redirect()->route('tagihan.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tgl_tagihan)->format('F Y');
        $data['model'] = new Pembayaran();
        return view('admin.' . $this->viewShow, $data);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}