<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class WaliMuridInvoiceController extends Controller
{
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $tagihan = Tagihan::findOrFail($id);
        $title = 'Cetak Inovice Tagihan SSO';
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('wali_siswa.invoice', compact('tagihan', 'title'));
            $namaFile = "Invoice Tagihan " .$tagihan->siswa->nama . '.pdf';
            return $pdf->download($namaFile);
        }
        return view('wali_siswa.invoice', compact('tagihan', 'title'));
    }

    
}