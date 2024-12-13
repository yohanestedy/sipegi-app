<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\BalitaNonaktif;
use App\Models\BalitaUkurNonaktif;

class BalitaNonaktifController extends Controller
{
    //
    public function balitaLulus()
    {
        $user = auth()->user();
        $query = BalitaNonaktif::with(['posyandu', 'orangtua']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }
        $balitas = $query->get();

        // return $balitas;
        return view('pages.main.balita-nonaktif.lulus', compact('balitas'));
    }

    public function detail($id)
    {

        $user = auth()->user();
        // Mengecek apakah balita ada atau tidak

        $query = BalitaNonaktif::with('posyandu');
        $balitaUkurs = BalitaUkurNonaktif::where('balita_nonaktif_id', $id)->orderBy('tgl_ukur', 'desc')->get();


        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }


        $query->where('id', $id);


        $balita = $query->first();


        // $balitaUkurs = BalitaUkur::where('balita_id', $id)->orderBy('tgl_ukur', 'desc')->get();
        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkurs->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_nonaktif_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });
        // return $balita;


        return view('pages.main.balita-nonaktif.detail', compact('balita', 'balitaUkurs'));
    }



    // HELPER

    // Status BB Naik(N)/Turun(T)/Lewat Sekali pengukuran
    public function statusBBNaik($balita_id, $tgl_ukur, $bb)
    {

        // Ambil semua data sebelumnya untuk balita yang sama
        $allPrevious = BalitaUkurNonaktif::where('balita_nonaktif_id', $balita_id)
            ->where('tgl_ukur', '<', $tgl_ukur)
            ->orderBy('tgl_ukur', 'desc')
            ->get();


        // Ambil data pertama dan kedua dari collection
        $previous = $allPrevious->first(); // Data pertama
        $previousKedua = $allPrevious->skip(1)->first(); // Data kedua

        // Jika tidak ada data sebelumnya
        if (!$previous) {
            return 'L';
        } else if (!$previousKedua) {
            return 'B';
        }
        $diffInDays = Carbon::parse($tgl_ukur)->diffInDays(Carbon::parse($previous->tgl_ukur));





        if ($diffInDays > 35) {
            return 'O';
        } else if ($bb < $previous->bb) {
            return 'T';
        } else if ($bb == $previous->bb) {
            return '2T';
        } else {
            return 'N';
        }
    }
}
