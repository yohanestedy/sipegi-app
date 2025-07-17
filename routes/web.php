<?php

use App\Models\Dusun;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use App\Exports\BalitaUkurTableExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\BalitaUkurController;
use App\Http\Controllers\CekRiwayatController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\BalitaNonaktifController;
use App\Http\Controllers\GiziBermasalahController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/migrasi-nonaktif', function () {
    try {
        DB::beginTransaction(); // Mulai transaksi database

        $nonaktifBalitas = DB::table('balita_nonaktif')->get();
        $jumlahDipindah = 0;

        foreach ($nonaktifBalitas as $balita) {
            // Cek apakah data sudah ada di tabel balita berdasarkan NIK
            $existing = DB::table('balita')->where('id', $balita->id)->first();

            if (!$existing) {
                DB::table('balita')->insert([
                    'is_active'     => false,
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
                    'status' => $balita->status,
                    'tgl_aktif' => \Carbon\Carbon::parse($balita->created_at)->toDateString(),
                    'tgl_nonaktif' => $balita->tgl_nonaktif,
                    'created_at' => $balita->created_at,
                    'updated_at' => $balita->updated_at,
                    'created_by' => $balita->created_by,
                    'updated_by' => $balita->updated_by,
                    'kode_unik' => 'B' . str_pad($balita->id, 4, '0', STR_PAD_LEFT),
                ]);
                $jumlahDipindah++;

                $balitaUkurNonaktifRecords = DB::table('balita_ukur_nonaktif')
                    ->where('balita_nonaktif_id', $balita->id)
                    ->get();

                foreach ($balitaUkurNonaktifRecords as $balitaUkur) {
                    DB::table('balita_ukur')->insert([
                        "id" => $balitaUkur->id,
                        "balita_id" => $balitaUkur->balita_nonaktif_id,
                        "tgl_ukur" => $balitaUkur->tgl_ukur,
                        "umur_ukur" => $balitaUkur->umur_ukur,
                        "bb" => $balitaUkur->bb,
                        "tb" => $balitaUkur->tb,
                        "lk" => $balitaUkur->lk,
                        "cara_ukur" => $balitaUkur->cara_ukur,
                        "status_bb_u" => $balitaUkur->status_bb_u,
                        "zscore_bb_u" => $balitaUkur->zscore_bb_u,
                        "status_tb_u" => $balitaUkur->status_tb_u,
                        "zscore_tb_u" => $balitaUkur->zscore_tb_u,
                        "status_bb_tb" => $balitaUkur->status_bb_tb,
                        "zscore_bb_tb" => $balitaUkur->zscore_bb_tb,
                        "status_imt_u" => $balitaUkur->status_imt_u,
                        "zscore_imt_u" => $balitaUkur->zscore_imt_u,
                        "status_lk_u" => $balitaUkur->status_lk_u,
                        "zscore_lk_u" => $balitaUkur->zscore_lk_u,
                        "created_by" => $balitaUkur->created_by,
                        "updated_by" => $balitaUkur->updated_by,
                        "created_at" => $balitaUkur->created_at,
                        "updated_at" => $balitaUkur->updated_at,
                    ]);
                }
            }
        }

        DB::commit(); // Simpan semua perubahan

        return "✅ Migrasi selesai. Total data dipindahkan: $jumlahDipindah";
    } catch (\Exception $e) {
        DB::rollBack(); // Batalkan semua perubahan jika terjadi error
        Log::error("Gagal migrasi balita_nonaktif: " . $e->getMessage());

        return response()->json([
            'status' => 'error',
            'message' => '❌ Terjadi kesalahan saat migrasi: ' . $e->getMessage()
        ], 500);
    }
});



Route::middleware('guest')->group(function () {
    Route::get('/login', [AuthController::class, 'login'])->name('login');
    Route::post('/login/store', [AuthController::class, 'storeLogin'])->name('login.store');

    Route::get('/cek-riwayat', [CekRiwayatController::class, 'form'])->name('riwayat.form');
    Route::post('/cek-riwayat/store', [CekRiwayatController::class, 'cek'])->name('riwayat.cek');
    Route::get('/cek-riwayat/show', [CekRiwayatController::class, 'show'])->name('riwayat.show');
    Route::get('/cek-riwayat/keluar', function () {
        session()->forget(['balita', 'balitaUkurs']); // atau flush semua jika perlu
        return redirect()->route('riwayat.form')->with('successToast', 'Anda telah keluar dari halaman riwayat');
    })->name('riwayat.keluar');
});


// Semua route di bawah ini akan dilindungi oleh middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    // Route::get('/', function () {
    //     return view('pages.main.index');
    // })->name('home');

    Route::get('/', [DashboardController::class, 'index'])->name('home');

    Route::group(['middleware' => 'super_admin',], function () {
        // USER
        Route::prefix('user')->group(function () {

            //  Index
            Route::get('/', [UserController::class, 'index'])->name('user.index');

            // ADD
            Route::get('/add', [UserController::class, 'add'])->name('user.add');
            Route::post('/store', [UserController::class, 'store'])->name('user.store');

            // EDIT
            Route::get('/edit/{id}', [UserController::class, 'edit'])->name('user.edit');
            Route::put('/update/{id}', [UserController::class, 'update'])->name('user.update');

            // DELETE
            Route::delete('/delete/{id}', [UserController::class, 'delete'])->name('user.delete');
        });
    });




    // ORANGTUA
    Route::prefix('orangtua')->group(function () {

        //  Index
        Route::get('/', [OrtuController::class, 'index'])->name('orangtua.index');

        // ADD
        Route::get('/add', [OrtuController::class, 'add'])->name('orangtua.add');
        Route::post('/store', [OrtuController::class, 'store'])->name('orangtua.store');

        // EDIT
        Route::get('/edit/{id}', [OrtuController::class, 'edit'])->name('orangtua.edit');
        Route::put('/update/{id}', [OrtuController::class, 'update'])->name('orangtua.update');

        // DELETE
        Route::delete('/delete/{id}', [OrtuController::class, 'delete'])->name('orangtua.delete');
    });

    // BALITA
    Route::prefix('balita')->group(function () {

        // INDEX
        Route::get('/', [BalitaController::class, 'index'])->name('balita.index');

        // ADD
        Route::get('/add', [BalitaController::class, 'add'])->name('balita.add');
        Route::post('/add/store', [BalitaController::class, 'store'])->name('balita.store');

        // EDIT
        Route::get('/edit/{id}', [BalitaController::class, 'edit'])->name('balita.edit');
        Route::put('/update/{id}', [BalitaController::class, 'update'])->name('balita.update');

        // DELETE
        Route::delete('/delete/{id}', [BalitaController::class, 'delete'])->name('balita.delete');
    });

    // BALITA LULUS
    Route::prefix('balita-nonaktif')->group(function () {
        Route::get('/lulus', [BalitaNonaktifController::class, 'balitaLulus'])->name('balitanonaktif.lulus');
        Route::get('/pindah-keluar', [BalitaNonaktifController::class, 'indexPindahKeluar'])->name('balitanonaktif.index-pindahkeluar');
        Route::get('/meninggal', [BalitaNonaktifController::class, 'indexMeninggal'])->name('balitanonaktif.index-meninggal');
        Route::post('/store/pindah-keluar', [BalitaNonaktifController::class, 'storePindahKeluar'])->name('balitanonaktif.store-pindahkeluar');
        Route::post('/store/meninggal', [BalitaNonaktifController::class, 'storeMeninggal'])->name('balitanonaktif.store-meninggal');
        Route::get('/detail/{id}', [BalitaNonaktifController::class, 'detail'])->name('balitanonaktif.detail');
    });

    Route::prefix('master-data')->group(function () {
        // POSYANDU
        Route::get('/list-posyandu', [MasterDataController::class, 'listPosyandu'])->name('masterdata.listposyandu');
        Route::get('/standar-pertumbuhan-anak', [MasterDatacontroller::class, 'standarPertumbuhanAnak'])->name('masterdata.spa');
        Route::get('/indeks-standar-antropometri-anak', [MasterDatacontroller::class, 'indeksStandar'])->name('masterdata.indeks-standar');
    });
    Route::prefix('gizi-bermasalah')->group(function () {
        // POSYANDU
        Route::get('/stunting', [GiziBermasalahController::class, 'stunting'])->name('gizi-bermasalah.stunting');
        Route::get('/bgm', [GiziBermasalahController::class, 'bgm'])->name('gizi-bermasalah.bgm');
        Route::get('/2T', [GiziBermasalahController::class, 'duaT'])->name('gizi-bermasalah.duaT');
    });


    Route::prefix('pengukuran')->group(function () {
        // POSYANDU
        Route::get('/', [BalitaUkurController::class, 'index'])->name('balitaukur.index');
        Route::get('/detail/{id}', [BalitaUkurController::class, 'detail'])->name('balitaukur.detail');

        Route::group(['middleware' => 'admin_kader'], function () {
            // USER
            Route::get('/add/{id?}', [BalitaUkurController::class, 'add'])->name('balitaukur.add');

            Route::get('/edit/{id?}', [BalitaUkurController::class, 'edit'])->name('balitaukur.edit');
            Route::put('/update-zscore/{id}', [BalitaUkurController::class, 'updateZScore'])->name('balitaukur.updateZScore');

            Route::delete('/delete/{id}', [BalitaUkurController::class, 'delete'])->name('balitaukur.delete');

            Route::post('/hitung/{id?}', [BalitaUkurController::class, 'hitung'])->name('balitaukur.hitung');
            Route::post('/simpan-zscore', [BalitaUkurController::class, 'simpanZScore'])->name('balitaukur.simpanZScore');
        });
    });

    Route::prefix('laporan')->group(function () {
        // POSYANDU
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/export/pengukuran-balita', [LaporanController::class, 'exportPengukuran'])->name('laporan.export-pengukuranbalita');
        Route::get('/export/balita-bermasalah', [LaporanController::class, 'exportBalitaGiziBermasalah'])->name('laporan.export-balitagizibermasalah');
        Route::get('/export/biodata-balita', [LaporanController::class, 'exportBiodataBalita'])->name('laporan.export-biodatabalita');
    });

    // Route untuk mengambil RT dan RW berdasarkan dusun_id
    Route::get('/api/rt/{dusunId}', [OrtuController::class, 'getRtByDusun']);
    Route::get('/api/rw/{dusunId}', [OrtuController::class, 'getRwByDusun']);

    // Route untuk mengambil Posyandu berdasarkan dusun_id orangtua
    Route::get('/api/posyandu/{dusunId}', [BalitaController::class, 'getPosyanduByDusunId']);


    // Log Out
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
