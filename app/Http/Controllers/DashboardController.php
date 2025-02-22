<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\Orangtua;
use App\Models\Posyandu;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    // public function index1()
    // {

    //     $user = auth()->user();
    //     $userPosyanduId = $user->posyandu_id;
    //     $now = now(); // Ambil tanggal hari ini
    //     $startOfMonth = $now->copy()->startOfMonth(); // Awal bulan
    //     $endOfMonth = $now->copy()->endOfMonth(); // Akhir bulan
    //     $queryStunting = BalitaUkur::query();
    //     $queryBGM = BalitaUkur::query();
    //     $query2T = BalitaUkur::query();

    //     if ($user->posyandu_id !== null) {
    //         $totalBalitas = Balita::where('posyandu_id', $user->posyandu_id)->count();
    //         $totalOrangtuas = Orangtua::where('dusun_id', $user->posyandu_id)->count();
    //         $namaPosyandu = Posyandu::where('id', $user->posyandu_id)->first();

    //         // Hitung jumlah pengukuran bulan ini berdasarkan posyandu_id
    //         $totalPengukuran = BalitaUkur::whereBetween('tgl_ukur', [$startOfMonth, $endOfMonth])
    //             ->whereHas('balita', function ($query) use ($user) {
    //                 $query->where('posyandu_id', $user->posyandu_id);
    //             })
    //             ->count();

    //         $queryStunting->whereHas('balita', function ($query) use ($userPosyanduId) {
    //             $query->where('posyandu_id', $userPosyanduId);
    //         });
    //         $queryBGM->whereHas('balita', function ($query) use ($userPosyanduId) {
    //             $query->where('posyandu_id', $userPosyanduId);
    //         });
    //         $query2T->whereHas('balita', function ($query) use ($userPosyanduId) {
    //             $query->where('posyandu_id', $userPosyanduId);
    //         });
    //     } else {
    //         $totalBalitas = Balita::count();
    //         $totalOrangtuas = Orangtua::count();
    //         $namaPosyandu = null;

    //         // Hitung jumlah pengukuran bulan ini secara keseluruhan
    //         $totalPengukuran = BalitaUkur::whereBetween('tgl_ukur', [$startOfMonth, $endOfMonth])->count();
    //     }

    //     // Ambil pengukuran terbaru setiap balita
    //     $queryStunting->whereIn('id', function ($subquery) {
    //         $subquery->selectRaw('id')
    //             ->from('balita_ukur as bu1')
    //             ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
    //     });
    //     $queryBGM->whereIn('id', function ($subquery) {
    //         $subquery->selectRaw('id')
    //             ->from('balita_ukur as bu1')
    //             ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
    //     });

    //     $query2T->whereIn('id', function ($subquery) {
    //         $subquery->selectRaw('id')
    //             ->from('balita_ukur as bu1')
    //             ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
    //     });

    //     $totalStunting = $queryStunting->where('zscore_tb_u', '<', -2)->count();
    //     $totalBGM = $queryBGM->where('zscore_bb_u', '<', -2)->count();
    //     $total2T = $query2T->get();


    //     // Tambahkan status_bb_n ke setiap record BalitaUkur
    //     $total2T->each(function ($balitaUkur) {
    //         $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
    //     });

    //     $total2T = $total2T->filter(function ($item) {
    //         return $item->status_bb_n === '2T'; // Tidak ada data sebelumnya
    //     });
    //     $total2T = $total2T->count();



    //     $data = [
    //         'totalBalitas' => $totalBalitas,
    //         'totalOrangtuas' => $totalOrangtuas,
    //         'totalPengukuran' => $totalPengukuran,
    //         'totalStunting' => $totalStunting,
    //         'totalBGM' => $totalBGM,
    //         'total2T' => $total2T,
    //         'namaPosyandu' => $namaPosyandu,
    //     ];


    //     return view('pages.main.index', $data);
    // }

    public function index()
    {
        $user = auth()->user();
        $userPosyanduId = $user->posyandu_id;
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $endOfMonth = $now->copy()->endOfMonth();

        // Inisialisasi query berdasarkan akses user
        $balitaQuery = Balita::query();
        $balitaUkurQuery = BalitaUkur::query();
        $orangtuaQuery = Orangtua::query();

        if ($userPosyanduId !== null) {
            $balitaQuery->where('posyandu_id', $userPosyanduId);
            $balitaUkurQuery->whereHas('balita', function ($query) use ($userPosyanduId) {
                $query->where('posyandu_id', $userPosyanduId);
            });
            $orangtuaQuery->where('dusun_id', $userPosyanduId);
        }

        // Hitung total data utama
        $totalBalitas = $balitaQuery->count();
        $totalOrangtuas = $orangtuaQuery->count();
        $totalPengukuran = (clone $balitaUkurQuery)->whereBetween('tgl_ukur', [$startOfMonth, $endOfMonth])->count();
        $namaPosyandu = $userPosyanduId ? Posyandu::find($userPosyanduId) : null;

        // Query untuk mendapatkan pengukuran terbaru setiap balita
        $latestMeasurements = (clone $balitaUkurQuery)->whereIn('id', function ($subquery) {
            $subquery->selectRaw('id')
                ->from('balita_ukur as bu1')
                ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
        });

        // Filter berdasarkan kategori z-score
        $totalStunting = (clone $latestMeasurements)->where('zscore_tb_u', '<', -2)->count();
        $totalBGM = (clone $latestMeasurements)->where('zscore_bb_u', '<', -2)->count();

        // Hitung total 2T
        $total2T = $latestMeasurements->get()->filter(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
            return $balitaUkur->status_bb_n === '2T';
        })->count();

        return view('pages.main.index', compact(
            'totalBalitas',
            'totalOrangtuas',
            'totalPengukuran',
            'totalStunting',
            'totalBGM',
            'total2T',
            'namaPosyandu'
        ));
    }


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
    }
}
