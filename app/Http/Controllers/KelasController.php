<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\Kelas as Model;

class KelasController extends Controller
{
    private $viewIndex = 'k_index';
    private $viewCreate = 'k_form';
    private $viewEdit = 'k_form';
    private $viewShow = 'k_show';
    private $routePrefix = 'kelas';

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q')){
            $models = Model::search($request->q)->orderBy('kelas', 'asc')->paginate(50);
        }else{
            $models = Model::orderBy('kelas', 'asc')->paginate(50);
        }
        return view('admin.' .$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Daftar Kelas'
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
            'title' => 'Form Tambah Kelas',
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
            'kelas' => 'required|unique:kelas,kelas',
        ]);
        Model::create($requestData);
        flash('Kelas berhasil ditambahkan dan disimpan')->success();
        return redirect()->route('kelas.index');
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
            'title' => 'Form Edit Kelas',
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
            'kelas' => 'required',
        ]);
        $model = Model::findOrFail($id);
        $model->fill($requestData);
        $model->save();
        flash('Kelas berhasil diubah');
        return redirect()->route('kelas.index');
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
        flash('Kelas berhasil dihapus')->error();
        return back();
    }
}