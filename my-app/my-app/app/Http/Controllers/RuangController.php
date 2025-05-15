<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ruang;

class RuangController extends Controller
{
    public function index()

    {
        $ruangs = Ruang::all();
        return view('ruang.index', compact('ruangs'));
    }
}
