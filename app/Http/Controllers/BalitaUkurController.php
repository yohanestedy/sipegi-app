<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Balita;
use App\Models\Posyandu;
use App\Models\BalitaUkur;
use Illuminate\Http\Request;
use App\Models\BalitaNonaktif;
use Illuminate\Validation\Rule;
use Monolog\Handler\NullHandler;
use App\Models\BalitaUkurNonaktif;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use App\Models\StandarPertumbuhanAnak;
use Barryvdh\Debugbar\Facades\Debugbar;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\StandarPertumbuhanAnakExpanded;

class BalitaUkurController extends Controller
{
    // public function index()
    // {
    //     $user = auth()->user();
    //     $userPosyanduId = $user->posyandu_id;

    //     // Ambil pengukuran balita aktif
    //     $aktifQuery = BalitaUkur::with('balita.posyandu')
    //         ->whereNot('umur_ukur', '0 Bulan');

    //     if ($userPosyanduId !== null) {
    //         $aktifQuery->whereHas('balita', function ($q) use ($userPosyanduId) {
    //             $q->where('posyandu_id', $userPosyanduId);
    //         });
    //     }

    //     $balitaUkursAktif = $aktifQuery->get();

    //     // Ambil pengukuran balita nonaktif
    //     $nonaktifQuery = BalitaUkurNonaktif::with('balitaNonaktif.posyandu')
    //         ->whereNot('umur_ukur', '0 Bulan');

    //     if ($userPosyanduId !== null) {
    //         $nonaktifQuery->whereHas('balitaNonaktif', function ($q) use ($userPosyanduId) {
    //             $q->where('posyandu_id', $userPosyanduId);
    //         });
    //     }

    //     $balitaUkursNonaktif = $nonaktifQuery->get();

    //     // Tambahkan flag untuk menandai mana yang nonaktif (bisa dipakai untuk logic read-only di view)
    //     $balitaUkursAktif->each(function ($item) {
    //         $item->is_nonaktif = false;
    //         $item->status_bb_n = $this->statusBBNaik($item->balita_id, $item->tgl_ukur, $item->bb);
    //     });

    //     $balitaUkursNonaktif->each(function ($item) {
    //         $item->is_nonaktif = true;
    //         $item->status_bb_n = $this->statusBBNaikNonaktif($item->balita_nonaktif_id, $item->tgl_ukur, $item->bb);
    //     });

    //     // Gabungkan data
    //     $balitaUkursGabungan = $balitaUkursAktif->concat($balitaUkursNonaktif)->sortByDesc('tgl_ukur');

    //     $posyandus = Posyandu::all();
    //     // return $balitaUkursGabungan;

    //     return view('pages.main.balita-ukur.index', [
    //         'balitaUkurs' => $balitaUkursGabungan,
    //         'posyandus' => $posyandus,
    //     ]);
    // }


    public function index()
    {
        $user = auth()->user();
        $userPosyanduId = auth()->user()->posyandu_id; // Posyandu ID user
        $query = BalitaUkur::query();

        if ($user->posyandu_id !== null) {
            $query->whereHas('balita', function ($query) use ($userPosyanduId) {
                $query->where('posyandu_id', $userPosyanduId);
            });
        }
        $posyandus = Posyandu::all();

        $balitaUkurs = $query->with('balita.posyandu')->whereNot('umur_ukur', '0 Bulan')->orderBy('tgl_ukur', 'desc')->get();


        // $balitaUkur = $mentah->filter(function ($item) {
        //     return $item->status_bb_naik === '2T'; // Tidak ada data sebelumnya
        // });

        // // Filter berdasarkan status_bb_naik jika parameter `status` tersedia
        // if ($request->has('status')) {
        //     $status = $request->input('status');
        //     $balitaUkur = $balitaUkur->filter(function ($item) use ($status) {
        //         return $item->status_bb_naik === $status;
        //     });
        // }

        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkurs->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });

        // $balitaUkurs->each(function ($balitaUkur) {
        //     $statusBbN = $balitaUkur->status_bb_n; // Ini akan memanggil accessor
        // });



        return view('pages.main.balita-ukur.index', compact('balitaUkurs', 'posyandus'));
    }

    // public function index()
    // {
    //     $user = auth()->user();
    //     $userPosyanduId = $user->posyandu_id; // Posyandu ID user
    //     $query = BalitaUkur::query();

    //     // Filter berdasarkan posyandu user (jika ada)
    //     if ($userPosyanduId !== null) {
    //         $query->whereHas('balita', function ($query) use ($userPosyanduId) {
    //             $query->where('posyandu_id', $userPosyanduId);
    //         });
    //     }

    //     // Ambil pengukuran terbaru setiap balita
    //     $query->whereIn('id', function ($subquery) {
    //         $subquery->selectRaw('id')
    //             ->from('balita_ukur as bu1')
    //             ->whereRaw('tgl_ukur = (SELECT MAX(tgl_ukur) FROM balita_ukur WHERE balita_id = bu1.balita_id)');
    //     });

    //     // Filter hanya yang zscore_tb_u < -2


    //     // Load data posyandu
    //     $posyandus = Posyandu::all();

    //     // Ambil data balita ukur dengan relasi
    //     $balitaUkurs = $query->with('balita.posyandu')->where('zscore_tb_u', '<', -2)->get();


    //     // Tambahkan status_bb_n ke setiap record BalitaUkur
    //     $balitaUkurs->each(function ($balitaUkur) {
    //         $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
    //     });

    //     return view('pages.main.balita-ukur.index', compact('balitaUkurs', 'posyandus'));
    // }


    //
    public function detail($id)
    {

        $user = auth()->user();
        // Mengecek apakah balita ada atau tidak
        $query = Balita::with('posyandu', 'orangtua');

        $balitaUkurs = BalitaUkur::where('balita_id', $id)->orderBy('tgl_ukur', 'desc')->get();

        $balitaUkursGrafik = BalitaUkur::where('balita_id', $id)->whereNot('umur_ukur', '0 Bulan')->orderBy('tgl_ukur')->get();


        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }


        $query->where('id', $id);


        $balita = $query->first();


        // $balitaUkurs = BalitaUkur::where('balita_id', $id)->orderBy('tgl_ukur', 'desc')->get();

        // Tambahkan status_bb_n ke setiap record BalitaUkur
        $balitaUkurs->each(function ($balitaUkur) {
            $balitaUkur->status_bb_n = $this->statusBBNaik($balitaUkur->balita_id, $balitaUkur->tgl_ukur, $balitaUkur->bb);
        });

        // Hitung umur hari per pengukuran
        foreach ($balitaUkursGrafik as $pengukuran) {
            $pengukuran->umur_hari = $this->hitungUmurHari($balita->tgl_lahir, $pengukuran->tgl_ukur);
            $pengukuran->imt = $this->hitungIMT($pengukuran->bb, $pengukuran->tb);
        }



        // Untuk Grafik WHO
        $pedomanLMS = StandarPertumbuhanAnakExpanded::where('gender', $balita->gender)
            ->whereIn('kategori', ['BB_U', 'TB_U', 'BB_PB', 'BB_TB', 'IMT_U', 'LK_U'])
            ->orderBy('kategori')
            ->orderBy('umur_atau_tinggi')
            ->get(['kategori', 'gender', 'umur_atau_tinggi', 'sd3neg', 'sd2neg', 'sd1neg', 'median', 'sd1', 'sd2', 'sd3',])
            ->groupBy('kategori');




        // Mapping data balita untuk grafik sesuai kategori
        $grafikBalita = [
            'BB_U'  => [],
            'TB_U'  => [],
            'IMT_U' => [],
            'LK_U'  => [],
            'BB_PB' => [],
            'BB_TB' => [],
        ];

        foreach ($balitaUkursGrafik as $ukur) {
            $umurHari = $ukur->umur_hari;

            // Umur 0-5 tahun bisa masuk BB_U, TB_U, IMT_U, LK_U
            $grafikBalita['BB_U'][]  = ['tgl_ukur' => $ukur->tgl_ukur, 'umurText' => $ukur->umur_ukur, 'x' => $umurHari, 'y' => $ukur->bb];
            $grafikBalita['TB_U'][]  = ['tgl_ukur' => $ukur->tgl_ukur, 'umurText' => $ukur->umur_ukur, 'x' => $umurHari, 'y' => $ukur->tb];
            $grafikBalita['IMT_U'][] = ['tgl_ukur' => $ukur->tgl_ukur, 'umurText' => $ukur->umur_ukur, 'x' => $umurHari, 'y' => $ukur->imt];
            $grafikBalita['LK_U'][]  = ['tgl_ukur' => $ukur->tgl_ukur, 'umurText' => $ukur->umur_ukur, 'x' => $umurHari, 'y' => $ukur->lk];

            // Khusus BB_PB vs BB_TB tergantung umur
            if ($umurHari <= 730) {
                if ($ukur->tb) {
                    $grafikBalita['BB_PB'][] = ['tgl_ukur' => $ukur->tgl_ukur, 'umur' => $umurHari, 'x' => $ukur->tb, 'y' => $ukur->bb];
                }
            } else {
                if ($ukur->tb) {
                    $grafikBalita['BB_TB'][] = ['tgl_ukur' => $ukur->tgl_ukur, 'umur' => $umurHari, 'x' => $ukur->tb, 'y' => $ukur->bb];
                }
            }
        }

        // return $grafikBalita;
        // Debugbar::info($pedomanLMS);


        return view('pages.main.balita-ukur.detail', compact(
            'balita',
            'balitaUkurs',
            'pedomanLMS',
            'grafikBalita'
        ));
    }

    // HALAMAN INPUT PENGHITUNGAN
    // public function add($id = null)
    // {
    //     $user = auth()->user();
    //     if ($id) {
    //         if ($user->posyandu_id !== null) {
    //             $balitas = Balita::with('posyandu')->where('posyandu_id', $user->posyandu_id)->where('id', $id)->get();
    //         } else {
    //             $balitas = Balita::with('posyandu')->where('id', $id)->get();
    //         }
    //     } else {
    //         if ($user->posyandu_id !== null) {
    //             $balitas = Balita::with('posyandu')->where('posyandu_id', $user->posyandu_id)->get();
    //         } else {
    //             $balitas = Balita::with('posyandu')->get();
    //         }
    //     }

    //     return view('pages.main.balita-ukur.add', compact('balitas'));
    // }

    public function add($id = null)
    {
        $user = auth()->user();
        $query = Balita::aktif()->with('posyandu');

        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }

        if ($id) {
            $query->where('id', $id);
        }

        $query->orderBy('name', 'asc');

        $balitas = $query->get();

        // return $balitas;

        return view('pages.main.balita-ukur.add', compact('balitas'));
    }

    public function edit($id)
    {
        $user = auth()->user();
        $queryBalita = Balita::aktif()->with('posyandu');
        $queryUkur = BalitaUkur::query();

        if ($user->posyandu_id !== null) {

            $queryBalita->where('posyandu_id', $user->posyandu_id);
        }
        $queryUkur->where('id', $id);

        $balitaUkur = $queryUkur->first();

        $queryBalita->where('id', $balitaUkur->balita_id);

        $balitas = $queryBalita->get();


        return view('pages.main.balita-ukur.edit', compact(['balitas', 'balitaUkur']));
    }

    public function delete($id)
    {
        BalitaUkur::find($id)->delete();
        return redirect()->back()->with('success', 'Pengukuran balita berhasil dihapus.');
    }



    // PENGHITUNGAN ZSCORE / STANDARD DEVIATION SCORE
    public function hitung(Request $request, $id = null)
    {

        $validator = Validator::make($request->all(), [
            'balita_id' => 'required',
            'tgl_ukur' => [
                'required',
                Rule::unique('balita_ukur', 'tgl_ukur')->where(function ($query) use ($request) {
                    return $query->where('balita_id', $request->balita_id);
                })->ignore($id),
            ],
            // 'bb' => 'required|numeric',
            'bb' => ['required', 'numeric', 'min:0', 'max:50', 'regex:/^\d+([.,]\d{1,2})?$/'],
            'tb' => ['required', 'numeric', 'min:0', 'max:120', 'regex:/^\d+([.,]\d{1})?$/'],
            'lk' => ['required', 'numeric', 'min:0', 'max:60', 'regex:/^\d+([.,]\d{1,2})?$/'],
            'cara_ukur' => 'required',
        ], [
            'balita_id.required' => 'Pilih balita untuk diukur',
            'tgl_ukur.required' => 'Pilih tanggal pengukuran',
            'tgl_ukur.unique' => 'Balita sudah diukur di tanggal ini',
            'bb.required' => 'Isi berat badan balita',
            'bb.regex' => 'Maksimal 2 angka di belakang koma',
            'bb.min' => 'BB terlalu kecil, periksa kembali input.',
            'bb.max' => 'BB terlalu besar, periksa kembali input.',
            'tb.required' => 'Isi tinggi badan balita',
            'tb.regex' => 'Maksimal 1 angka di belakang koma',
            'tb.min' => 'TB terlalu rendah, periksa kembali input.',
            'tb.max' => 'TB terlalu tinggi, periksa kembali input.',
            'lk.required' => 'Isi lingkar kepala balita',
            'lk.regex' => 'Maksimal 2 angka di belakang koma',
            'lk.min' => 'LK terlalu kecil, periksa kembali input.',
            'lk.max' => 'LK terlalu besar, periksa kembali input.',
            'cara_ukur.required' => 'Pilih metode pengukuran balita',
        ]);

        // if ($validator->fails()) {
        //     return response()->json([
        //         'errors' => $validator->errors()
        //     ], 422); // Mengirimkan response error dengan kode status 422
        // }

        // Validasi tambahan untuk cek tinggi badan tidak boleh lebih kecil dari data sebelumnya
        $validator->after(function ($validator) use ($request) {

            if ($request->tgl_ukur == null) {
                return 0;
            }

            $previousMeasurement = BalitaUkur::where('balita_id', $request->balita_id)
                ->where('tgl_ukur', '<', $request->tgl_ukur)
                ->orderBy('tgl_ukur', 'desc')
                ->first();
            $afterMeasurement = BalitaUkur::where('balita_id', $request->balita_id)
                ->where('tgl_ukur', '>', $request->tgl_ukur)
                ->orderBy('tgl_ukur', 'asc')
                ->first();

            $balita = Balita::find($request->balita_id);
            $umurHari = $this->hitungUmurHari($balita->tgl_lahir, $request->tgl_ukur);
            $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $balita->gender);
            $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $balita->gender);
            $lkUmurLMS = $this->ambilLmsExpanded('LK_U', $umurHari, $balita->gender);

            $batasAtasBB = $bbUmurLMS->sd4 + 6;
            $batasAtasTB = $tbUmurLMS->sd4 + 10;
            $batasAtasLK = $lkUmurLMS->sd4 + 2;


            // // VALIDASI SALAH INPUT BERAT BADAN
            // if ($bbUmurLMS && $request->bb < $bbUmurLMS->sd4neg) {
            //     $validator->errors()->add('bb', 'BB tidak boleh kurang dari standar bawah(' . round($bbUmurLMS->sd4neg, 2) . ' kg).');
            // }

            // if ($bbUmurLMS && $request->bb > $bbUmurLMS->sd4) {
            //     $validator->errors()->add('bb', 'BB tidak boleh lebih dari standar atas(' . round($bbUmurLMS->sd4, 2) . ' kg).');
            // }

            if ($bbUmurLMS && $request->bb > $batasAtasBB) {
                $validator->errors()->add('bb', 'Nilai BB terlalu besar, periksa kembali input');
            }

            // VALIDASI SALAH INPUT TINGGI BADAN
            // if ($tbUmurLMS && $request->tb < $tbUmurLMS->sd4neg) {
            //     $validator->errors()->add('tb', 'TB tidak boleh kurang dari standar bawah(' . round($tbUmurLMS->sd4neg, 2) . ' cm).');
            // }

            // if ($tbUmurLMS && $request->tb > $tbUmurLMS->sd4) {
            //     $validator->errors()->add('tb', 'TB tidak boleh lebih dari standar atas(' . round($tbUmurLMS->sd4, 2) . ' cm).');
            // }

            if ($tbUmurLMS && $request->tb > $batasAtasTB) {
                $validator->errors()->add('tb', 'Nilai TB terlalu tinggi, periksa kembali input');
            }
            if ($lkUmurLMS && $request->lk > $batasAtasLK) {
                $validator->errors()->add('lk', 'Nilai LK terlalu besar, periksa kembali input');
            }

            // VALIDASI TB DAN LK KURANG DARI PENGUKURAN SEBELUMNYA
            if ($previousMeasurement && $request->tb < $previousMeasurement->tb) {
                $validator->errors()->add('tb', 'Tidak boleh lebih pendek dari pengukuran sebelumnya (' . $previousMeasurement->tb . ' cm).');
            }
            if ($previousMeasurement && $request->lk < $previousMeasurement->lk) {
                $validator->errors()->add('lk', 'Tidak boleh lebih kecil dari pengukuran sebelumnya (' . $previousMeasurement->lk . ' cm).');
            }

            // VALIDASI TB DAN LK LEBIH DARI PENGUKURAN SETELAHNYA
            if ($afterMeasurement && $request->tb > $afterMeasurement->tb) {
                $validator->errors()->add('tb', 'Tidak boleh lebih tinggi dari pengukuran setelahnya (' . $afterMeasurement->tb . ' cm).');
            }
            if ($afterMeasurement && $request->lk > $afterMeasurement->lk) {
                $validator->errors()->add('lk', 'Tidak boleh lebih besar dari pengukuran setelahnya (' . $afterMeasurement->lk . ' cm).');
            }
        });

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422); // Mengirimkan response error dengan kode status 422
        }



        // Ambil Data Balita
        $balita = Balita::find($request->balita_id);

        // Ambil Umur BULAN Balita berdasarkan tanggal ukur
        $umurBulan = $this->hitungUmurBulan($balita->tgl_lahir, $request->tgl_ukur);

        // Ambil Umur HARI Balita berdasarkan tanggal ukur
        $umurHari = $this->hitungUmurHari($balita->tgl_lahir, $request->tgl_ukur);



        // Umur Pas Pengukuran
        $umurUkurDisplay = $this->hitungUmurDisplay($balita->tgl_lahir, $request->tgl_ukur);

        $tgl_ukur_display = Carbon::parse($request->tgl_ukur)->translatedFormat('d F Y');

        $status_bb_naik = $this->statusBBNaik($request->balita_id, $request->tgl_ukur, $request->bb);



        // Ambil Gender
        $gender = $balita->gender;

        // Berat Badan
        $beratBadan = $request->bb;

        // Tinggi Badan
        $tinggiBadan = $request->tb;

        // Lingkar Kepala
        $lingkarKepala = $request->lk;



        // Pengkondisian koreksi tinggi badan
        if ($umurHari <= 730 && $request->cara_ukur === "Berdiri") {
            $tinggiBadan += 0.7;
        } elseif ($umurHari >= 731 && $umurHari <= 1856 && $request->cara_ukur === "Berbaring") {
            $tinggiBadan -= 0.7;
        }

        // Ambil nilai IMT balita
        $IMT = $this->hitungIMT($beratBadan, $tinggiBadan);

        // // AMBIL NILAI LMS BASIC
        // $bbUmurLMS = $this->ambilLms('BB_U', $umurBulan, $gender);
        // if ($umurHari <= 730) {
        //     $tbUmurLMS = $this->ambilLms('PB_U', $umurBulan, $gender);
        //     $bbtbLMS = $this->ambilLms('BB_PB', $tinggiBadan, $gender);
        //     $imtLMS = $this->ambilLms('IMT_U_P', $umurBulan, $gender);
        // } elseif ($umurHari >= 731 && $umurHari <= 1856) {
        //     $tbUmurLMS = $this->ambilLms('TB_U', $umurBulan, $gender);
        //     $bbtbLMS = $this->ambilLms('BB_TB', $tinggiBadan, $gender);
        //     $imtLMS = $this->ambilLms('IMT_U_T', $umurBulan, $gender);
        // }


        // AMBIL NILAI LMS EXPANDED
        $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $gender);
        $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $gender);
        $imtLMS = $this->ambilLmsExpanded('IMT_U', $umurHari, $gender);
        $lkLMS = $this->ambilLmsExpanded('LK_U', $umurHari, $gender);

        if ($tinggiBadan >= 45 && $tinggiBadan <= 120) {
            if ($umurHari <= 730) {
                $bbtbLMS = $this->ambilLmsExpanded('BB_PB', $tinggiBadan, $gender);
            } elseif ($umurHari >= 731 && $umurHari <= 1856) {
                $bbtbLMS = $this->ambilLmsExpanded('BB_TB', $tinggiBadan, $gender);
            }
        } else {
            $bbtbLMS = null;
        }

        // HITUNG ZSCORE SETIAP KATEGORI
        $zScoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
        $zScoreTB_U = $this->hitungZScore($tinggiBadan, $tbUmurLMS->L, $tbUmurLMS->M, $tbUmurLMS->S);
        $zScoreIMT_U = $this->hitungZScore($IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);
        $zScoreLK_U = $this->hitungZScore($lingkarKepala, $lkLMS->L, $lkLMS->M, $lkLMS->S);

        if ($bbtbLMS !== null) {
            $zScoreBB_TB = $this->hitungZScore($beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
        } else {
            $zScoreBB_TB = null;
        }

        // KOREKSI NILAI Z-SCORE
        $zScoreIMT_U = $this->hitungZscoreKoreksi($zScoreIMT_U, $IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);
        $zScoreBB_U = $this->hitungZScoreKoreksi($zScoreBB_U, $beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);

        if ($zScoreBB_TB !== null) {
            $zScoreBB_TB = $this->hitungZScoreKoreksi($zScoreBB_TB, $beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
        }

        $zScoreBB_U = round($zScoreBB_U, 2);
        $zScoreTB_U = round($zScoreTB_U, 2);
        $zScoreBB_TB = round($zScoreBB_TB, 2);
        $zScoreIMT_U = round($zScoreIMT_U, 2);
        $zScoreLK_U = round($zScoreLK_U, 2);




        // STATUS GIZI BB/U
        if ($zScoreBB_U < -3) {
            $statusGiziBB_U = "Berat badan sangat kurang";
        } elseif ($zScoreBB_U >= -3 && $zScoreBB_U < -2) {
            $statusGiziBB_U = "Berat badan kurang";
        } elseif ($zScoreBB_U >= -2 && $zScoreBB_U <= 1) {
            $statusGiziBB_U = "Berat badan normal";
        } elseif ($zScoreBB_U > 1) {
            $statusGiziBB_U = "Resiko berat badan lebih";
        }

        // STATUS GIZI PB/U atau TB/U
        if ($zScoreTB_U < -3) {
            $statusGiziTB_U = "Sangat pendek";
        } elseif ($zScoreTB_U >= -3 && $zScoreTB_U < -2) {
            $statusGiziTB_U = "Pendek";
        } elseif ($zScoreTB_U >= -2 && $zScoreTB_U <= 3) {
            $statusGiziTB_U = "Normal";
        } elseif ($zScoreTB_U > 3) {
            $statusGiziTB_U = "Tinggi";
        }

        // STATUS GIZI (BB/PB atau BB/TB)
        if ($zScoreBB_TB === null) {
            $statusGiziBB_TB = null;
        } elseif ($zScoreBB_TB < -3) {
            $statusGiziBB_TB = "Gizi buruk";
        } elseif ($zScoreBB_TB >= -3 && $zScoreBB_TB < -2) {
            $statusGiziBB_TB = "Gizi kurang";
        } elseif ($zScoreBB_TB >= -2 && $zScoreBB_TB <= 1) {
            $statusGiziBB_TB = "Gizi baik";
        } elseif ($zScoreBB_TB > 1 && $zScoreBB_TB <= 2) {
            $statusGiziBB_TB = "Beresiko gizi lebih";
        } elseif ($zScoreBB_TB > 2 && $zScoreBB_TB <= 3) {
            $statusGiziBB_TB = "Gizi lebih";
        } elseif ($zScoreBB_TB > 3) {
            $statusGiziBB_TB = "Obesitas";
        }

        // STATUS GIZI IMT/U
        if ($zScoreIMT_U < -3) {
            $statusGiziIMT_U = "Gizi buruk";
        } elseif ($zScoreIMT_U >= -3 && $zScoreIMT_U < -2) {
            $statusGiziIMT_U = "Gizi kurang";
        } elseif ($zScoreIMT_U >= -2 && $zScoreIMT_U <= 1) {
            $statusGiziIMT_U = "Gizi baik";
        } elseif ($zScoreIMT_U > 1 && $zScoreIMT_U <= 2) {
            $statusGiziIMT_U = "Beresiko gizi lebih";
        } elseif ($zScoreIMT_U > 2 && $zScoreIMT_U <= 3) {
            $statusGiziIMT_U = "Gizi lebih";
        } elseif ($zScoreIMT_U > 3) {
            $statusGiziIMT_U = "Obesitas";
        }

        // STATUS GIZI LK/U
        if ($zScoreLK_U < -2) {
            $statusGiziLK_U = "Mikrosefali";
        } elseif ($zScoreLK_U >= -2 && $zScoreLK_U <= 2) {
            $statusGiziLK_U = "Normal";
        } elseif ($zScoreLK_U > 2) {
            $statusGiziLK_U = "Makrosefali";
        }

        if ($request->lk == null) {
            $zScoreLK_U = null;
            $statusGiziLK_U = null;
        }

        $testZscoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
        $testZscoreKoreksiBB_U = $this->hitungZScoreKoreksi($zScoreBB_U, $beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);

        Debugbar::info([
            'Umur dalam hari' => $umurHari,
            'Gender' => $gender,
            'BB' => $request->bb,
            'TB' => $tinggiBadan,
            'LK' => $lingkarKepala,
            'IMT' => round($IMT, 2),
            'LMS_BB_U' => $bbUmurLMS->getAttributes(),
            // 'ZSCORE_BB_U' => round($testZscoreBB_U, 2),
            // 'ZSCORE_Koreksi_BB_U' => round($testZscoreKoreksiBB_U, 2),
            'ZSCORE_BB_TB' => $zScoreBB_TB,
            'ZSCORE_BB_U' => $testZscoreBB_U,
            'ZSCORE_Koreksi_BB_U' => $testZscoreKoreksiBB_U,
            // 'zScoreBB_U ' => round($zScoreBB_U, 2),
            // 'zScoreTB_U' => round($zScoreTB_U, 2),
            // 'zScoreBB_TB' => round($zScoreBB_TB, 2),
            // 'StatusBB_TB' => $statusGiziBB_TB,
            // 'zScoreIMT_U' => round($zScoreIMT_U, 2),
            // 'zScoreLK_U' => round($zScoreLK_U, 2),
        ]);

        return response()->json([

            'balita_id' => $balita->id,
            'balita_name' => $balita->name,
            'gender' => $balita->gender_display,
            'tgl_ukur' => $request->tgl_ukur,
            'tgl_ukur_display' => $tgl_ukur_display,
            'umur_ukur' => $umurUkurDisplay,
            'bb' => $request->bb,
            'tb' => $request->tb,
            'lk' => $request->lk,
            'status_bb_naik' => $status_bb_naik,
            'cara_ukur' => $request->cara_ukur,
            'zscore_bb_u' => round($zScoreBB_U, 2),
            'status_bb_u' => $statusGiziBB_U,
            'zscore_tb_u' => round($zScoreTB_U, 2),
            'status_tb_u' => $statusGiziTB_U,
            'zscore_bb_tb' => $zScoreBB_TB !== null ? round($zScoreBB_TB, 2) : null,
            'status_bb_tb' => $statusGiziBB_TB,
            'zscore_imt_u' => round($zScoreIMT_U, 2),
            'status_imt_u' => $statusGiziIMT_U,
            'zscore_lk_u' => $zScoreLK_U !== null ? round($zScoreLK_U, 2) : null,
            'status_lk_u' => $statusGiziLK_U,
        ]);
    }


    // STORE
    public function simpanZScore(Request $request)
    {

        $zscore = BalitaUkur::create([
            "balita_id" => $request->balita_id,
            "tgl_ukur" => $request->tgl_ukur,
            "umur_ukur" => $request->umur_ukur,
            "bb" => $request->bb,
            "tb" => $request->tb,
            "lk" => $request->lk,
            "cara_ukur" => $request->cara_ukur,
            "status_bb_u" => $request->status_bb_u,
            "zscore_bb_u" => $request->zscore_bb_u,
            "status_tb_u" => $request->status_tb_u,
            "zscore_tb_u" => $request->zscore_tb_u,
            "status_bb_tb" => $request->status_bb_tb,
            "zscore_bb_tb" => $request->zscore_bb_tb,
            "status_imt_u" => $request->status_imt_u,
            "zscore_imt_u" => $request->zscore_imt_u,
            "status_lk_u" => $request->status_lk_u,
            "zscore_lk_u" => $request->zscore_lk_u,
            "created_by" => Auth::id(),

        ]);

        // Simpan ke dalam database
        if ($zscore->save()) {
            return response()->json(['success' => 'Berhasil menyimpan penilaian.']);
        } else {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }

    // UPDATE
    public function updateZScore(Request $request, $id)
    {
        $zscore = BalitaUkur::find($id);

        if (!$zscore) {
            return response()->json(['error' => 'Data tidak ditemukan.'], 404);
        }

        $updateResult = $zscore->update([
            "balita_id" => $request->balita_id,
            "tgl_ukur" => $request->tgl_ukur,
            "umur_ukur" => $request->umur_ukur,
            "bb" => $request->bb,
            "tb" => $request->tb,
            "lk" => $request->lk,
            "cara_ukur" => $request->cara_ukur,
            "status_bb_u" => $request->status_bb_u,
            "zscore_bb_u" => $request->zscore_bb_u,
            "status_tb_u" => $request->status_tb_u,
            "zscore_tb_u" => $request->zscore_tb_u,
            "status_bb_tb" => $request->status_bb_tb,
            "zscore_bb_tb" => $request->zscore_bb_tb,
            "status_imt_u" => $request->status_imt_u,
            "zscore_imt_u" => $request->zscore_imt_u,
            "status_lk_u" => $request->status_lk_u,
            "zscore_lk_u" => $request->zscore_lk_u,
            "updated_by" => Auth::id(),
        ]);

        if ($updateResult) {
            return response()->json(['success' => 'Berhasil menyimpan penilaian.']);
        } else {
            return response()->json(['error' => 'Terjadi kesalahan saat menyimpan data.'], 500);
        }
    }








    //HELPER

    // Fungsi Hitung IMT
    private function hitungIMT($beratBadan, $tinggiBadan)
    {
        $tinggiMeter = $tinggiBadan / 100;
        return $beratBadan / ($tinggiMeter * $tinggiMeter);
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    // BASIC
    private function ambilLms($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnak::where('kategori', $kategori)
            ->where('umur_atau_tinggi', $umurAtautinggi)
            ->where('gender', $gender)
            ->first();
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    // EXPANDED
    private function ambilLmsExpanded($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnakExpanded::where('kategori', $kategori)
            ->where('umur_atau_tinggi', $umurAtautinggi)
            ->where('gender', $gender)
            ->first(['L', 'M', 'S', 'sd4neg', 'sd4']);
    }

    private function hitungUmurBulan($tglLahir, $tglUkur)
    {
        // Memastikan tanggal lahir dan tanggal ukur tersedia
        if (!$tglLahir || !$tglUkur) {
            return null;
        }

        // Menghitung selisih antara tanggal lahir dan tanggal ukur dalam hari
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $hariSelisih = $tanggalLahir->diffInDays($tanggalUkur);

        // Menghitung umur dalam bulan penuh (1 bulan dihitung genap 30 hari)
        $umurBulan = intdiv($hariSelisih, 30);

        return $umurBulan;
    }

    private function hitungUmurHari($tglLahir, $tglUkur)
    {
        // Memastikan tanggal lahir dan tanggal ukur tersedia
        if (!$tglLahir || !$tglUkur) {
            return null;
        }

        // Menghitung selisih antara tanggal lahir dan tanggal ukur dalam hari
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $hariSelisih = $tanggalLahir->diffInDays($tanggalUkur);

        return $hariSelisih;
    }

    private function hitungUmurDisplay($tglLahir, $tglUkur)
    {
        $tanggalLahir = Carbon::parse($tglLahir);
        $tanggalUkur = Carbon::parse($tglUkur);
        $umurHari = $tanggalLahir->diffInDays($tanggalUkur);
        // $umurBulan = floor($umurHari / 30);
        // $tahun = floor($umurBulan / 12);
        // $bulan = $umurBulan % 12;
        // $hari = $umurHari % 30;
        $umurBulan = floor($umurHari / 30.4375);

        $tahun = floor($umurHari / 365.25);
        $sisaHariSetelahTahun = $umurHari - $tahun * 365.25;
        // $bulan = $umurBulan % 12;
        $bulan = floor($sisaHariSetelahTahun / 30.4375);
        // $sisaHariSetelahBulan = $sisaHariSetelahTahun - $bulan * 30.4375;
        $hari = floor($umurHari - $umurBulan * 30.4375);



        if ($umurHari <= 730) {
            // Jika umur kurang dari atau sama dengan 730 hari (2 tahun)
            return "{$umurBulan} Bulan -  {$hari} Hari";
        } else {
            // Jika umur lebih dari 730 hari
            return "{$tahun} Tahun -  {$bulan} Bulan - {$hari} Hari";
        }
    }

    // FUNGSI RUMUS HITUNG ZSCORE
    private function hitungZScore($y, $L, $M, $S)
    {
        return (($y / $M) ** $L - 1) / ($L * $S);
    }


    // Function KOREKSI JIKA Z-SCORE lebih besar dari 3 dan lebih kecl dari -3

    private function hitungZscoreKoreksi($z_ind, $y, $L, $M, $S)
    {
        // Condition 1: Menggunakan nilai ABSOLUT z_ind
        if (abs($z_ind) <= 3) {
            return $z_ind;
        }
        // atau rentang -3 to 3
        // if ($z_ind <= 3 && $z_ind >= -3) {
        //     return $z_ind;
        // }

        // Condition 2: kalo z_ind lebih dari 3
        if ($z_ind > 3) {
            $sd3pos = $M * pow((1 + ($L * $S * 3)), (1 / $L));
            // $sd3pos = round($sd3pos, 2);

            $sd2pos = $M * pow((1 + ($L * $S * 2)), (1 / $L));
            // $sd2pos = round($sd2pos, 2);

            $sd23pos = $sd3pos - $sd2pos;
            return 3 + (($y - $sd3pos) / $sd23pos);
        }

        // Condition 3: kalo z_ind kurang dari -3
        if ($z_ind < -3) {

            $sd3neg = $M * pow((1 + ($L * $S * (-3))), (1 / $L));
            // $sd3neg = round($sd3neg, 2);

            $sd2neg = $M * pow((1 + ($L * $S * (-2))), (1 / $L));
            // $sd2neg = round($sd2neg, 2);

            $sd23neg = $sd2neg - $sd3neg;
            return -3 + (($y - $sd3neg) / $sd23neg);
        }

        // Should not reach here, but return original z_ind as a fallback
        return $z_ind;
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

    public function statusBBNaikNonaktif($balita_nonaktif_id, $tgl_ukur, $bb)
    {

        // Ambil semua data sebelumnya untuk balita yang sama
        $allPrevious = BalitaUkurNonaktif::where('balita_nonaktif_id', $balita_nonaktif_id)
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
