<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RtSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rt')->insert([
            ['dusun_id' => 1, 'rt' => '001', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 1, 'rt' => '002', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 1, 'rt' => '003', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 2, 'rt' => '004', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 2, 'rt' => '005', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 3, 'rt' => '006', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 3, 'rt' => '007', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 4, 'rt' => '008', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 4, 'rt' => '009', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 5, 'rt' => '010', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 5, 'rt' => '011', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 6, 'rt' => '012', 'created_at' => now(), 'updated_at' => now()],
            ['dusun_id' => 6, 'rt' => '013', 'created_at' => now(), 'updated_at' => now()],
        ]);
    }
}
