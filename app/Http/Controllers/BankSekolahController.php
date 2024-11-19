<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use Illuminate\Http\Request;
use \App\Models\BankSekolah as Model;

class BankSekolahController extends Controller
{
    private $viewIndex = 'banksekolah_index';
    private $viewCreate = 'banksekolah_form';
    private $viewEdit = 'banksekolah_form';
    private $viewShow = 'banksekolah_show';
    private $routePrefix = 'banksekolah';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $models = Model::where('akses', '<>', 'wali')->latest()->paginate(50);
        // $data['models'] = $models;
        // return view('admin.u_index', $data);

        $models = Model::latest()->paginate(50);

        return view('admin.' .$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Rekening SMA Negeri 1 Seyegan'
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
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix. '.store',
            'button' => 'Simpan', 
            'title' => 'Form Tambah Rekening Sekolah',
            'listBank' => \App\Models\Bank::pluck('nama_bank', 'id'),
        ];
        return view('admin.' .$this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankSekolahRequest $request)
    {
        $requestData = $request->validated();
        $bank = \App\Models\Bank::find($request['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;
        
        Model::create($requestData);
        flash('Rekening Sekolah berhasil ditambahkan')->success();
        return redirect()->route('banksekolah.index');
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
            'listBank' => \App\Models\Bank::pluck('nama_bank', 'id'),
            'title' => 'Form Edit Data Rekening',
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
    public function update(UpdateBankSekolahRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);
        // Dapatkan bank berdasarkan bank_id yang dipilih
        $bank = \App\Models\Bank::find($requestData['bank_id']);
        
        // Jika bank ditemukan, set nama_bank
        if ($bank) {
            $requestData['nama_bank'] = $bank->nama_bank;
            $requestData['kode'] = $bank->sandi_bank; // Jika perlu
        }
        $requestData['user_id'] =auth()->user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data rekening sekolah berhasil diubah');
        return redirect()->route('banksekolah.index');
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
        flash('Rekening Sekolah berhasil dihapus')->error();
        return back();
    }
}