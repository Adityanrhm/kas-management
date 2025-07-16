<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Student;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class MasterSiswaController extends Controller
{
    public function index(Request $request)
    {
        // Search algorithm
        if ($request->ajax()) {
            $keyword = $request->query('q');

            $users_siswa_data_search = User::select('users.id', 'users.username', 'users.email', 'users.avatar', 'students.nis', 'students.user_id',)->join('students', 'students.user_id', '=', 'users.id')
                ->search($keyword, ['students.nis', 'users.email', 'users.username'])
                ->with(['student', 'roles'])->orderBy('students.nis')->paginate(8);

            return response()->json($users_siswa_data_search);
        }

        // Generate next value NIS
        $nis_siswa = Student::generateNextNis();

        // Users siswa data
        $users_data = User::getUsersSiswaData()->orderBy('students.nis', 'ASC')->with(['student', 'roles'])->paginate(8);

        return view('modules.master.siswa', compact('users_data', 'nis_siswa'));
    }


    public function store_siswa(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'photo' => ['required', 'image', 'mimes:png,jpg,jpeg', 'max:2048'],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        try {

            if ($request->hasFile('photo')) {
                $filename = time() . '_' . $request->file('photo')->getClientOriginalName();

                $path_photo = Storage::disk('public')->putFileAs('assets/images', $request->file('photo'), $filename);
            };

            $user_student = User::create([
                'username' => $request->name,
                'email' => $request->email,
                'avatar' => $path_photo,
                'password' => Hash::make($request->password),
                'created_at' => now()
            ]);

            $user_student->assignRole($request->role);

            Student::create([
                'user_id' => $user_student->id,
                'nis' => $request->nis,
                'class' => $request->class,
            ]);


            return redirect(route('master.siswa'))->with('success', 'Data siswa berhasil ditambahkan!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menambahkan data siswa. Silakan coba lagi.');
        }
    }


    public function update_siswa(Request $request, $siswa_user_id): RedirectResponse
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:users,email,' . $siswa_user_id],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        try {
            $user_student = User::findOrfail($siswa_user_id);
            $student = Student::where('user_id', $siswa_user_id)->first();

            $path_photo = null;

            if ($request->hasFile('photo')) {

                if ($user_student->avatar && Storage::disk('public')->exists($user_student->avatar)) {
                    Storage::disk('public')->delete($user_student->avatar);
                }

                $filename = time() . '_' . $request->file('photo')->getClientOriginalName();

                $path_photo = Storage::disk('public')->putFileAs('assets/images', $request->file('photo'), $filename);
            };

            $user_student->update([
                'username' => $request->name,
                'email' => $request->email,
                'avatar' => $path_photo ? $path_photo : $user_student->avatar,
            ]);

            $user_student->syncRoles($request->role);

            $student->update([
                'users_id' => $siswa_user_id,
                'nis' => $request->nis,
                'class' => $request->class,
            ]);

            return redirect(route('master.siswa'))->with('success', 'Data siswa berhasil diperbarui!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal memperbarui data siswa. Silakan coba lagi.');
        }
    }


    public function destroy_siswa($siswa_user_id): RedirectResponse
    {
        try {

            $user_student = User::findOrfail($siswa_user_id);
            if ($user_student->avatar && Storage::disk('public')->exists($user_student->avatar)) {
                Storage::disk('public')->delete($user_student->avatar);
            }

            $user_student->delete();

            return redirect(route('master.siswa'))->with('success', 'Data siswa berhasil dihapus!');
        } catch (\Exception $e) {
            return redirect()->back()->with('error', 'Gagal menghapus data siswa. Silakan coba lagi.');
        }
    }
}
