<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Posyandu;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;

class GiziBermasalahController extends Controller
{
    //
    public function stunting()
    {
        $user = auth()->user();
        $userPosyanduId = $user->posyandu_id; // Posyandu ID user
        $query = BalitaUkur::query();

        // Filter berdasarkan posyandu user (jika ada)
        if ($userPosyanduId !== null) {
            $query->whereHas('balita', function ($query) use ($userPosyanduId) {
                $query->where('posyandu_id', $userPosyanduId);
            });
        }

        // Ambil pengukuran terbaru setiap balita
        $query->whereIn('id', function ($subquery) {
            $subquery->selectRaw('id')
                ->from('balita_ukur as bu1')
                ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
        });

        // Filter hanya yang zscore_tb_u < -2


        // Load data posyandu
        $posyandus = Posyandu::all();

        // Ambil data balita ukur dengan relasi
        $balitaUkurs = $query->with('balita.posyandu')
            ->whereHas('balita', fn($q) => $q->where('is_active', true))
            ->where('zscore_tb_u', '<', -2)->get();


        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkurs->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });

        return view('pages.main.gizi-bermasalah.stunting', compact('balitaUkurs', 'posyandus'));
    }

    public function bgm()
    {
        $user = auth()->user();
        $userPosyanduId = $user->posyandu_id; // Posyandu ID user
        $query = BalitaUkur::query();

        // Filter berdasarkan posyandu user (jika ada)
        if ($userPosyanduId !== null) {
            $query->whereHas('balita', function ($query) use ($userPosyanduId) {
                $query->where('posyandu_id', $userPosyanduId);
            });
        }

        // Ambil pengukuran terbaru setiap balita
        $query->whereIn('id', function ($subquery) {
            $subquery->selectRaw('id')
                ->from('balita_ukur as bu1')
                ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
        });

        // Filter hanya yang zscore_tb_u < -2


        // Load data posyandu
        $posyandus = Posyandu::all();

        // Ambil data balita ukur dengan relasi
        $balitaUkurs = $query->with('balita.posyandu')
            ->whereHas('balita', fn($q) => $q->where('is_active', true))
            ->where('zscore_bb_u', '<', -2)->get();


        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkurs->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });

        return view('pages.main.gizi-bermasalah.bgm', compact('balitaUkurs', 'posyandus'));
    }
    public function duaT()
    {
        $user = auth()->user();
        $userPosyanduId = $user->posyandu_id; // Posyandu ID user
        $query = BalitaUkur::query();

        // Filter berdasarkan posyandu user (jika ada)
        if ($userPosyanduId !== null) {
            $query->whereHas('balita', function ($query) use ($userPosyanduId) {
                $query->where('posyandu_id', $userPosyanduId);
            });
        }

        // Ambil pengukuran terbaru setiap balita
        $query->whereIn('id', function ($subquery) {
            $subquery->selectRaw('id')
                ->from('balita_ukur as bu1')
                ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
        });

        // Filter hanya yang zscore_tb_u < -2


        // Load data posyandu
        $posyandus = Posyandu::all();

        // Ambil data balita ukur dengan relasi
        $balitaUkur = $query->with('balita.posyandu')->whereHas('balita', fn($q) => $q->where('is_active', true))->get();



        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkur->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });

        $balitaUkurs = $balitaUkur->filter(function ($item) {
            return $item->status_bb_n === '2T'; // Tidak ada data sebelumnya
        });

        return view('pages.main.gizi-bermasalah.duaT', compact('balitaUkurs', 'posyandus'));
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
