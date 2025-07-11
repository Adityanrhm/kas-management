<?php

namespace Database\Seeders;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Illuminate\Validation\Rules\Exists;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Image default path to store (Replace the image path with your own)
        $image_default = Storage::disk('public')->exists('assets/images/gw.png') ? 'assets/images/gw.png' : null;
        $image_person = Storage::disk('public')->exists('assets/images/Osaragi.png') ? 'assets/images/Osaragi.png' : null;

        DB::table('roles')->insert([
            [
                'name' => 'admin',
                'guard_name' => 'web',
            ],
            [
                'name' => 'bendahara',
                'guard_name' => 'web',
            ],
            [
                'name' => 'siswa',
                'guard_name' => 'web',
            ],
        ]);

        // Get the id of the role by name
        $role_id_admin = DB::table('roles')->where('name', 'admin')->value('id');
        $role_id_bendahara = DB::table('roles')->where('name', 'bendahara')->value('id');

        DB::table('users')->insert([
            [
                'username' => 'Bendahara',
                'email' => 'bendahararpl1@gmail.com',
                'password' => Hash::make('password'),
                'avatar' => $image_default,
                'created_at' => now(),
            ],
            [
                'username' => 'Admin',
                'email' => 'adminrpl1@gmail.com',
                'password' => Hash::make('password'),
                'avatar' => $image_person,
                'created_at' => now(),
            ]
        ]);

        // Get id from users just inserted
        $user_admin = DB::table('users')->where('username', 'Admin')->value('id');
        $user_bendahara = DB::table('users')->where('username', 'Bendahara')->value('id');

        DB::table('students')->insert(
            [
                [
                    'user_id' => $user_admin,
                    'name' => 'Admin',
                    'nis' => 11901,
                    'class' => 'XI RPL 1',
                ],
                [
                    'user_id' => $user_bendahara,
                    'name' => 'Bendahara',
                    'nis' => 11902,
                    'class' => 'XI RPL 1',
                ]
            ]
        );
        DB::table('model_has_roles')->insert([
            [
                'role_id' => $role_id_bendahara,
                'model_type' => 'App\Models\User',
                'model_id' => $user_bendahara,
            ],
            [
                'role_id' => $role_id_admin,
                'model_type' => 'App\Models\User',
                'model_id' => $user_admin,
            ]
        ]);
    }
}
