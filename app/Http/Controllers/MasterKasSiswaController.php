<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterKasSiswaController extends Controller
{
    public function index()
    {
        return view('modules.kas.kas_siswa_view');
    }
}
