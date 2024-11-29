<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Models\Tagihan as Model;
use App\Http\Requests\StoreTagihanRequest;
use App\Models\DetailTagihan;
use App\Models\Pembayaran;
use App\Models\User;
use App\Notifications\TagihanNotification;
use Notification;

class TagihanController extends Controller
{
    private $viewIndex = 'tag_index';
    private $viewCreate = 'tag_form';
    private $viewEdit = 'tag_form';
    private $viewShow = 'tag_show';
    private $routePrefix = 'tagihan';

    public function index(Request $request)
    {
        $models = Model::orderBy('tgl_tagihan', 'asc');
        
        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tgl_tagihan', $request->bulan);
        }

        $kelas = Kelas::pluck('kelas', 'kelas');
        if ($request->filled('kelas')) {
            $models = $models->where('kelas', $request->kelas);
        }

        $tahunAjaran = Tahun_Ajaran::pluck('tahun_ajaran', 'id');
        if ($request->filled('tahun_ajaran')) {
            $models = $models->where('tahun_ajaran_id', $request->tahun_ajaran);
        }

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
            'tahunAjaran' => $tahunAjaran,
            'kelas' => $kelas,
        ]);
    }

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
                'tahun_ajaran' => $siswa->tahunAjaran ? $siswa->tahunAjaran->tahun_ajaran : null,
                'tahun_ajaran_id' => $siswa->tahun_ajaran_id,
            ]);
        }
        return response()->json(null);
    }

    public function store(StoreTagihanRequest $request)
    {
        // Validasi request
        $requestData = $request->validated();
        
        // Debug: Verifikasi data request yang sudah tervalidasi
        \Log::info('Validated Request Data: ', $requestData);

        if ($requestData['nis'] === '-') {
            $requestData['nis'] = 'NIS_TIDAK_TERSEDIA';
        }

        $siswaQuery = Siswa::query();
        $tahunAjaranId = $requestData['tahun_ajaran_id'];
        $kelasQuery = Kelas::query();

        if ($requestData['nama'] != '') {
            $siswaQuery->where('nama', $requestData['nama']);
        }
        if ($requestData['nis'] != '') {
            $siswaQuery->where('nis', $requestData['nis']);
        }
        if ($requestData['kelas'] != '') {
            $kelasQuery->where('kelas', $requestData['kelas']);
        }

        $siswa = $siswaQuery->get();
        $kelas = $kelasQuery->get();

        // Debug: Mengecek siswa dan kelas yang ditemukan
        \Log::info('Siswa yang ditemukan: ', $siswa->toArray());
        \Log::info('Kelas yang ditemukan: ', $kelas->toArray());

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
                
                $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                    ->whereMonth('tgl_tagihan', $bulanTagihan)
                    ->whereYear('tgl_tagihan', $tahunTagihan)
                    ->first();

                // Jika tidak ada tagihan sebelumnya, buat tagihan baru
                if (!$cekTagihan) {
                    // Membuat tagihan baru
                    $tagihan = Model::create($requestData);

                    // Debug: Verifikasi tagihan yang baru dibuat
                    \Log::info('Tagihan berhasil disimpan: ', $tagihan->toArray());

                    // Kirim notifikasi
                    $wali = User::whereIn('id', $itemSiswa->pluck('wali_id'))->get();
                    Notification::send($wali, new TagihanNotification($tagihan));

                    // Simpan detail tagihan
                    DetailTagihan::create([
                        'tagihan_id' => $tagihan->id,
                        'nama_bayar' => $requestData['nama_tag'],
                        'jumlah_bayar' => $requestData['jumlah'],
                    ]);

                    // Debug: Verifikasi detail tagihan yang disimpan
                    \Log::info('Detail tagihan berhasil disimpan');
                }
            }
        }

        flash('Tagihan Berhasil Ditambahkan')->success();
        return redirect()->route('tagihan.index');
    }

    public function show(Request $request, $id)
    {
        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tgl_tagihan)->format('F Y');
        $data['model'] = new Pembayaran();
        return view('admin.' . $this->viewShow, $data);
    }

    public function destroy($tagihan)
    {
        $model = Model::findOrFail($tagihan);
        $model->delete();
        flash('Tagihan berhasil dihapus')->error();
        return back();
    }
}