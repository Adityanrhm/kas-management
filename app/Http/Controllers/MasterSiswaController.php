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
            $users = User::select('users.*')->join('students', 'students.user_id', '=', 'users.id')->where(function ($query) use ($keyword) {
                $query->where('users.email', 'ILIKE', "%$keyword%")
                    ->orWhere('students.nis', 'LIKE', "%$keyword%")
                    ->orWhere('users.username', 'LIKE', "%$keyword%");
            })->with('student')->orderBy('students.nis')->paginate(8);

            return response()->json($users);
        }

        // Nis siswa algorithm
        $all_nis = Student::orderBy('nis', 'ASC')->pluck('nis')->toArray();

        $next_nis = null;
        $start_nis = 11901;

        foreach ($all_nis as $nis) {
            if ($start_nis != $nis) {
                $next_nis = $start_nis;
                break;
            }
            $start_nis++;
        }
        $nis_siswa = $next_nis ?? ($all_nis ? max($all_nis) + 1 : 11901);

        // users_siswa data
        $users_data = User::select('users.*')->join('students', 'students.user_id', '=', 'users.id')->orderBy('students.nis', 'ASC')->with('student')->paginate(8);

        return view('modules.master.siswa', ['users_data' => $users_data, 'nis_siswa' => $nis_siswa]);
    }


    public function store_siswa(Request $request): RedirectResponse
    {

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:users,email'],
            'password' => ['required', 'confirmed', Password::defaults()],
            'photo' => ['required'],
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

            $user_student->assignRole('siswa');

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
        // dd(User::findOrfail($user_id));
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email', 'unique:users,email,' . $siswa_user_id],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        try {
            $user_student = User::findOrfail($siswa_user_id);

            $path_photo = null;
            if ($request->hasFile('photo')) {
                Storage::disk('public')->delete($user_student->avatar);

                $filename = time() . '_' . $request->file('photo')->getClientOriginalName();

                $path_photo = Storage::disk('public')->putFileAs('assets/images', $request->file('photo'), $filename);
            };

            $user_student->update([
                'username' => $request->name,
                'email' => $request->email,
                'avatar' => $path_photo ? $path_photo : $user_student->avatar,
            ]);

            $student = Student::where('user_id', $siswa_user_id)->first();

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


    public function destroy_siswa($siswa_user_id)
    {
        $user_student = User::findOrfail($siswa_user_id);
        if ($user_student->avatar && Storage::disk('public')->exists($user_student->avatar)) {
            Storage::disk('public')->delete($user_student->avatar);
        }

        $user_student->delete();

        return redirect(route('master.siswa'));
    }
}
