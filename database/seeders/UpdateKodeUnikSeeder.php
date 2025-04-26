<?php

namespace Database\Seeders;

use App\Models\Balita;
use Illuminate\Database\Seeder;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UpdateKodeUnikSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        Balita::all()->each(function ($balita) {
            $kode = 'B' . str_pad($balita->id, 4, '0', STR_PAD_LEFT);
            $balita->update(['kode_unik' => $kode]);
        });
    }
}
