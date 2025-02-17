<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use App\Models\Orangtua;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    //
    public function index()
    {

        $user = auth()->user();
        $now = now(); // Ambil tanggal hari ini
        $startOfMonth = $now->copy()->startOfMonth(); // Awal bulan
        $endOfMonth = $now->copy()->endOfMonth(); // Akhir bulan

        if ($user->posyandu_id !== null) {
            $totalBalitas = Balita::where('posyandu_id', $user->posyandu_id)->count();
            $totalOrangtuas = Orangtua::where('dusun_id', $user->posyandu_id)->count();

            // Hitung jumlah pengukuran bulan ini berdasarkan posyandu_id
            $totalPengukuran = BalitaUkur::whereBetween('tgl_ukur', [$startOfMonth, $endOfMonth])
                ->whereHas('balita', function ($query) use ($user) {
                    $query->where('posyandu_id', $user->posyandu_id);
                })
                ->count();
        } else {
            $totalBalitas = Balita::count();
            $totalOrangtuas = Orangtua::count();

            // Hitung jumlah pengukuran bulan ini secara keseluruhan
            $totalPengukuran = BalitaUkur::whereBetween('tgl_ukur', [$startOfMonth, $endOfMonth])->count();
        }


        return view('pages.main.index', compact('user', 'totalBalitas', 'totalOrangtuas', 'totalPengukuran'));
    }
}
