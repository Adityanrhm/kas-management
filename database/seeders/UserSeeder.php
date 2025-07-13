<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

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

        // Create roles
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


        // Create users

        $userAdmin = User::create([
            'username' => 'Admin',
            'email' => 'adminrpl1@gmail.com',
            'password' => Hash::make('password'),
            'avatar' => $image_person,
            'created_at' => now(),
        ]);

        $userBendahara = User::create([
            'username' => 'Bendahara',
            'email' => 'bendahararpl1@gmail.com',
            'password' => Hash::make('password'),
            'avatar' => $image_default,
            'created_at' => now(),
        ]);

        // Create students data
        DB::table('students')->insert([
            [
                'user_id' => $userAdmin->id,
                'nis' => 11901,
                'class' => 'XI RPL 1',
            ],
            [
                'user_id' => $userBendahara->id,
                'nis' => 11902,
                'class' => 'XI RPL 1',
            ]
        ]);

        // Assign roles to users using Spatie method
        $userAdmin->assignRole('admin');
        $userBendahara->assignRole('bendahara');
    }
}
