<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Pegawai;

class PegawaiController extends Controller
{
    public function index()

    {
        $pegawais = Pegawai::all();
        return view('pegawai.index', compact('pegawais'));
    }
}
