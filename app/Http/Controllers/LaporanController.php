<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LaporanController extends Controller
{
    public function pembelian()
    {
        return view('laporan/pembelian');
    }

    public function permintaan()
    {
        return view('laporan/permintaan');
    }
}
