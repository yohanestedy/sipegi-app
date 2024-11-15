<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        ini_set('memory_limit', '512M');

        $this->call(PosyanduSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DusunSeeder::class);
        $this->call(RtSeeder::class);
        $this->call(OrangtuaSeeder::class);
        $this->call(BalitaSeeder::class);
        $this->call(StandarPertumbuhanAnak::class);
        $this->call(StandarPertumbuhanAnakExpanded::class);
    }
}
