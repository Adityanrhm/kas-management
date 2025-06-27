<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;

class MasterSiswaController extends Controller
{
    public function index()
    {
        $users_data = User::with('student', 'role')->get();
        return view('modules.master.siswa', ['users_data' => $users_data]);
    }
}
