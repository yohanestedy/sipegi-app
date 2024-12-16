<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Balita;
use App\Models\Orangtua;
use App\Models\Posyandu;
use App\Models\BalitaUkur;
use App\Models\BalitaNonaktif;
use App\Models\BalitaUkurNonaktif;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;
use App\Models\StandarPertumbuhanAnakExpanded;
use Carbon\Carbon;

class BalitaController extends Controller
{
    //VIEW INDEX BALITA
    public function index()
    {
        $user = auth()->user();
        if ($user->posyandu_id !== null) {
            $balita = Balita::with(['posyandu', 'orangtua'])->where('posyandu_id', $user->posyandu_id)->get();
        } else {
            $balita = Balita::with(['posyandu', 'orangtua'])->get();
        }

        $posyandus = Posyandu::all();
        // return $balita;



        return view('pages.main.balita.index', compact('balita', 'posyandus'));
    }
    //VIEW ADD BALITA
    public function add()
    {
        // Mendapatkan user yang login
        $user = auth()->user();

        // Dapatkan data posyandu
        $posyandus = Posyandu::all();

        // Ambil data orangtua berdasarkan posyandu user dan dusun orangtua
        if ($user->posyandu_id !== null) {
            $orangtua = Orangtua::where('dusun_id', $user->posyandu_id)->get();
        } else {
            $orangtua = Orangtua::all();
        }

        return view('pages.main.balita.add', compact('posyandus', 'orangtua'));
    }

    // Metode untuk mengambil posyandu berdasarkan dusun_id
    public function getPosyanduByDusunId($dusunId)
    {
        // Ambil posyandu pertama yang sesuai dengan dusun_id
        $posyandu = Posyandu::where('id', $dusunId)->first();

        // Kembalikan data dalam format JSON
        return response()->json($posyandu);
    }

    // STORE DATA BALITA
    public function store(Request $request)
    {

        $request->merge([
            'name' => ucwords(strtolower($request->name)), // Membuat kapital setiap awal kata
        ]);

        $nikRequired = $request->has('disableNIK') ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],
            'nik' => [$nikRequired, 'numeric', 'digits:16', 'unique:balita,nik'],   // Memastikan hanya angka dengan panjang tepat 16
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'bpjs' => 'required',
            'orangtua' => 'required',
            'posyandu' => 'required',
            'family_order' => 'required',
            'bb_lahir' => 'required',
            'tb_lahir' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Isi Nama balita',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'nik.required' => 'NIK balita harus di isi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar balita.',
            'tgl_lahir.required' => 'Isi tanggal lahir balita',
            'gender.required' => 'Pilih jenis kelamin balita',
            'orangtua.required' => 'Pilih orangtua balita',
            'posyandu.required' => 'Pilih posyandu balita',
            'family_order.required' => 'Isi kolom anak ke berapa',
            'bb_lahir.required' => 'Isi berat badan saat lahir',
            'tb_lahir.required' => 'Isi panjang badan saat Lahir',
            'status.required' => 'Pilih Jenis Pendaftaran',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Validasi tambahan
        $tglLahir = $request->tgl_lahir;
        $familyOrder = $request->family_order;

        // Balita lebih tua
        $olderBalita = Balita::where('orangtua_id', $request->orangtua)
            ->where('tgl_lahir', '<', $tglLahir)
            ->orderBy('tgl_lahir', 'desc')
            ->first();

        if ($olderBalita && $familyOrder <= $olderBalita->family_order) {
            return Redirect::back()->withErrors([
                'family_order' => "Urutan keluarga tidak valid. Harus lebih besar dari anak ke-{$olderBalita->family_order}.",
            ])->withInput();
        }

        $request->merge([
            'bb_lahir' => $request->bb_lahir / 1000,
        ]);

        DB::beginTransaction();
        try {
            // Simpan Balita Baru
            $newBalita = Balita::create([
                "name" => $request->name,
                "nik" => $request->nik,
                "tgl_lahir" => $request->tgl_lahir,
                "gender" => $request->gender,
                "bpjs" => $request->bpjs,
                "orangtua_id" => $request->orangtua,
                "posyandu_id" => $request->posyandu,
                "family_order" => $request->family_order,
                "bb_lahir" => $request->bb_lahir,
                "tb_lahir" => $request->tb_lahir,
                "status" => $request->status,
                "tgl_aktif" => Carbon::now()->format('Y-m-d'),
                "created_by" => Auth::id(),
                "created_at" => Carbon::now(),
                "updated_at" => null,


            ]);

            // HITUNG Z-SCORE BAYI BARU LAHIR

            // Ambil Parameter Balita

            $umurHari = 0;
            $umur_ukur = '0 Bulan';
            $cara_ukur = 'Berbaring';
            $gender = $request->gender;
            $beratBadan = $request->bb_lahir;
            $tinggiBadan = $request->tb_lahir;
            $IMT = $this->hitungIMT($beratBadan, $tinggiBadan);

            // Ambil NILAI LMS
            $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $gender);
            $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $gender);
            $bbtbLMS = $this->ambilLmsExpanded('BB_PB', $tinggiBadan, $gender);
            $imtLMS = $this->ambilLmsExpanded('IMT_U', $umurHari, $gender);

            // HITUNG ZSCORE SETIAP KATEGORI
            $zScoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
            $zScoreTB_U = $this->hitungZScore($tinggiBadan, $tbUmurLMS->L, $tbUmurLMS->M, $tbUmurLMS->S);
            $zScoreBB_TB = $this->hitungZScore($beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
            $zScoreIMT_U = $this->hitungZScore($IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);

            // STATUS GIZI BB/U
            if ($zScoreBB_U < -3) {
                $statusGiziBB_U = "Berat badan sangat kurang";
            } elseif ($zScoreBB_U > -3 && $zScoreBB_U < -2) {
                $statusGiziBB_U = "Berat badan kurang";
            } elseif ($zScoreBB_U > -2 && $zScoreBB_U < 1) {
                $statusGiziBB_U = "Berat badan normal";
            } elseif ($zScoreBB_U > 1) {
                $statusGiziBB_U = "Resiko berat badan lebih";
            }

            // STATUS GIZI PB/U atau TB/U
            if ($zScoreTB_U < -3) {
                $statusGiziTB_U = "Sangat pendek";
            } elseif ($zScoreTB_U > -3 && $zScoreTB_U < -2) {
                $statusGiziTB_U = "Pendek";
            } elseif ($zScoreTB_U > -2 && $zScoreTB_U < 3) {
                $statusGiziTB_U = "Normal";
            } elseif ($zScoreTB_U > 3) {
                $statusGiziTB_U = "Tinggi";
            }

            // STATUS GIZI (BB/PB atau BB/TB)
            if ($zScoreBB_TB < -3) {
                $statusGiziBB_TB = "Gizi buruk";
            } elseif ($zScoreBB_TB > -3 && $zScoreBB_TB < -2) {
                $statusGiziBB_TB = "Gizi kurang";
            } elseif ($zScoreBB_TB > -2 && $zScoreBB_TB < 1) {
                $statusGiziBB_TB = "Gizi baik";
            } elseif ($zScoreBB_TB > 1 && $zScoreBB_TB < 2) {
                $statusGiziBB_TB = "Beresiko gizi lebih";
            } elseif ($zScoreBB_TB > 2 && $zScoreBB_TB < 3) {
                $statusGiziBB_TB = "Gizi lebih";
            } elseif ($zScoreBB_TB > 3) {
                $statusGiziBB_TB = "Obesitas";
            }

            // STATUS GIZI IMT/U
            if ($zScoreIMT_U < -3) {
                $statusGiziIMT_U = "Gizi buruk";
            } elseif ($zScoreIMT_U > -3 && $zScoreIMT_U < -2) {
                $statusGiziIMT_U = "Gizi kurang";
            } elseif ($zScoreIMT_U > -2 && $zScoreIMT_U < 1) {
                $statusGiziIMT_U = "Gizi baik";
            } elseif ($zScoreIMT_U > 1 && $zScoreIMT_U < 2) {
                $statusGiziIMT_U = "Beresiko gizi lebih";
            } elseif ($zScoreIMT_U > 2 && $zScoreIMT_U < 3) {
                $statusGiziIMT_U = "Gizi lebih";
            } elseif ($zScoreIMT_U > 3) {
                $statusGiziIMT_U = "Obesitas";
            }

            $zscore = BalitaUkur::create([
                "balita_id" => $newBalita->id,
                "tgl_ukur" => $request->tgl_lahir,
                "umur_ukur" => $umur_ukur,
                "bb" => $request->bb_lahir,
                "tb" => $request->tb_lahir,
                "cara_ukur" => $cara_ukur,
                "status_bb_u" => $statusGiziBB_U,
                "zscore_bb_u" => round($zScoreBB_U, 2),
                "status_tb_u" => $statusGiziTB_U,
                "zscore_tb_u" => round($zScoreTB_U, 2),
                "status_bb_tb" => $statusGiziBB_TB,
                "zscore_bb_tb" => round($zScoreBB_TB, 2),
                "status_imt_u" => $statusGiziIMT_U,
                "zscore_imt_u" => round($zScoreIMT_U, 2),
                "created_by" => Auth::id(),

            ]);

            DB::commit();
            return Redirect::route('balita.index')->with('successToast', 'Berhasil Menambahkan Balita.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error storing balita: ' . $e->getMessage());
            return Redirect::back()->with('errorToast', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }

    // EDIT VIEW
    // public function edit($id)
    // {


    //     $balita = Balita::find($id);
    //     // Mendapatkan user yang login
    //     $user = auth()->user();

    //     // Dapatkan data posyandu
    //     $posyandus = Posyandu::all();

    //     // Ambil data orangtua berdasarkan posyandu user dan dusun orangtua
    //     if ($user->posyandu_id !== null) {
    //         $orangtua = Orangtua::where('dusun_id', $user->posyandu_id)->get();
    //     } else {
    //         $orangtua = Orangtua::all();
    //     }

    //     return view('pages.main.balita.edit', compact('balita', 'posyandus', 'orangtua'));
    // }

    public function edit($id)
    {
        $user = auth()->user();
        $posyandus = Posyandu::all();
        $queryBalita = Balita::query();
        $queryOrtu = Orangtua::query();
        if ($user->posyandu_id !== null) {
            $queryBalita->where('posyandu_id', $user->posyandu_id);
            $queryOrtu->where('dusun_id', $user->posyandu_id);
        }
        if ($id) {
            $queryBalita->where('id', $id);
        }
        $balita = $queryBalita->first();
        $orangtua = $queryOrtu->get();

        // return $balita;
        return view('pages.main.balita.edit', compact('balita', 'posyandus', 'orangtua'));
    }

    public function update(Request $request, $id)
    {


        $request->merge([
            'name' => ucwords(strtolower($request->name)), // Membuat kapital setiap awal kata
        ]);


        $nikRequired = $request->has('disableNIK') ? 'nullable' : 'required';

        $validator = Validator::make($request->all(), [
            'name' => ['required', 'regex:/^[a-zA-Z\s\.]+$/'],
            'nik' => [$nikRequired, 'numeric', 'digits:16', Rule::unique('balita', 'nik')->ignore($id)], // Abaikan NIK yang sesuai dengan ID],   // Memastikan hanya angka dengan panjang tepat 16
            'tgl_lahir' => 'required',
            'gender' => 'required',
            'bpjs' => 'required',
            'orangtua' => 'required',
            'posyandu' => 'required',
            'family_order' => 'required',
            'bb_lahir' => 'required',
            'tb_lahir' => 'required',
            'status' => 'required',
        ], [
            'name.required' => 'Nama balita harus di isi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'nik.required' => 'NIK harus di isi',
            'nik.numeric' => 'NIK harus berisi angka saja',
            'nik.digits' => 'NIK harus berisi tepat 16 digit angka',
            'nik.unique' => 'NIK sudah terdaftar. Silahkan cek di daftar balita.',
            'tgl_lahir.required' => 'Tanggal Lahir harus di isi',
            'gender.required' => 'Jenis Kelamin harus di isi',
            'orangtua.required' => 'Orangtua harus di pilih',
            'posyandu.required' => 'Posyandu harus di pilih',
            'family_order.required' => 'Kolom anak ke berapa harus di isi',
            'bb_lahir.required' => 'Berat Badan saat lahir harus di isi',
            'tb_lahir.required' => 'Panjang Badan saat Lahir harus di isi',
            'status.required' => 'Pilih Jenis Pendaftaran',
        ]);

        if ($validator->fails()) {
            Log::error('Validation failed', $validator->errors()->toArray());
            return Redirect::back()->withErrors($validator)->withInput();
        }

        // Validasi tambahan
        $tglLahir = $request->tgl_lahir;
        $familyOrder = $request->family_order;

        // Balita lebih tua
        $olderBalita = Balita::where('orangtua_id', $request->orangtua)
            ->where('tgl_lahir', '<', $tglLahir)
            ->orderBy('tgl_lahir', 'desc')
            ->first();

        if ($olderBalita && $familyOrder <= $olderBalita->family_order) {
            return Redirect::back()->withErrors([
                'family_order' => "Urutan keluarga tidak valid. Harus lebih besar dari anak ke-{$olderBalita->family_order}.",
            ])->withInput();
        }

        $request->merge([
            'bb_lahir' => $request->bb_lahir / 1000,
        ]);
        DB::beginTransaction();
        try {
            Balita::find($id)->update([
                "name" => $request->name,
                "nik" => $request->nik,
                "tgl_lahir" => $request->tgl_lahir,
                "gender" => $request->gender,
                "bpjs" => $request->bpjs,
                "orangtua_id" => $request->orangtua,
                "posyandu_id" => $request->posyandu,
                "family_order" => $request->family_order,
                "bb_lahir" => $request->bb_lahir,
                "tb_lahir" => $request->tb_lahir,
                "status" => $request->status,
                "updated_by" => Auth::id(),
                "updated_at" => Carbon::now(),

            ]);

            // HITUNG Z-SCORE BAYI BARU LAHIR

            // Ambil Parameter Balita

            $umurHari = 0;
            $umur_ukur = '0 Bulan';
            $cara_ukur = 'Berbaring';
            $gender = $request->gender;
            $beratBadan = $request->bb_lahir;
            $tinggiBadan = $request->tb_lahir;
            $IMT = $this->hitungIMT($beratBadan, $tinggiBadan);

            // Ambil NILAI LMS
            $bbUmurLMS = $this->ambilLmsExpanded('BB_U', $umurHari, $gender);
            $tbUmurLMS = $this->ambilLmsExpanded('TB_U', $umurHari, $gender);
            $bbtbLMS = $this->ambilLmsExpanded('BB_PB', $tinggiBadan, $gender);
            $imtLMS = $this->ambilLmsExpanded('IMT_U', $umurHari, $gender);

            // HITUNG ZSCORE SETIAP KATEGORI
            $zScoreBB_U = $this->hitungZScore($beratBadan, $bbUmurLMS->L, $bbUmurLMS->M, $bbUmurLMS->S);
            $zScoreTB_U = $this->hitungZScore($tinggiBadan, $tbUmurLMS->L, $tbUmurLMS->M, $tbUmurLMS->S);
            $zScoreBB_TB = $this->hitungZScore($beratBadan, $bbtbLMS->L, $bbtbLMS->M, $bbtbLMS->S);
            $zScoreIMT_U = $this->hitungZScore($IMT, $imtLMS->L, $imtLMS->M, $imtLMS->S);

            // STATUS GIZI BB/U
            if ($zScoreBB_U < -3) {
                $statusGiziBB_U = "Berat badan sangat kurang";
            } elseif ($zScoreBB_U > -3 && $zScoreBB_U < -2) {
                $statusGiziBB_U = "Berat badan kurang";
            } elseif ($zScoreBB_U > -2 && $zScoreBB_U < 1) {
                $statusGiziBB_U = "Berat badan normal";
            } elseif ($zScoreBB_U > 1) {
                $statusGiziBB_U = "Resiko berat badan lebih";
            }

            // STATUS GIZI PB/U atau TB/U
            if ($zScoreTB_U < -3) {
                $statusGiziTB_U = "Sangat pendek";
            } elseif ($zScoreTB_U > -3 && $zScoreTB_U < -2) {
                $statusGiziTB_U = "Pendek";
            } elseif ($zScoreTB_U > -2 && $zScoreTB_U < 3) {
                $statusGiziTB_U = "Normal";
            } elseif ($zScoreTB_U > 3) {
                $statusGiziTB_U = "Tinggi";
            }

            // STATUS GIZI (BB/PB atau BB/TB)
            if ($zScoreBB_TB < -3) {
                $statusGiziBB_TB = "Gizi buruk";
            } elseif ($zScoreBB_TB > -3 && $zScoreBB_TB < -2) {
                $statusGiziBB_TB = "Gizi kurang";
            } elseif ($zScoreBB_TB > -2 && $zScoreBB_TB < 1) {
                $statusGiziBB_TB = "Gizi baik";
            } elseif ($zScoreBB_TB > 1 && $zScoreBB_TB < 2) {
                $statusGiziBB_TB = "Beresiko gizi lebih";
            } elseif ($zScoreBB_TB > 2 && $zScoreBB_TB < 3) {
                $statusGiziBB_TB = "Gizi lebih";
            } elseif ($zScoreBB_TB > 3) {
                $statusGiziBB_TB = "Obesitas";
            }

            // STATUS GIZI IMT/U
            if ($zScoreIMT_U < -3) {
                $statusGiziIMT_U = "Gizi buruk";
            } elseif ($zScoreIMT_U > -3 && $zScoreIMT_U < -2) {
                $statusGiziIMT_U = "Gizi kurang";
            } elseif ($zScoreIMT_U > -2 && $zScoreIMT_U < 1) {
                $statusGiziIMT_U = "Gizi baik";
            } elseif ($zScoreIMT_U > 1 && $zScoreIMT_U < 2) {
                $statusGiziIMT_U = "Beresiko gizi lebih";
            } elseif ($zScoreIMT_U > 2 && $zScoreIMT_U < 3) {
                $statusGiziIMT_U = "Gizi lebih";
            } elseif ($zScoreIMT_U > 3) {
                $statusGiziIMT_U = "Obesitas";
            }

            $balitaUkur = BalitaUkur::where('balita_id', $id)->orderBy('created_at', 'asc')->first();

            $balitaUkur->update([
                "tgl_ukur" => $request->tgl_lahir,
                "umur_ukur" => $umur_ukur,
                "bb" => $request->bb_lahir,
                "tb" => $request->tb_lahir,
                "cara_ukur" => $cara_ukur,
                "status_bb_u" => $statusGiziBB_U,
                "zscore_bb_u" => round($zScoreBB_U, 2),
                "status_tb_u" => $statusGiziTB_U,
                "zscore_tb_u" => round($zScoreTB_U, 2),
                "status_bb_tb" => $statusGiziBB_TB,
                "zscore_bb_tb" => round($zScoreBB_TB, 2),
                "status_imt_u" => $statusGiziIMT_U,
                "zscore_imt_u" => round($zScoreIMT_U, 2),
                "updated_by" => Auth::id(),

            ]);
            DB::commit();
            return Redirect::route('balita.index')->with('successToast', 'Berhasil Memperbaharui Data Balita.');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error update balita: ' . $e->getMessage());
            return Redirect::back()->with('errorToast', 'Terjadi kesalahan, silakan coba lagi.')->withInput();
        }
    }

    // DELETE BALITA
    public function delete($id)
    {
        Balita::find($id)->delete();
        return Redirect::route('balita.index')->with('success', 'Data Balita berhasil di hapus.');
    }


    // PINDAHKAN BALITA YANG BERUMUR 5 TAHUN KE ATAS/UMUR 1856 HARI KE ATAS
    public function pindahkanBalitaLulus()
    {
        // Ambil data balita yang sudah berumur lebih dari 1856 hari
        $balitas = Balita::whereRaw('DATEDIFF(CURDATE(), tgl_lahir) > 1856')->get();

        foreach ($balitas as $balita) {
            // Pindahkan data ke tabel balita_lulus
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
                'status' => "Lulus",
                'tgl_nonaktif' => Carbon::now()->format('Y-m-d'),
                'created_by' => $balita->created_by,
            ]);

            // Ambil semua relasi balitaUkur yang terkait dengan balita ini
            // $balitaUkurRecords = $balita->balitaUkur;
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

            // Hapus data dari tabel balita
            $balita->delete();
        }

        return response()->json(['message' => 'Data balita yang lulus berhasil dipindahkan!']);
    }


    // HELPER

    // Fungsi Hitung IMT
    private function hitungIMT($beratBadan, $tinggiBadan)
    {
        $tinggiMeter = $tinggiBadan / 100;
        return $beratBadan / ($tinggiMeter * $tinggiMeter);
    }

    // Fungsi untuk mengambil nilai L, M, S dari tabel referensi WHO berdasarkan gender dan umur/tinggi
    // EXPANDED
    private function ambilLmsExpanded($kategori, $umurAtautinggi, $gender)
    {
        return StandarPertumbuhanAnakExpanded::where('kategori', $kategori)
            ->where('umur_atau_tinggi', $umurAtautinggi)
            ->where('gender', $gender)
            ->first(['L', 'M', 'S']);
    }

    // FUNGSI RUMUS HITUNG ZSCORE
    private function hitungZScore($X, $L, $M, $S)
    {
        return (($X / $M) ** $L - 1) / ($L * $S);
    }
}
