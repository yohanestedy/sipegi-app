<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PosyanduSeeder extends Seeder
{
    public function run()
    {
        DB::table('posyandu')->insert([
            [
                'name' => 'Melati',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'name' => 'Nusa Indah',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'name' => 'Kenanga',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'name' => 'Mawar',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'name' => 'Dahlia',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
            [
                'name' => 'Anggrek',
                'created_at' => now(),
                'updated_at' => now(),
                'created_by' => 1,
                'updated_by' => null,
            ],
        ]);
    }
}
