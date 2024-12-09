<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BalitaUkurTableExport;
use App\Exports\BalitaUkurMultiSheetExport;
use App\Models\Posyandu;
use App\Models\Dusun;

class LaporanController extends Controller
{
    //
    public function index()
    {
        return view('pages.main.laporan.index');
    }

    public function exportPengukuran(Request $request)
    {
        $periode = $request->periode;
        [$bulan, $tahun] = explode('.', $periode);
        $tahun = '20' . $tahun; // Format 4 digit untuk tahun

        if ($request->posyandu_id) {
            // Jika satu posyandu dipilih
            $posyandu = Posyandu::find($request->posyandu_id);
            $dusun = Dusun::find($request->posyandu_id);

            $fileName = 'Laporan_Pengukuran_Balita_' . $posyandu->name . '_' . $bulan . '_' . $tahun . '.xlsx';

            return Excel::download(
                new BalitaUkurTableExport(
                    $request->posyandu_id,
                    $request->periode,
                    $posyandu->name,
                    $dusun->name
                ),
                $fileName
            );
        } else {
            // Jika semua posyandu dipilih
            $posyandus = Posyandu::with('dusun')->get();

            $fileName = 'Laporan_Pengukuran_Balita_Semua_Posiyandu_' . $bulan . '_' . $tahun . '.xlsx';

            return Excel::download(
                new BalitaUkurMultiSheetExport($periode, $posyandus),
                $fileName
            );
        }
    }
}
