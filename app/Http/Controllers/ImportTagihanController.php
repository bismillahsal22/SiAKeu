<?php

namespace App\Http\Controllers;

use App\Imports\ImportTagihan;
use Excel;
use Illuminate\Http\Request;

class ImportTagihanController extends Controller
{
    /**
     * Handle the incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $request->validate([
            'excel' => 'required|mimes:xlsx,xls,csv'
        ]);
        Excel::import(new ImportTagihan, $request->file('excel')->store('temp'));
        flash('File excel berhasil diupload')->success();
        return back();
    }
}