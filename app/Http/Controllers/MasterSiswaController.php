<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;

class MasterSiswaController extends Controller
{
    public function index()
    {
        $users_data = User::with('student', 'role')->get();
        $nis_siswa = Student::max('nis') + 1;

        return view('modules.master.siswa', ['users_data' => $users_data, 'nis_siswa' => $nis_siswa]);
    }

    public function store_siswa(Request $request): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        $user_student = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'avatar' => 'assets/images/gw.png',
            'password' => Hash::make($request->password),
            'role_id' => Role::where('name', 'siswa')->value('id'),
            'created_at' => now()
        ]);

        Student::create([
            'user_id' => $user_student->id,
            'nis' => $request->nis,
            'name' => $request->name,
            'class' => $request->class,
        ]);

        return redirect()->route('master.siswa');
    }
}
