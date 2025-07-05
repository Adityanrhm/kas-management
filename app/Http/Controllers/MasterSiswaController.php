<?php

namespace App\Http\Controllers;

use App\Models\Role;
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
            $users = User::with('student')
                ->where(function ($query) use ($keyword) {
                    $query->where('email', 'Ilike', "%$keyword%")
                        ->orWhereHas('student', function ($q) use ($keyword) {
                            $q->where('nis', 'like', "%$keyword%")
                                ->orWhere('name', 'like', "%$keyword%");
                        });
                })
                ->get();

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
        $users_data = User::with('student')->orderby('id', 'ASC')->get();

        return view('modules.master.siswa', ['users_data' => $users_data, 'nis_siswa' => $nis_siswa]);
    }


    public function store_siswa(Request $request): RedirectResponse
    {

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

            $path_photo = Storage::disk('public')->putFileAs('assets/images', $request->file('photo'), $filename);
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

    public function update_siswa(Request $request, $user_id): RedirectResponse
    {
        // dd(User::findOrfail($user_id));
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'lowercase', 'email'],
            'nis' => ['required'],
            'class' => ['required'],
        ]);

        $user_student = User::findOrfail($user_id);

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

        $student = Student::where('user_id', $user_id)->first();

        $student->update([
            'users_id' => $user_id,
            'nis' => $request->nis,
            'name' => $request->name,
            'class' => $request->class,
        ]);

        return redirect(route('master.siswa'));
    }


    public function destroy_siswa($user_id)
    {
        $user_student = User::findOrfail($user_id);
        if ($user_student->avatar && Storage::disk('public')->exists($user_student->avatar)) {
            Storage::disk('public')->delete($user_student->avatar);
        }

        $user_student->delete();

        return redirect(route('master.siswa'));
    }
}
