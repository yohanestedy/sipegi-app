<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\Posyandu;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;
use App\Models\BalitaNonaktif;
use App\Models\BalitaUkurNonaktif;
use Illuminate\Support\Facades\Auth;

class BalitaNonaktifController extends Controller
{
    //
    public function balitaLulus()
    {
        $user = auth()->user();
        $query = Balita::nonaktif()->with(['posyandu', 'orangtua.dusun', 'orangtua.rt']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }
        $query->where('status', 'Lulus');
        $balitas = $query->get();
        $posyandus = Posyandu::all();

        // return $balitas;
        return view('pages.main.balita-nonaktif.lulus', compact('balitas', 'posyandus'));
    }

    // PINDAHKAN BALITA YANG BERUMUR 5 TAHUN KE ATAS/UMUR 1856 HARI KE ATAS
    public function pindahkanBalitaLulus()
    {
        // Ambil data balita yang sudah berumur lebih dari 1856 hari
        $balitas = Balita::aktif()->whereRaw('DATEDIFF(CURDATE(), tgl_lahir) > 1825')->get();

        foreach ($balitas as $balita) {
            // Pindahkan data ke tabel balita_lulus
            Balita::find($balita->id)->update([
                'is_active' => false,
                'status' => "Lulus",
                'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
                'updated_by' => 1,
                'updated_at' => Carbon::now(),
            ]);
        }

        return response()->json(['message' => 'Data balita yang lulus berhasil dipindahkan!']);
    }

    // VIEW BALITA PINDAH KELUAR
    public function indexPindahKeluar()
    {
        $user = auth()->user();
        $query = Balita::aktif()->with('posyandu'); // Untuk Formulir Balita Pindah Keluar
        $queryNonaktif = Balita::nonaktif()->with(['posyandu', 'orangtua.dusun', 'orangtua.rt']);

        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
            $queryNonaktif->where('posyandu_id', $user->posyandu_id);
        }

        $query->orderBy('name', 'asc');
        $queryNonaktif->where('status', 'Pindah Keluar');

        $balitasAktif = $query->get();
        $balitas = $queryNonaktif->get();

        $posyandus = Posyandu::all();

        // return $balitas;
        return view('pages.main.balita-nonaktif.pindah', compact('balitas', 'balitasAktif', 'posyandus'));
    }


    // FUNGSI MEMINDAH KELUARKAN BALITA
    public function storePindahKeluar(Request $request)
    {
        $request->validate([
            'balita_id' => 'required',
        ], [
            'balita_id.required' => 'Anda harus memilih balita.',
        ]);

        // Pindahkan data ke tabel balita_nonaktif
        Balita::find($request->balita_id)->update([
            'is_active' => false,
            'status' => "Pindah Keluar",
            'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ]);


        return redirect()->route('balitanonaktif.index-pindahkeluar')->with('success', 'Balita berhasil dinonaktifkan(Pindah Keluar).');
    }

    // VIEW BALITA PINDAH KELUAR
    public function indexMeninggal()
    {
        $user = auth()->user();
        $query = Balita::aktif()->with('posyandu'); // Untuk Formulir Balita Meninggal
        $queryNonaktif = Balita::nonaktif()->with(['posyandu', 'orangtua.dusun', 'orangtua.rt']);

        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
            $queryNonaktif->where('posyandu_id', $user->posyandu_id);
        }

        $query->orderBy('name', 'asc');
        $queryNonaktif->where('status', 'Meninggal');

        $balitasAktif = $query->get();
        $balitas = $queryNonaktif->get();

        $posyandus = Posyandu::all();

        // return $balitas;
        return view('pages.main.balita-nonaktif.meninggal', compact('balitas', 'balitasAktif', 'posyandus'));
    }

    // FUNGSI MEMINDAH KELUARKAN BALITA
    public function storeMeninggal(Request $request)
    {
        $request->validate([
            'balita_id' => 'required',
        ], [
            'balita_id.required' => 'Anda harus memilih balita.',
        ]);

        // Pindahkan data ke tabel balita_nonaktif
        Balita::find($request->balita_id)->update([
            'is_active' => false,
            'status' => "Meninggal",
            'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
            'updated_by' => Auth::id(),
            'updated_at' => Carbon::now(),
        ]);



        return redirect()->route('balitanonaktif.index-meninggal')->with('success', 'Balita berhasil dinonaktifkan(Meninggal).');
    }


    // RIWAYAT PENGUKURAN BALITA NONAKTIF
    public function detail($id)
    {

        $user = auth()->user();
        // Mengecek apakah balita ada atau tidak

        $query = Balita::nonaktif()->with('posyandu');
        $balitaUkurs = BalitaUkur::where('balita_id', $id)->orderBy('tgl_ukur', 'desc')->get();


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
