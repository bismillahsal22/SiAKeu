<?php

namespace App\Http\Controllers;

use App\Http\Middleware\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use \App\Models\Tahun_Ajaran as Model;

class TahunAjaranController extends Controller
{
    private $viewIndex = 'th_index';
    private $viewCreate = 'th_form';
    private $viewEdit = 'th_form';
    private $viewShow = 'th_show';
    private $routePrefix = 'tahun_ajaran';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q')){
            $models = Model::search($request->q)
            ->orderBy('tahun_ajaran', 'asc')
            ->paginate(50);
        }else{
            $models = Model::orderBy('tahun_ajaran', 'asc')->paginate(50);
        }
        return view('admin.' .$this->viewIndex, [
            'models' =>  $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Tahun Ajaran',
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
            'route' => $this->routePrefix. '.store',
            'button' => 'Simpan', 
            'title' => 'Form Tambah Tahun Ajaran',
        ];
        return view('admin.' .$this->viewCreate, $data);
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
            'tahun_ajaran' => 'required|unique:tahun__ajarans,tahun_ajaran,',
            'tgl_mulai' => 'required|date',
            'tgl_akhir' => 'required|date|after_or_equal:tgl_mulai',
        ]);
        // Menonaktifkan semua tahun ajaran yang aktif
        Model::where('status', 'aktif')->update(['status' => 'tidak aktif']);

        // Menyimpan tahun ajaran baru dan mengaturnya sebagai aktif
        $requestData['status'] = 'aktif'; // Set status jadi aktif untuk tahun ajaran baru
        Model::create($requestData);
        flash('Tahun Ajaran berhasil ditambahkan dan disimpan')->success();
        return redirect()->route('tahun_ajaran.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
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
            'route' => [$this->routePrefix .'.update', $id],
            'button' => 'Update',
            'title' => 'Form Edit Tahun Ajaran',
        ];
        return view('admin.' .$this->viewEdit, $data);
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
        $requestData = $request->validate([
            'tahun_ajaran' => 'required',
            'tgl_mulai' => 'nullable',
            'tgl_akhir' => 'nullable|after_or_equal:tgl_mulai',
        ]);
        $model = Model::findOrFail($id);
        
        // Jika tidak ada input untuk tgl_mulai, tetap gunakan nilai lama
        if (!$request->has('tgl_mulai') || $request->input('tgl_mulai') === null) {
            $requestData['tgl_mulai'] = $model->tgl_mulai;
        }

        if (!$request->has('tgl_akhir') || $request->input('tgl_akhir') === null) {
            $requestData['tgl_akhir'] = $model->tgl_akhir;
        }

        $model->fill($requestData);
        $model->save();
        flash('Tahun Ajaran berhasil diubah');
        return redirect()->route('tahun_ajaran.index');
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        flash('Tahun Ajaran berhasil dihapus')->error();
        return back();
    }

    public function activate($id)
    {
        // Menonaktifkan semua tahun ajaran
        Model::where('status', 'aktif')->update(['status' => 'tidak aktif']);
        
        // Mengaktifkan tahun ajaran yang dipilih
        $tahunAjaran = Model::findOrFail($id);
        $tahunAjaran->status = 'aktif';
        $tahunAjaran->save();

        flash('Tahun Ajaran berhasil diaktifkan')->success();
        return redirect()->route('tahun_ajaran.index');
    }

    public function deactivate($id)
    {
        // Menonaktifkan tahun ajaran yang dipilih
        $tahunAjaran = Model::findOrFail($id);
        $tahunAjaran->status = 'tidak aktif';
        $tahunAjaran->save();

        flash('Tahun Ajaran berhasil dinonaktifkan')->error();
        return redirect()->route('tahun_ajaran.index');
    }
    
}