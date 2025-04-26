<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;

class CekRiwayatController extends Controller
{
    //
    public function form()
    {
        return view('pages.cek-riwayat.form');
    }
    public function cek(Request $request)
    {
        $request->validate([
            'kode_balita' => 'required',
            'tgl_lahir' => 'required|date',
        ], [
            'kode_balita.required' => 'Masukan NIK atau Kode Balita',
            'tgl_lahir.required' => 'Masukan Tanggal Lahir Balita',
        ]);

        return redirect()->route('riwayat.show', [
            'kode_balita' => $request->kode_balita,
            'tgl_lahir' => $request->tgl_lahir,
        ]);
    }


    public function show(Request $request)
    {
        $request->validate([
            'kode_balita' => 'required',
            'tgl_lahir' => 'required|date',
        ]);

        $kodeBalita = $request->kode_balita;

        $balitaQuery = Balita::with('posyandu', 'orangtua')
            ->where('tgl_lahir', $request->tgl_lahir);

        // Cek apakah kode_balita itu NIK (16 digit angka) atau kode_unik (B0001, B0023, dst)
        if (is_numeric($kodeBalita) && strlen($kodeBalita) === 16) {
            $balitaQuery->where('nik', $kodeBalita);
        } else {
            $balitaQuery->where('kode_unik', $kodeBalita);
        }

        $balita = $balitaQuery->first();

        if (!$balita) {
            return redirect()->route('riwayat.form')->with('error', 'Oops, Gagal! Mohon periksa kembali NIK/Kode Balita dan Tanggal Lahir')->withInput();
        }

        $balitaUkurs = BalitaUkur::where('balita_id', $balita->id)
            ->orderBy('tgl_ukur', 'desc')
            ->get()
            ->each(function ($item) {
                $item->status_bb_n = $this->statusBBNaik($item->balita_id, $item->tgl_ukur, $item->bb);
            });

        return view('pages.cek-riwayat.riwayat', compact('balita', 'balitaUkurs'));
    }




    // Status BB Naik(N)/Turun(T)/Lewat Sekali pengukuran
    public function statusBBNaik($balita_id, $tgl_ukur, $bb)
    {

        // Ambil semua data sebelumnya untuk balita yang sama
        $allPrevious = BalitaUkur::where('balita_id', $balita_id)
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

        // Versi Baru Pengkondisian Status BB Naik
        return match (true) {
            $diffInDays > 35 => 'O',
            ($bb <= $previous->bb && $previous->bb <= $previousKedua->bb) => '2T',
            ($bb <= $previous->bb) => 'T',
            default => 'N'
        };

        // Versi Lama Pengkondisian Status BB Naik
        // if ($diffInDays > 35) {
        //     return 'O';
        // } else if ($bb < $previous->bb && $previous->bb < $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb < $previous->bb && $previous->bb == $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb && $previous->bb == $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb && $previous->bb < $previousKedua->bb) {
        //     return '2T'; // Berat badan tidak naik dua kali berturut turut
        // } else if ($bb == $previous->bb) {
        //     return 'T'; // Berat badan tidak naik
        // } else if ($bb < $previous->bb) {
        //     return 'T'; // Berat badan tidak naik
        // } else {
        //     return 'N'; // Berat badan naik
        // }


    }
}
