<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\StandarPertumbuhanAnak;
use Illuminate\Http\Request;
use Monolog\Handler\NullHandler;

class BalitaUkurController extends Controller
{
    //
    public function index()
    {
        return view('');
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
    public function store(Request $request)
    {

        // Ambil Data Balita
        $balita = Balita::find($request->balita_id);

        // Ambil Umur BULAN Balita berdasarkan tanggal ukur
        $umurBulan = $this->hitungUmurBulan($balita->tgl_lahir, $request->tgl_ukur);

        // Ambil Umur HARI Balita berdasarkan tanggal ukur
        $umurHari = $this->hitungUmurHari($balita->tgl_lahir, $request->tgl_ukur);


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

        // AMBIL NILAI LMS BALITA DARI TABEL
        $bbUmurLMS = $this->ambilLms('BB_U', $umurBulan, $gender);
        if ($umurHari <= 730) {
            $tbUmurLMS = $this->ambilLms('PB_U', $umurBulan, $gender);
            $bbtbLMS = $this->ambilLms('BB_PB', $tinggiBadan, $gender);
            $imtLMS = $this->ambilLms('IMT_U_P', $umurBulan, $gender);
        } elseif ($umurHari >= 731 && $umurHari <= 1856) {
            $tbUmurLMS = $this->ambilLms('TB_U', $umurBulan, $gender);
            $bbtbLMS = $this->ambilLms('BB_TB', $tinggiBadan, $gender);
            $imtLMS = $this->ambilLms('IMT_U_T', $umurBulan, $gender);
        }

        // HITUNG ZSCORE SETIAP KATEGORI
        $zScoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
        $zScoreTB_U = $this->hitungZScore($tinggiBadan, $tbUmurLMS->L, $tbUmurLMS->M, $tbUmurLMS->S);
        $zScoreBB_TB = $this->hitungZScore($beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
        $zScoreIMT_U = $this->hitungZScore($IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);

        return response()->json([
            'zscore_bb_u' => $zScoreBB_U,
            'zscore_tb_u' => $zScoreTB_U,
            'zscore_bb_tb' => $zScoreBB_TB,
            'zscore_imt_u' => $zScoreIMT_U,

        ]);
    }





    //HELPER

    // Fungsi Hitung IMT
    private function hitungIMT($beratBadan, $tinggiBadan)
    {
        $tinggiMeter = $tinggiBadan / 100;
        return $beratBadan / ($tinggiMeter * $tinggiMeter);
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    private function ambilLms($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnak::where('kategori', $kategori)
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

    // FUNGSI RUMUS HITUNG ZSCORE
    private function hitungZScore($X, $L, $M, $S)
    {
        return (($X / $M) ** $L - 1) / ($L * $S);
    }
}
