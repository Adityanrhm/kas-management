<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class MasterGuruController extends Controller
{
    public function index()
    {
        return view('master.guru');
    }
}
