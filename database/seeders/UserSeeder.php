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
                'id' => 1,
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
            [
                'id' => 2,
                'name' => 'Admin RDS',
                'username' => 'adminrds',
                'password' => Hash::make('adminrds'), // Hashing password
                'role' => 'admin',
                'posyandu_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 0, // menggunakan ID 0 jika tidak ada pengguna yang ada
                'updated_by' => null,
            ],
            [
                'id' => 3,
                'name' => 'Kader Melati',
                'username' => 'melati',
                'password' => Hash::make('melati'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 4,
                'name' => 'Kader Nusa Indah',
                'username' => 'nusaindah',
                'password' => Hash::make('nusaindah'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 5,
                'name' => 'Kader Kenanga',
                'username' => 'kenanga',
                'password' => Hash::make('kenanga'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 6,
                'name' => 'Kader Mawar',
                'username' => 'mawar',
                'password' => Hash::make('mawar'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 7,
                'name' => 'Kader Dahlia',
                'username' => 'dahlia',
                'password' => Hash::make('dahlia'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 5,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 8,
                'name' => 'Kader Anggrek',
                'username' => 'anggrek',
                'password' => Hash::make('anggrek'), // Hashing password
                'role' => 'kader_posyandu',
                'posyandu_id' => 6,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'id' => 99,
                'name' => 'Kader Poskesdes',
                'username' => 'poskesdes',
                'password' => Hash::make('poskesdes'), // Hashing password
                'role' => 'kader_poskesdes',
                'posyandu_id' => null,
                'created_at' => now(),
                'updated_at' => now(),
                'deleted_at' => null,
                'created_by' => 1,
                'updated_by' => null,
            ],

        ]);
    }
}
