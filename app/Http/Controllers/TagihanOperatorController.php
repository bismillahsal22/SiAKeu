<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use App\Models\TagihanOperator;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StoreTagihanOperatorRequest;
use App\Http\Requests\UpdateTagihanOperatorRequest;
use App\Models\Siswa;
use App\Models\Tahun_Ajaran;
use Log;

class TagihanOperatorController extends Controller
{
    private $viewIndex = 'tag_index';
    private $viewCreate = 'tag_form';
    private $viewEdit = 'tag_form';
    private $viewShow = 'tag_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        //mengambil data Tagihan berd. tahun ajaran tertentu
        $tahunAjaranId = Auth::user()->tahun_ajaran_id;

        // Menampilkan nilai $tahunAjaranId ke log
        Log::info('Tahun Ajaran ID: ' . $tahunAjaranId);

        $tagihan = Tagihan::where('tahun_ajaran_id', $tahunAjaranId)
            ->with('tahun_ajaran')
            ->paginate(50);

        return view('operator.' . $this->viewIndex, [
            'tagihan' => $tagihan,
            'title' => 'Daftar Tagihan Siswa',
            'routePrefix' => $this->routePrefix,
        ]);
    }
}