<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $data['tagihan'] = Tagihan::WaliSiswa()->get();
        $data['title'] = 'Rincian Tagihan Siswa';
        return view('wali_siswa.tag_index', $data);
    }

    public function show($id)
    {
        auth()->user()->unreadNotifications->markAsRead();
        $tagihan = Tagihan::WaliSiswa()->findOrFail($id);
        $data['bankSekolah'] = BankSekolah::all();
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['title'] = 'Detail Tagihan Siswa';
        return view('wali_siswa.tag_show', $data);
    }
}