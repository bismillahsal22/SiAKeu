<?php

namespace App\Http\Controllers;

use App\Models\Kelas;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class LaporanFormController extends Controller
{
    public function create()
    {
        $data = [
            'title' => 'Form Laporan',
            'kelas' => Kelas::pluck('kelas', 'kelas'),
            'tahun_ajaran' => Tahun_Ajaran::pluck('tahun_ajaran', 'id'),
        ];
        return view('admin.laporan_index', $data);
    }
}