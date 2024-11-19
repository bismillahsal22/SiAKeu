<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class WaliSiswaController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'wali_id' => 'required|exists:users,id',
            'id_siswa' => 'required',
        ]);
        // $wali = \App\Models\User::find($request->wali_id);
        $siswa = \App\Models\Siswa::find($request->id_siswa);
        $siswa->wali_id = $request->wali_id;
        $siswa->status_wali = 'ok';
        $siswa->save();
        flash('Siswa berhasil ditambahkan')->success();
        return back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        $siswa = \App\Models\Siswa::findOrFail($id);
        $siswa->wali_id = null;
        $siswa->status_wali = null;
        $siswa->save();
        flash('Siswa berhasil dihapus dari Wali Siswa')->error();
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}