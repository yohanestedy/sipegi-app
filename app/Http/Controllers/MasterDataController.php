<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use App\Models\StandarPertumbuhanAnak;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    // Daftar Posyandu
    public function listPosyandu()
    {
        $posyandus = Posyandu::with('dusun', 'user')->get();


        return view('pages.main.master-data.list-posyandu', compact('posyandus'));
    }

    // Standar Pertumbuhan Anak (WHO Child Growth Standard)
    public function standarPertumbuhanAnak()
    {
        $data = [
            // BB menurut Umur 0 - 60 Bulan
            'bb_u_l' => StandarPertumbuhanAnak::where('kategori', 'BB_U')->where('gender', 'L')->get(),
            'bb_u_p' => StandarPertumbuhanAnak::where('kategori', 'BB_U')->where('gender', 'P')->get(),

            // PB menurut Umur 0 - 24 Bulan
            'pb_u_l' => StandarPertumbuhanAnak::where('kategori', 'PB_U')->where('gender', 'L')->get(),
            'pb_u_p' => StandarPertumbuhanAnak::where('kategori', 'PB_U')->where('gender', 'P')->get(),

            // TB menurut Umur 24 - 60 Bulan
            'tb_u_l' => StandarPertumbuhanAnak::where('kategori', 'TB_U')->where('gender', 'L')->get(),
            'tb_u_p' => StandarPertumbuhanAnak::where('kategori', 'TB_U')->where('gender', 'P')->get(),

            // BB menurut PB
            'bb_pb_l' => StandarPertumbuhanAnak::where('kategori', 'BB_PB')->where('gender', 'L')->get(),
            'bb_pb_p' => StandarPertumbuhanAnak::where('kategori', 'BB_PB')->where('gender', 'P')->get(),

            // BB menurut TB
            'bb_tb_l' => StandarPertumbuhanAnak::where('kategori', 'BB_TB')->where('gender', 'L')->get(),
            'bb_tb_p' => StandarPertumbuhanAnak::where('kategori', 'BB_TB')->where('gender', 'P')->get(),

            // IMT menurut Umur 0 - 24 Bulan (Panjang)
            'imt_u_p_l' => StandarPertumbuhanAnak::where('kategori', 'IMT_U_P')->where('gender', 'L')->get(),
            'imt_u_p_p' => StandarPertumbuhanAnak::where('kategori', 'IMT_U_P')->where('gender', 'P')->get(),

            // IMT menurut Umur 24 - 60 Bulan (Tinggi)
            'imt_u_t_l' => StandarPertumbuhanAnak::where('kategori', 'IMT_U_T')->where('gender', 'L')->get(),
            'imt_u_t_p' => StandarPertumbuhanAnak::where('kategori', 'IMT_U_T')->where('gender', 'P')->get(),

            // LK menurut Umur 0 - 60 Bulan
            'lk_u_l' => StandarPertumbuhanAnak::where('kategori', 'LK_U')->where('gender', 'L')->get(),
            'lk_u_p' => StandarPertumbuhanAnak::where('kategori', 'LK_U')->where('gender', 'P')->get(),
        ];


        return view('pages.main.master-data.spa', compact('data'));
    }

    // Indeks Standar Antropometri Anak
    public function indeksStandar()
    {



        return view('pages.main.master-data.indeks-standar');
    }
}
