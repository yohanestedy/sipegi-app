<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Balita;

class BalitaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Balita::create([
            'name' => 'Felicia Janice Sihotang',
            'nik' => '3173064301240005',
            'tgl_lahir' => '2024-01-03',
            'gender' => 'P',
            'orangtua_id' => 1,
            'posyandu_id' => 6,
            'family_order' => 2,
            'bb_lahir' => 2.8,
            'tb_lahir' => 49,
            'created_by' => 1,
            'updated_by' => null,
            'created_at' => now(),
            'updated_at' => now(),
        ]);
    }
}
