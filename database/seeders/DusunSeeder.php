<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DusunSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('dusun')->insert([
            ['name' => 'Sumber Mulyo', 'rw' => '001', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sidodadi', 'rw' => '002', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sukorejo', 'rw' => '003', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sumber Rahayu', 'rw' => '004', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Sidorejo', 'rw' => '005', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Suko Makmur', 'rw' => '006', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
