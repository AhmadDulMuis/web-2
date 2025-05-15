<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Peminjaman;

class PeminjamanController extends Controller
{
    public function index()

    {
        $peminjamans = Peminjaman::all();
        return view('peminjaman.index', compact('peminjamans'));
    }
}
