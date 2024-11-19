<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function create()
    {
        return view('admin.setting_form');
    }

    public function store(Request $request)
    {
        $dataSettings = $request->except('_token');
        settings()->set($dataSettings);
        flash('Data berhasil disimpan')->success();
        return back();
    }
}