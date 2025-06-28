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
        $users_data = User::with('student', 'role')->orderby('id', 'ASC')->get();
        $nis_siswa = Student::max('nis') + 1;

        return view('modules.master.siswa', ['users_data' => $users_data, 'nis_siswa' => $nis_siswa]);
    }

    public function store_siswa(Request $request): RedirectResponse
    {

        dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'photo' => ['required'],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();

            $path_photo = $request->file('photo')->storeAs('assets/images', $filename, 'public');
        };

        $user_student = User::create([
            'username' => $request->name,
            'email' => $request->email,
            'avatar' => $path_photo,
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

        return redirect(route('master.siswa'));
    }

    public function update_siswa(Request $request, $id_siswa): RedirectResponse
    {
        // dd($request->all());
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email'],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        $user_student = User::findOrfail($id_siswa);

        $path_photo = null;
        if ($request->hasFile('photo')) {
            $filename = time() . '_' . $request->file('photo')->getClientOriginalName();

            $path_photo = $request->file('photo')->storeAs('assets/images', $filename, 'public');
        };

        $user_student->update([
            'username' => $request->name,
            'email' => $request->email,
            'avatar' => $path_photo ? $path_photo : $user_student->avatar,
        ]);

        $student = Student::where('user_id', $id_siswa)->first();

        $student->update([
            'users_id' => $id_siswa,
            'nis' => $request->nis,
            'name' => $request->name,
            'class' => $request->class,
        ]);

        return redirect(route('master.siswa'));
    }


    public function destroy_siswa($id_siswa)
    {
        $student_user = User::findOrfail($id_siswa);

        $student_user->delete();

        return redirect(route('master.siswa'));
    }
}
