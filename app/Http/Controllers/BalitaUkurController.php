<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Monolog\Handler\NullHandler;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\StandarPertumbuhanAnak;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\StandarPertumbuhanAnakExpanded;

class BalitaUkurController extends Controller
{
    //
    public function index($id)
    {

        $user = auth()->user();
        $query = Balita::with(['posyandu', 'balitaUkur']);

        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }

        $query->where('id', $id);


        $balita = $query->first();


        return view('pages.main.balita-ukur.index', compact('balita'));
    }

    // HALAMAN INPUT PENGHITUNGAN
    // public function add($id = null)
    // {
    //     $user = auth()->user();
    //     if ($id) {
    //         if ($user->posyandu_id !== null) {
    //             $balitas = Balita::with('posyandu')->where('posyandu_id', $user->posyandu_id)->where('id', $id)->get();
    //         } else {
    //             $balitas = Balita::with('posyandu')->where('id', $id)->get();
    //         }
    //     } else {
    //         if ($user->posyandu_id !== null) {
    //             $balitas = Balita::with('posyandu')->where('posyandu_id', $user->posyandu_id)->get();
    //         } else {
    //             $balitas = Balita::with('posyandu')->get();
    //         }
    //     }

    //     return view('pages.main.balita-ukur.add', compact('balitas'));
    // }

    public function add($id = null)
    {
        $user = auth()->user();
        $query = Balita::with('posyandu');

        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }

        if ($id) {
            $query->where('id', $id);
        }

        $balitas = $query->get();

        return view('pages.main.balita-ukur.add', compact('balitas'));
    }



    // PENGHITUNGAN ZSCORE / STANDARD DEVIATION SCORE
    public function hitung(Request $request)
    {
        $validator = Validator::make($request->all(), [

            'balita_id' => 'required',
            'tgl_ukur' => [
                'required',
                Rule::unique('balita_ukur', 'tgl_ukur')->where(function ($query) use ($request) {
                    return $query->where('balita_id', $request->balita_id);
                }),
            ],
            'bb' => 'required',
            'tb' => 'required',
            'cara_ukur' => 'required',
        ], [
            'balita_id.required' => 'Pilih balita untuk di ukur',
            'tgl_ukur.required' => 'Pilih tanggal pengukuran',
            'tgl_ukur.unique' => 'Balita sudah di ukur di tanggal ini',
            'bb.required' => 'Isi berat badan balita',
            'tb.required' => 'Isi tinggi badan balita',
            'cara_ukur.required' => 'Pilih metode pengukuran balita',

        ]);

        // if ($validator->fails()) {
        //     return Redirect::back()->withErrors($validator)->withInput();
        // }

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Mengirimkan response error dengan kode status 422
        }


        // Ambil Data Balita
        $balita = Balita::find($request->balita_id);

        // Ambil Umur BULAN Balita berdasarkan tanggal ukur
        $umurBulan = $this->hitungUmurBulan($balita->tgl_lahir, $request->tgl_ukur);

        // Ambil Umur HARI Balita berdasarkan tanggal ukur
        $umurHari = $this->hitungUmurHari($balita->tgl_lahir, $request->tgl_ukur);

        // Umur Pas Pengukuran
        $umurUkurDisplay = $this->hitungUmurDisplay($balita->tgl_lahir, $request->tgl_ukur);



        // Ambil Gender
        $gender = $balita->gender;

        // Berat Badan
        $beratBadan = $request->bb;

        // Tinggi Badan
        $tinggiBadan = $request->tb;

        // Pengkondisian koreksi tinggi badan
        if ($umurHari <= 730 && $request->cara_ukur === "Berdiri") {
            $tinggiBadan += 0.7;
        } elseif ($umurHari >= 731 && $umurHari <= 1856 && $request->cara_ukur === "Berbaring") {
            $tinggiBadan -= 0.7;
        }

        // Ambil nilai IMT balita
        $IMT = $this->hitungIMT($beratBadan, $tinggiBadan);

        // // AMBIL NILAI LMS BASIC
        // $bbUmurLMS = $this->ambilLms('BB_U', $umurBulan, $gender);
        // if ($umurHari <= 730) {
        //     $tbUmurLMS = $this->ambilLms('PB_U', $umurBulan, $gender);
        //     $bbtbLMS = $this->ambilLms('BB_PB', $tinggiBadan, $gender);
        //     $imtLMS = $this->ambilLms('IMT_U_P', $umurBulan, $gender);
        // } elseif ($umurHari >= 731 && $umurHari <= 1856) {
        //     $tbUmurLMS = $this->ambilLms('TB_U', $umurBulan, $gender);
        //     $bbtbLMS = $this->ambilLms('BB_TB', $tinggiBadan, $gender);
        //     $imtLMS = $this->ambilLms('IMT_U_T', $umurBulan, $gender);
        // }

        // AMBIL NILAI LMS EXPANDED
        $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $gender);
        $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $gender);
        $imtLMS = $this->ambilLmsExpanded('IMT_U', $umurHari, $gender);
        if ($umurHari <= 730) {
            $bbtbLMS = $this->ambilLmsExpanded('BB_PB', $tinggiBadan, $gender);
        } elseif ($umurHari >= 731 && $umurHari <= 1856) {
            $bbtbLMS = $this->ambilLmsExpanded('BB_TB', $tinggiBadan, $gender);
        }

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


        return response()->json([

            'balita_id' => $balita->id,
            'balita_name' => $balita->name,
            'tgl_ukur' => $request->tgl_ukur,
            'umur_ukur' => $umurUkurDisplay,
            'bb' => $request->bb,
            'tb' => $request->tb,
            'cara_ukur' => $request->cara_ukur,
            'zscore_bb_u' => round($zScoreBB_U, 2),
            'status_bb_u' => $statusGiziBB_U,
            'zscore_tb_u' => round($zScoreTB_U, 2),
            'status_tb_u' => $statusGiziTB_U,
            'zscore_bb_tb' => round($zScoreBB_TB, 2),
            'status_bb_tb' => $statusGiziBB_TB,
            'zscore_imt_u' => round($zScoreIMT_U, 2),
            'status_imt_u' => $statusGiziIMT_U,
        ]);
    }



    public function simpanZScore(Request $request)
    {

        $zscore = BalitaUkur::create([
            "balita_id" => $request->balita_id,
            "tgl_ukur" => $request->tgl_ukur,
            "umur_ukur" => $request->umur_ukur,
            "bb" => $request->bb,
            "tb" => $request->tb,
            "cara_ukur" => $request->cara_ukur,
            "status_bb_u" => $request->status_bb_u,
            "zscore_bb_u" => $request->zscore_bb_u,
            "status_tb_u" => $request->status_tb_u,
            "zscore_tb_u" => $request->zscore_tb_u,
            "status_bb_tb" => $request->status_bb_tb,
            "zscore_bb_tb" => $request->zscore_bb_tb,
            "status_imt_u" => $request->status_imt_u,
            "zscore_imt_u" => $request->zscore_imt_u,
            "created_by" => Auth::id(),

        ]);

        // Simpan ke dalam database
        if ($zscore->save()) {
            return response()->json(['success' => 'Berhasil menyimpan penilaian.']);
        } else {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }






    //HELPER

    // Fungsi Hitung IMT
    private function hitungIMT($beratBadan, $tinggiBadan)
    {
        $tinggiMeter = $tinggiBadan / 100;
        return $beratBadan / ($tinggiMeter * $tinggiMeter);
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    // BASIC
    private function ambilLms($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnak::where('kategori', $kategori)
            ->where('umur_atau_tinggi', $umurAtautinggi)
            ->where('gender', $gender)
            ->first(['L', 'M', 'S']);
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

    private function hitungUmurBulan($tglLahir, $tglUkur)
    {
        // Memastikan tanggal lahir dan tanggal ukur tersedia
        if (!$tglLahir || !$tglUkur) {
            return null;
        }

        // Menghitung selisih antara tanggal lahir dan tanggal ukur dalam hari
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $hariSelisih = $tanggalLahir->diffInDays($tanggalUkur);

        // Menghitung umur dalam bulan penuh (1 bulan dihitung genap 30 hari)
        $umurBulan = intdiv($hariSelisih, 30);

        return $umurBulan;
    }

    private function hitungUmurHari($tglLahir, $tglUkur)
    {
        // Memastikan tanggal lahir dan tanggal ukur tersedia
        if (!$tglLahir || !$tglUkur) {
            return null;
        }

        // Menghitung selisih antara tanggal lahir dan tanggal ukur dalam hari
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $hariSelisih = $tanggalLahir->diffInDays($tanggalUkur);

        return $hariSelisih;
    }

    private function hitungUmurDisplay($tglLahir, $tglUkur)
    {
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $umurHari = $tanggalLahir->diffInDays($tanggalUkur);
        $umurBulan = floor($umurHari / 30);
        $tahun = floor($umurBulan / 12);
        $bulan = $umurBulan % 12;
        $hari = $umurHari % 30;

        if ($umurHari <= 730) {
            // Jika umur kurang dari atau sama dengan 730 hari (2 tahun)
            return "{$umurBulan} Bulan -  {$hari} Hari";
        } else {
            // Jika umur lebih dari 730 hari
            return "{$tahun} Tahun -  {$bulan} Bulan - {$hari} Hari";
        }
    }

    // FUNGSI RUMUS HITUNG ZSCORE
    private function hitungZScore($X, $L, $M, $S)
    {
        return (($X / $M) ** $L - 1) / ($L * $S);
    }
}
