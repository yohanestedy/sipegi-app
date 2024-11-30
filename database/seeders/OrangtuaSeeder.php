<?php

namespace Database\Seeders;

use App\Models\Orangtua;
use Illuminate\Database\Seeder;

class OrangtuaSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Orangtua::create([

            'name' => 'Maria Frety Arwindhi',
            'no_kk' => '3173061208220037',
            'nik' => '1807065105930006',
            'bpjs' => 'Punya',
            'telp' => '082261586891',
            'alamat' => 'Dusun Suko Makmur',
            'rt_id' => 13,
            'dusun_id' => 6,
            'desa' => 'Selorejo',
            'kecamatan' => 'Batanghari',
            'kabupaten' => 'Lampung Timur',
            'provinsi' => 'Lampung',
            'created_by' => 1,
            'updated_by' => null,
            'created_at' => now(),
            'updated_at' => now(),

            // Anda dapat menambahkan lebih banyak data di sini
        ]);
    }
}
