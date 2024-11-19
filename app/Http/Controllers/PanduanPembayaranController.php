<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PanduanPembayaranController extends Controller
{
    public function index($via)
    {
        if ($via == 'atm') {
            return view('panduan_atm');
        }

        if ($via == 'mbanking') {
           return view('panduan_mbanking');
        }
    }
}