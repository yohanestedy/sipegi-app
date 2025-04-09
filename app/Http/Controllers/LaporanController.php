<?php

namespace App\Http\Controllers;

use App\Models\Dusun;

use App\Models\Posyandu;
use Illuminate\Http\Request;
use App\Exports\BalitaTableExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\BalitaUkurTableExport;
use App\Exports\BalitaMultiSheetExport;
use Barryvdh\Debugbar\Facades\Debugbar;
use App\Exports\BalitaUkurMultiSheetExport;

class LaporanController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $query = Posyandu::with('dusun');
        if ($user->posyandu_id != null) {
            $posyandus = $query->where('id', $user->posyandu_id)->get();
        } else {
            $posyandus = $query->get();
        }
        // Debugbar::info($posyandus->toArray());

        return view('pages.main.laporan.index', compact('posyandus'));
    }

    public function exportPengukuran(Request $request)
    {
        $request->validate([
            'posyandu_id' => 'required',
            'periode' => 'required',
        ], [
            'posyandu_id.required' => 'Pilih posyandu untuk di ekspor.',
            'periode.required' => 'Pilih bulan dan tahun.',
        ]);

        $periode = $request->periode;

        [$bulan, $tahun] = explode('.', $periode);
        $tahun = '20' . $tahun; // Format 4 digit untuk tahun

        if ($request->posyandu_id) {
            // Jika satu posyandu dipilih
            $posyandu = Posyandu::find($request->posyandu_id);
            $dusun = Dusun::find($request->posyandu_id);

            $fileName = 'Laporan_Pengukuran_Balita_Posyandu_' . $posyandu->name . '_' . $bulan . '_' . $tahun . '.xlsx';

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

            $fileName = 'Laporan_Pengukuran_Balita_Semua_Posyandu_' . $bulan . '_' . $tahun . '.xlsx';
            $fileNamePDF = 'Laporan_Pengukuran_Balita_Semua_Posyandu_' . $bulan . '_' . $tahun . '.pdf';

            // return Excel::download(new BalitaUkurMultiSheetExport($periode, $posyandus), $fileNamePDF, \Maatwebsite\Excel\Excel::MPDF);

            // Menentukan format PDF dengan MPDF dan orientasi Landscape
            // return Excel::download(
            //     new BalitaUkurMultiSheetExport($periode, $posyandus),
            //     $fileNamePDF,
            //     \Maatwebsite\Excel\Excel::MPDF,
            //     [
            //         'orientation' => 'L', // Menetapkan orientasi Landscape
            //     ]
            // );

            return Excel::download(new BalitaUkurMultiSheetExport($periode, $posyandus), $fileName);
        }
    }


    public function exportBiodataBalita(Request $request)
    {
        $request->validate([
            'posyandu_id_satu' => 'required',
        ], [
            'posyandu_id_satu.required' => 'Pilih posyandu untuk di ekspor.',
        ]);



        if ($request->posyandu_id_satu) {
            // Jika satu posyandu dipilih
            $posyandu = Posyandu::find($request->posyandu_id_satu);
            $dusun = Dusun::find($request->posyandu_id_satu);

            $fileName = 'Biodata_Balita_Posyandu_' . $posyandu->name . '.xlsx';

            return Excel::download(
                new BalitaTableExport(
                    $request->posyandu_id_satu,
                    $posyandu->name,
                    $dusun->name
                ),
                $fileName
            );
        } else {
            // Jika semua posyandu dipilih
            $posyandus = Posyandu::with('dusun')->get();

            $fileName = 'Biodata_Balita_Semua_Posyandu_' . '.xlsx';
            $fileNamePDF = 'Biodata_Balita_Semua_Posyandu_' . '.pdf';

            // return Excel::download(new BalitaUkurMultiSheetExport($periode, $posyandus), $fileNamePDF, \Maatwebsite\Excel\Excel::MPDF);

            // Menentukan format PDF dengan MPDF dan orientasi Landscape
            // return Excel::download(
            //     new BalitaUkurMultiSheetExport($periode, $posyandus),
            //     $fileNamePDF,
            //     \Maatwebsite\Excel\Excel::MPDF,
            //     [
            //         'orientation' => 'L', // Menetapkan orientasi Landscape
            //     ]
            // );

            return Excel::download(new BalitaMultiSheetExport($posyandus), $fileName);
        }
    }
}
