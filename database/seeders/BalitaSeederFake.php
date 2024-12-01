<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Balita;
use App\Models\Orangtua;
use Faker\Factory as Faker;

class BalitaSeederFake extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $faker = Faker::create('id_ID');
        $orangtuaIds = Orangtua::pluck('id')->toArray();

        foreach ($orangtuaIds as $orangtuaId) {
            $dusunId = Orangtua::find($orangtuaId)->dusun_id;

            $childrenCount = $faker->numberBetween(1, 2); // Setiap orang tua punya 1-2 anak
            for ($i = 1; $i <= $childrenCount; $i++) {
                Balita::create([
                    'name' => $faker->firstName . ' ' . $faker->firstName . ' ' . $faker->lastName, // Nama balita minimal 3 kata
                    'nik' => $faker->numerify('180706##########'),
                    'tgl_lahir' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                    'gender' => $faker->randomElement(['P', 'L']),
                    'orangtua_id' => $orangtuaId,
                    'posyandu_id' => $dusunId,
                    'family_order' => $i,
                    'bb_lahir' => $faker->randomFloat(1, 2.5, 4.5), // Berat badan lahir antara 2.5kg - 4.5kg
                    'tb_lahir' => $faker->numberBetween(45, 55), // Tinggi badan lahir antara 45cm - 55cm
                    'created_by' => 1,
                    'updated_by' => null,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
