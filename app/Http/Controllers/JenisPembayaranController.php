<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreJenis_PembayaranRequest;
use App\Http\Requests\UpdateJenis_PembayaranRequest;
use App\Models\User;
use Illuminate\Http\Request;
use \App\Models\Jenis_Pembayaran as Model;

class JenisPembayaranController extends Controller
{
    private $viewIndex = 'jp_index';
    private $viewCreate = 'jp_form';
    private $viewEdit = 'jp_form';
    private $viewShow = 'jp_show';
    private $routePrefix = 'jp';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        // $models = Model::where('akses', '<>', 'wali')->latest()->paginate(50);
        // $data['models'] = $models;
        // return view('operator.u_index', $data);

        if($request->filled('q')){
            $models = Model::with('user')->whereNull('parent_id')->search($request->q)->paginate(50);
        }else{
            $models = Model::with('user')->whereNull('parent_id')->latest()
            ->paginate(50);
        }

        return view('operator.' .$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Jenis Pembayaran'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $jp = new Model();
        if ($request->filled('parent_id')) {
            $jp = Model::with('children')->findOrFail($request->parent_id);
        }
        $data = [
            'parentData' => $jp,
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix. '.store',
            'button' => 'Simpan', 
            'title' => 'Form Tambah Jenis Pembayaran',
        ];
        return view('operator.' .$this->viewCreate, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreJenis_PembayaranRequest $request)
    {
        $requestData = $request->validated();
        $requestData['user_id'] =auth()->user()->id;
        Model::create($requestData);
        flash('Data Berhasil Ditambah')->success();
        return redirect()->route('jp.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operator.' .$this->viewShow, [
            'model' => Model::findOrFail($id),
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
            'route' => [$this->routePrefix .'.update', $id],
            'button' => 'Update',
            'title' => 'Form Edit Jenis Pembayaran',
        ];
        return view('operator.' .$this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateJenis_PembayaranRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);
        $requestData['user_id'] =auth()->user()->id;
        $model->fill($requestData);
        $model->save();
        flash('Data Berhasil Diubah');
        return redirect()->route('jp.index');
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
        if ($model->children->count() >= 1) {
            flash('Data masih memiliki item jenis pembayaran yang lain. Hapus item terlebih dahulu')->error();
            return back();
        }
        $model->delete();
        flash('Data Berhasil Dihapus')->error();
        return back();
    }

    public function deleteItem($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        flash('Data Berhasil Dihapus')->error();
        return back();
    }
}