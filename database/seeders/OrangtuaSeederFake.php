<?php

namespace Database\Seeders;

use App\Models\Orangtua;
use Illuminate\Database\Seeder;
use Faker\Factory as Faker;

class OrangtuaSeederFake extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create('id_ID');
        $dusunRtMap = [
            1 => [1, 2, 3],
            2 => [4, 5],
            3 => [6, 7],
            4 => [8, 9],
            5 => [10, 11],
            6 => [12, 13],
        ];

        $dusunAddresses = [
            1 => ['Dusun Sumber Mulyo'],
            2 => ['Dusun Sidodadi'],
            3 => ['Dusun Sukorejo'],
            4 => ['Dusun Sumber Rahayu'],
            5 => ['Dusun Sidorejo'],
            6 => ['Dusun Suko Makmur'],
        ];

        for ($i = 1; $i <= 60; $i++) { // Membuat 60 data orang tua
            $dusunId = $faker->numberBetween(1, 6);
            $rtId = $faker->randomElement($dusunRtMap[$dusunId]);

            Orangtua::create([
                'no_kk' => $faker->numerify('180706##########'),
                'nik_ibu' => $faker->numerify('180706##########'),
                'name_ibu' => $faker->name('female'),
                'nik_ayah' => $faker->numerify('180706##########'),
                'name_ayah' => $faker->name('male'),
                'telp' => $faker->numerify('08###########'),
                'alamat' => $faker->randomElement($dusunAddresses[$dusunId]),
                'rt_id' => $rtId,
                'dusun_id' => $dusunId,
                'desa' => 'Selorejo',
                'kecamatan' => 'Batanghari',
                'kabupaten' => 'Lampung Timur',
                'provinsi' => 'Lampung',
                'created_by' => 1,
                'updated_by' => null,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
