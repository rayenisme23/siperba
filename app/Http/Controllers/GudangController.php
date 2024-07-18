<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class GudangController extends Controller
{
    public function permi()
    {
        return view('manajemen.permintaan.index', compact('departemen', 'users'));
    }
}
