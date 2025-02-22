<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridSiswaController extends Controller
{
    public function index()
    {
        $data['models'] = Auth::user()->siswa;
        $data['title'] = 'Detail Siswa';
        return view('wali_siswa.s_index', $data);
    }
}