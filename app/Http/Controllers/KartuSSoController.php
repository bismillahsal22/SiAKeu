<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;

class KartuSSoController extends Controller
{
    public function index(Request $request)
    {
        $tagihan = Tagihan::where('siswa_id', $request->siswa_id)
            ->whereYear('tgl_tagihan', $request->tahun)
            ->get();
        $siswa = $tagihan->first()->siswa;
        return view('admin.kartusso_index', [
            'tagihan' => $tagihan,
            'siswa' => $siswa
        ]);
    }
}