<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\Orangtua;
use App\Models\BalitaUkur;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use App\Models\StandarPertumbuhanAnakExpanded;

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
                $newBalita = Balita::create([
                    'name' => $faker->firstName . ' ' . $faker->firstName . ' ' . $faker->lastName, // Nama balita minimal 3 kata
                    'nik' => $faker->numerify('180706##########'),
                    'tgl_lahir' => $faker->dateTimeBetween('-5 years', 'now')->format('Y-m-d'),
                    'gender' => $faker->randomElement(['P', 'L']),
                    'bpjs' => $faker->randomElement(['Ada', 'Tidak Ada']),
                    'orangtua_id' => $orangtuaId,
                    'posyandu_id' => $dusunId,
                    'family_order' => $i,
                    'bb_lahir' => $faker->randomFloat(1, 2.5, 4.5), // Berat badan lahir antara 2.5kg - 4.5kg
                    'tb_lahir' => $faker->numberBetween(46, 55), // Tinggi badan lahir antara 45cm - 55cm
                    'created_by' => 1,
                    'updated_by' => null,
                    'created_at' => Carbon::now(),
                    'updated_at' => null,
                ]);

                // HITUNG Z-SCORE BAYI BARU LAHIR

                // Ambil Parameter Balita

                $umurHari = 0;
                $umur_ukur = '0 Bulan';
                $cara_ukur = 'Berbaring';
                $gender = $newBalita->gender;
                $beratBadan = $newBalita->bb_lahir;
                $tinggiBadan = $newBalita->tb_lahir;
                $IMT = $this->hitungIMT($beratBadan, $tinggiBadan);

                // Ambil NILAI LMS
                $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $gender);
                $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $gender);
                $bbtbLMS = $this->ambilLmsExpanded('BB_PB', $tinggiBadan, $gender);
                $imtLMS = $this->ambilLmsExpanded('IMT_U', $umurHari, $gender);

                // HITUNG ZSCORE SETIAP KATEGORI
                $zScoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
                $zScoreTB_U = $this->hitungZScore($tinggiBadan, $tbUmurLMS->L, $tbUmurLMS->M, $tbUmurLMS->S);
                $zScoreBB_TB = $this->hitungZScore($beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
                $zScoreIMT_U = $this->hitungZScore($IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);

                // STATUS GIZI BB/U
                if ($zScoreBB_U < -3) {
                    $statusGiziBB_U = "Berat badan sangat kurang";
                } elseif ($zScoreBB_U > -3 && $zScoreBB_U < -2) {
                    $statusGiziBB_U = "Berat badan kurang";
                } elseif ($zScoreBB_U > -2 && $zScoreBB_U < 1) {
                    $statusGiziBB_U = "Berat badan normal";
                } elseif ($zScoreBB_U > 1) {
                    $statusGiziBB_U = "Resiko berat badan lebih";
                }

                // STATUS GIZI PB/U atau TB/U
                if ($zScoreTB_U < -3) {
                    $statusGiziTB_U = "Sangat pendek";
                } elseif ($zScoreTB_U > -3 && $zScoreTB_U < -2) {
                    $statusGiziTB_U = "Pendek";
                } elseif ($zScoreTB_U > -2 && $zScoreTB_U < 3) {
                    $statusGiziTB_U = "Normal";
                } elseif ($zScoreTB_U > 3) {
                    $statusGiziTB_U = "Tinggi";
                }

                // STATUS GIZI (BB/PB atau BB/TB)
                if ($zScoreBB_TB < -3) {
                    $statusGiziBB_TB = "Gizi buruk";
                } elseif ($zScoreBB_TB > -3 && $zScoreBB_TB < -2) {
                    $statusGiziBB_TB = "Gizi kurang";
                } elseif ($zScoreBB_TB > -2 && $zScoreBB_TB < 1) {
                    $statusGiziBB_TB = "Gizi baik";
                } elseif ($zScoreBB_TB > 1 && $zScoreBB_TB < 2) {
                    $statusGiziBB_TB = "Beresiko gizi lebih";
                } elseif ($zScoreBB_TB > 2 && $zScoreBB_TB < 3) {
                    $statusGiziBB_TB = "Gizi lebih";
                } elseif ($zScoreBB_TB > 3) {
                    $statusGiziBB_TB = "Obesitas";
                }

                // STATUS GIZI IMT/U
                if ($zScoreIMT_U < -3) {
                    $statusGiziIMT_U = "Gizi buruk";
                } elseif ($zScoreIMT_U > -3 && $zScoreIMT_U < -2) {
                    $statusGiziIMT_U = "Gizi kurang";
                } elseif ($zScoreIMT_U > -2 && $zScoreIMT_U < 1) {
                    $statusGiziIMT_U = "Gizi baik";
                } elseif ($zScoreIMT_U > 1 && $zScoreIMT_U < 2) {
                    $statusGiziIMT_U = "Beresiko gizi lebih";
                } elseif ($zScoreIMT_U > 2 && $zScoreIMT_U < 3) {
                    $statusGiziIMT_U = "Gizi lebih";
                } elseif ($zScoreIMT_U > 3) {
                    $statusGiziIMT_U = "Obesitas";
                }

                $zscore = BalitaUkur::create([
                    "balita_id" => $newBalita->id,
                    "tgl_ukur" => $newBalita->tgl_lahir,
                    "umur_ukur" => $umur_ukur,
                    "bb" => $newBalita->bb_lahir,
                    "tb" => $newBalita->tb_lahir,
                    "cara_ukur" => $cara_ukur,
                    "status_bb_u" => $statusGiziBB_U,
                    "zscore_bb_u" => round($zScoreBB_U, 2),
                    "status_tb_u" => $statusGiziTB_U,
                    "zscore_tb_u" => round($zScoreTB_U, 2),
                    "status_bb_tb" => $statusGiziBB_TB,
                    "zscore_bb_tb" => round($zScoreBB_TB, 2),
                    "status_imt_u" => $statusGiziIMT_U,
                    "zscore_imt_u" => round($zScoreIMT_U, 2),
                    "created_by" => 1,

                ]);
            }
        }
    }

    // HELPER

    // Fungsi Hitung IMT
    private function hitungIMT($beratBadan, $tinggiBadan)
    {
        $tinggiMeter = $tinggiBadan / 100;
        return $beratBadan / ($tinggiMeter * $tinggiMeter);
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    // EXPANDED
    private function ambilLmsExpanded($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnakExpanded::where('kategori', $kategori)
            ->where('umur_atau_tinggi', $umurAtautinggi)
            ->where('gender', $gender)
            ->first(['L', 'M', 'S']);
    }

    // FUNGSI RUMUS HITUNG ZSCORE
    private function hitungZScore($X, $L, $M, $S)
    {
        return (($X / $M) ** $L - 1) / ($L * $S);
    }
}
