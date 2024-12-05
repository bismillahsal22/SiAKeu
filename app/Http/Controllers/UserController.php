<?php

namespace App\Http\Controllers;

use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use \App\Models\User as Model;

class UserController extends Controller
{
    private $viewIndex = 'u_index';
    private $viewCreate = 'u_form';
    private $viewEdit = 'u_form';
    private $viewShow = 'u_show';
    private $routePrefix = 'user';

    // public function register()
    // {
    //     $data['title'] = 'Daftar Akun';
    //     return view('user/daftar_akun', $data);
    // }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if($request->filled('q')){
            $models = Model::search($request->q)->paginate(50);
        }else{
            $models = Model::where('akses', '<>', 'wali')
            ->latest()
            ->paginate(50);
        }
        
        return view('admin.' .$this->viewIndex, [
            'models' =>  $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Daftar Pengguna'
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
            'title' => 'Form Tambah Pengguna',
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
            'akses' => 'required|in:admin,operator,wali',
            'password' => 'required|min:8',
        ]);
        if (!str_ends_with($requestData['email'], '@gmail.com')) {
            return back()->withErrors(['email' => 'Email harus memiliki ekstensi @gmail.com'])->withInput();
        }
        
        $requestData['password'] = bcrypt($requestData['password']);
        Model::create($requestData);
        flash('Pengguna berhasil ditambahkan')->success();
        return redirect()->route('user.index');
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
            'title' => 'Form Edit Data Pengguna',
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
            'akses' => 'nullable|in:admin,operator,wali',
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
        flash('Data pengguna berhasil diubah');
        return redirect()->route('user.index');
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
        if($model->id == 1){
            flash('Data tidak dapat dihapus')->error();
            return back();
        }
        $model->delete();
        flash('Data pengguna berhasil dihapus')->error();
        return back();
    }
}