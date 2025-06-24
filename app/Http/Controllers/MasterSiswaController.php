<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterSiswaController extends Controller
{
    public function index()
    {
        return view('master.siswa');
    }
}
