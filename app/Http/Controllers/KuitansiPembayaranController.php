<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KuitansiPembayaranController extends Controller
{
    public function show($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        $data['pembayaran'] = $pembayaran;
        $data['title'] = 'Kuitansi Pembayaran';
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('admin.kuitansi_pembayaran', $data);
            $namaFile = "Kuitansi Pembayaran " .$pembayaran->tagihan->siswa->nama . '.pdf';
            return $pdf->download($namaFile);
        }
        return view('admin.kuitansi_pembayaran', $data);
    }
}