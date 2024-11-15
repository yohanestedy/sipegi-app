<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;


class StandarPertumbuhanAnakExpanded extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        // Path ke file Excel
        $filePath = storage_path('app/data/StandarPertumbuhanAnakExpandedSeeder.xlsx');

        $sheets = Excel::toArray([], $filePath);

        // Loop melalui setiap sheet
        foreach ($sheets as $sheet) {
            // Loop dan masukkan data ke database, lewati row pertama
            foreach (array_slice($sheet, 1) as $row) {
                DB::table('standar_pertumbuhan_anak_expanded')->insert([
                    'kategori' => $row[0],
                    'gender' => $row[1],
                    'umur_atau_tinggi' => $row[2],
                    'L' => $row[3],
                    'M' => $row[4],
                    'S' => $row[5],
                    'sd4neg' => $row[6],
                    'sd3neg' => $row[7],
                    'sd2neg' => $row[8],
                    'sd1neg' => $row[9],
                    'median' => $row[10],
                    'sd1' => $row[11],
                    'sd2' => $row[12],
                    'sd3' => $row[13],
                    'sd4' => $row[14],
                    'created_at' => Carbon::now(),
                    'updated_at' => Carbon::now(),
                ]);
            }
        }
    }
}
