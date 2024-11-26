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
     * @param  \App\Http\Requests\StoreTagihanOperatorRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanOperatorRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\TagihanOperator  $tagihanOperator
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\TagihanOperator  $tagihanOperator
     * @return \Illuminate\Http\Response
     */
    public function edit(TagihanOperator $tagihanOperator)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTagihanOperatorRequest  $request
     * @param  \App\Models\TagihanOperator  $tagihanOperator
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTagihanOperatorRequest $request, TagihanOperator $tagihanOperator)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\TagihanOperator  $tagihanOperator
     * @return \Illuminate\Http\Response
     */
    public function destroy(TagihanOperator $tagihanOperator)
    {
        //
    }
}
