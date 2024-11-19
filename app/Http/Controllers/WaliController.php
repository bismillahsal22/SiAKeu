<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User as Model;

class WaliController extends Controller
{
    private $viewIndex = 'w_index';
    private $viewCreate = 'u_form';
    private $viewEdit = 'u_form';
    private $viewShow = 'w_show';
    private $routePrefix = 'wali';

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

        if($request->filled('q')){
            $models = Model::search($request->q)->paginate(50);
        }else{
            $models = Model::wali()
            ->latest()
            ->paginate(50);
        }

        return view('admin.' .$this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Daftar Wali Siswa'
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
            'title' => 'Form Tambah Wali Siswa',
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
            'name' => 'required',
            'email' => 'required|unique:users',
            'nohp' => 'required|unique:users',
            'password' => 'required|min:8'
        ]);

        if (!str_ends_with($requestData['email'], '@gmail.com')) {
            return back()->withErrors(['email' => 'Email harus memiliki ekstensi @gmail.com'])->withInput();
        }
        
        $requestData['password'] = bcrypt($requestData['password']);
        $requestData['email_verified_at'] = now();
        $requestData['akses'] = 'wali';
        Model::create($requestData);
        flash('Wali Siswa berhasil ditambahkan dan disimpan')->success();
        return redirect()->route('wali.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('admin.' .$this->viewShow, [
            'siswa' => \App\Models\Siswa::orderBy('nama')->pluck('nama', 'id'),
            'models' => Model::with('siswa')->wali()->where('id', $id)->firstOrFail(),
            'title' => 'Detail Wali Siswa'
        ]);
        // doesntHave('wali')->
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
            'title' => 'Form Edit Data Wali Siswa',
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
            'name' => 'required',
            'email' => 'required|unique:users,email,' .$id,
            'nohp' => 'required|unique:users,nohp,' .$id,
            'password' => 'nullable|min:8'
        ]);

        if (!str_ends_with($requestData['email'], '@gmail.com')) {
            return back()->withErrors(['email' => 'Email harus memiliki ekstensi @gmail.com'])->withInput();
        }

        $model = Model::findOrFail($id);
        if($requestData['password'] == ""){
            unset($requestData['password']);
        }else{
            $requestData['password'] = bcrypt($requestData['password']);
        }
        $model->fill($requestData);
        $model->save();
        flash('Data Wali Siswa berhasil diubah');
        return redirect()->route('wali.index');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::where('akses', 'wali')->findOrFail($id);
        $model->delete();
        flash('Wali Siswa berhasil dihapus')->error();
        return back();
    }
}