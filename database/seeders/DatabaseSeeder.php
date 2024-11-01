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
        $this->call(PosyanduSeeder::class);
        $this->call(UserSeeder::class);
        $this->call(DusunSeeder::class);
        $this->call(RtSeeder::class);
        $this->call(OrangtuaSeeder::class);
        $this->call(BalitaSeeder::class);
    }
}
