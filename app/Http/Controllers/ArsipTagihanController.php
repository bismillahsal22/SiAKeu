<?php

namespace App\Http\Controllers;

use App\Models\ArsipTagihan;
use App\Models\Tahun_Ajaran;
use Illuminate\Http\Request;

class ArsipTagihanController extends Controller
{
    private $viewIndex = 'arsip_index';
    private $viewCreate = '';
    private $viewEdit = '';
    private $viewShow = '';
    private $routePrefix = 'arsiptag';
    
    public function index(Request $request)
    {
        $tahunAjaran = Tahun_Ajaran::where('status', 'tidak aktif')->pluck('tahun_ajaran', 'id');
        $selectedTahunAjaran = $request->input('tahun_ajaran_id');

        if ($selectedTahunAjaran) {
            $models = ArsipTagihan::where('tahun_ajaran_id', $selectedTahunAjaran)->get();
        } else {
            $models = ArsipTagihan::all();
        }

        return view('admin.' . $this->viewIndex, [
            'title' => 'Arsip Tagihan Siswa',
            'routePrefix' => $this->routePrefix,
            'tahunAjaran' => $tahunAjaran,
            'models' => $models,
            'selectedTahunAjaran' => $selectedTahunAjaran,
        ]);
    }
}