<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run()
    {
        DB::table('users')->insert([
            [
                'name' => 'Super Admin',
                'username' => 'superadmin',
                'password' => Hash::make('superadmin'), // Hashing password
                'role' => 'super_admin',
                'posyandu_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 0, // menggunakan ID 0 jika tidak ada pengguna yang ada
                'updated_by' => null,
            ],
        ]);
    }
}
