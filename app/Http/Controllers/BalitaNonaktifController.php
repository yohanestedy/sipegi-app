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
        $query = BalitaNonaktif::with(['posyandu', 'orangtua']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }
        $query->where('status', 'Lulus');
        $balitas = $query->get();
        $posyandus = Posyandu::all();

        // return $balitas;
        return view('pages.main.balita-nonaktif.lulus', compact('balitas', 'posyandus'));
    }

    // VIEW BALITA PINDAH KELUAR
    public function indexPindahKeluar()
    {
        $user = auth()->user();
        $query = Balita::with('posyandu');
        $queryNonaktif = BalitaNonaktif::with(['posyandu', 'orangtua']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
            $queryNonaktif->where('posyandu_id', $user->posyandu_id);
        }
        $query->orderBy('name', 'asc');
        $queryNonaktif->where('status', 'Pindah Keluar');
        $balitasAktif = $query->get();
        $balitas = $queryNonaktif->get();

        // return $balitas;
        return view('pages.main.balita-nonaktif.pindah', compact('balitas', 'balitasAktif'));
    }


    // FUNGSI MEMINDAH KELUARKAN BALITA
    public function storePindahKeluar(Request $request)
    {
        $request->validate([
            'balita_id' => 'required',
        ], [
            'balita_id.required' => 'Anda harus memilih balita.',
        ]);


        $balita = Balita::find($request->balita_id);
        // Pindahkan data ke tabel balita_nonaktif
        BalitaNonaktif::create([
            'id' => $balita->id,
            'name' => $balita->name,
            'nik' => $balita->nik,
            'tgl_lahir' => $balita->tgl_lahir,
            'gender' => $balita->gender,
            'bpjs' => $balita->bpjs,
            'orangtua_id' => $balita->orangtua_id,
            'posyandu_id' => $balita->posyandu_id,
            'family_order' => $balita->family_order,
            'bb_lahir' => $balita->bb_lahir,
            'tb_lahir' => $balita->tb_lahir,
            'status' => "Pindah Keluar",
            'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
            'created_by' => Auth::id(),
        ]);

        $balitaUkurRecords = BalitaUkur::where('balita_id', $balita->id)->get();


        // Update setiap data balita_ukur yang terkait
        foreach ($balitaUkurRecords as $balitaUkur) {


            // $balitaUkur->update(["balita_id" => null, "balita_lulus_id" => $balita->id]);
            BalitaUkurNonaktif::create([
                "id" => $balitaUkur->id,
                "balita_nonaktif_id" => $balitaUkur->balita_id,
                "tgl_ukur" => $balitaUkur->tgl_ukur,
                "umur_ukur" => $balitaUkur->umur_ukur,
                "bb" => $balitaUkur->bb,
                "tb" => $balitaUkur->tb,
                "cara_ukur" => $balitaUkur->cara_ukur,
                "status_bb_u" => $balitaUkur->status_bb_u,
                "zscore_bb_u" => $balitaUkur->zscore_bb_u,
                "status_tb_u" => $balitaUkur->status_tb_u,
                "zscore_tb_u" => $balitaUkur->zscore_tb_u,
                "status_bb_tb" => $balitaUkur->status_bb_tb,
                "zscore_bb_tb" => $balitaUkur->zscore_bb_tb,
                "status_imt_u" => $balitaUkur->status_imt_u,
                "zscore_imt_u" => $balitaUkur->zscore_imt_u,
                "created_by" => $balitaUkur->created_by,
                "updated_by" => $balitaUkur->updated_by,
                "created_at" => $balitaUkur->created_at,
                "updated_at" => $balitaUkur->updated_at,

            ]);
        }

        $balita->delete();

        return redirect()->route('balitanonaktif.index-pindahkeluar')->with('success', 'Balita berhasil dinonaktifkan(Pindah Keluar).');
    }

    // VIEW BALITA PINDAH KELUAR
    public function indexMeninggal()
    {
        $user = auth()->user();
        $query = Balita::with('posyandu');
        $queryNonaktif = BalitaNonaktif::with(['posyandu', 'orangtua']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
            $queryNonaktif->where('posyandu_id', $user->posyandu_id);
        }
        $query->orderBy('name', 'asc');
        $queryNonaktif->where('status', 'Meninggal');
        $balitasAktif = $query->get();
        $balitas = $queryNonaktif->get();

        // return $balitas;
        return view('pages.main.balita-nonaktif.meninggal', compact('balitas', 'balitasAktif'));
    }

    // FUNGSI MEMINDAH KELUARKAN BALITA
    public function storeMeninggal(Request $request)
    {
        $request->validate([
            'balita_id' => 'required',
        ], [
            'balita_id.required' => 'Anda harus memilih balita.',
        ]);


        $balita = Balita::find($request->balita_id);
        // Pindahkan data ke tabel balita_nonaktif
        BalitaNonaktif::create([
            'id' => $balita->id,
            'name' => $balita->name,
            'nik' => $balita->nik,
            'tgl_lahir' => $balita->tgl_lahir,
            'gender' => $balita->gender,
            'bpjs' => $balita->bpjs,
            'orangtua_id' => $balita->orangtua_id,
            'posyandu_id' => $balita->posyandu_id,
            'family_order' => $balita->family_order,
            'bb_lahir' => $balita->bb_lahir,
            'tb_lahir' => $balita->tb_lahir,
            'status' => "Meninggal",
            'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
            'created_by' => Auth::id(),
        ]);

        $balitaUkurRecords = BalitaUkur::where('balita_id', $balita->id)->get();


        // Update setiap data balita_ukur yang terkait
        foreach ($balitaUkurRecords as $balitaUkur) {


            // $balitaUkur->update(["balita_id" => null, "balita_lulus_id" => $balita->id]);
            BalitaUkurNonaktif::create([
                "id" => $balitaUkur->id,
                "balita_nonaktif_id" => $balitaUkur->balita_id,
                "tgl_ukur" => $balitaUkur->tgl_ukur,
                "umur_ukur" => $balitaUkur->umur_ukur,
                "bb" => $balitaUkur->bb,
                "tb" => $balitaUkur->tb,
                "cara_ukur" => $balitaUkur->cara_ukur,
                "status_bb_u" => $balitaUkur->status_bb_u,
                "zscore_bb_u" => $balitaUkur->zscore_bb_u,
                "status_tb_u" => $balitaUkur->status_tb_u,
                "zscore_tb_u" => $balitaUkur->zscore_tb_u,
                "status_bb_tb" => $balitaUkur->status_bb_tb,
                "zscore_bb_tb" => $balitaUkur->zscore_bb_tb,
                "status_imt_u" => $balitaUkur->status_imt_u,
                "zscore_imt_u" => $balitaUkur->zscore_imt_u,
                "created_by" => $balitaUkur->created_by,
                "updated_by" => $balitaUkur->updated_by,
                "created_at" => $balitaUkur->created_at,
                "updated_at" => $balitaUkur->updated_at,

            ]);
        }

        $balita->delete();

        return redirect()->route('balitanonaktif.index-meninggal')->with('success', 'Balita berhasil dinonaktifkan(Meninggal).');
    }


    // RIWAYAT PENGUKURAN BALITA NONAKTIF
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
