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

        // Image default path to store
        $image_default_gw = Storage::disk('public')->exists('assets/images/gw.png') ? 'assets/images/gw.png' : null;
        $image_default_logo = Storage::disk('public')->exists('assets/images/mcr-logoo.png') ? 'assets/images/mcr-logoo.png' : null;

        DB::table('roles')->insert([
            [
                'name' => 'admin',
            ],
            [
                'name' => 'bendahara',
            ],
            [
                'name' => 'siswa',
            ],
        ]);

        // Get the id of the role by name
        $roles_id_admin = DB::table('roles')->where('name', 'admin')->value('id');
        $roles_id_bendahara = DB::table('roles')->where('name', 'bendahara')->value('id');


        DB::table('users')->insert([
            [
                'username' => 'admin',
                'email' => 'iklinur4170@gmail.com',
                'password' => Hash::make('password'),
                'avatar' => $image_default_gw,
                'roles_id' => $roles_id_admin,
                'created_at' => now(),
            ],
            [
                'username' => 'bendahara',
                'email' => 'adtynrhm@gmail.com',
                'password' => Hash::make('password'),
                'avatar' => $image_default_logo,
                'roles_id' => $roles_id_bendahara,
                'created_at' => now(),
            ],
        ]);
    }
}
