<?php

use App\Models\Posyandu;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Exports\BalitaUkurTableExport;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\BalitaController;
use App\Http\Controllers\LaporanController;
use App\Http\Controllers\BalitaUkurController;
use App\Http\Controllers\MasterDataController;
use App\Http\Controllers\BalitaNonaktifController;
use App\Models\Dusun;

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

Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('/login/store', [AuthController::class, 'storeLogin'])->name('login.store');

// Semua route di bawah ini akan dilindungi oleh middleware 'auth'
Route::group(['middleware' => 'auth'], function () {
    Route::get('/', function () {
        return view('pages.main.index');
    })->name('home');

    Route::group(['middleware' => 'super_admin'], function () {
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
        Route::post('/pindahkan-balita', [BalitaNonaktifController::class, 'storePindahKeluar'])->name('balitanonaktif.store-pindahkeluar');
        Route::get('/detail/{id}', [BalitaNonaktifController::class, 'detail'])->name('balitanonaktif.detail');
    });

    Route::prefix('master-data')->group(function () {
        // POSYANDU
        Route::get('/list-posyandu', [MasterDataController::class, 'listPosyandu'])->name('masterdata.listposyandu');
        Route::get('/standar-pertumbuhan-anak', [MasterDatacontroller::class, 'standarPertumbuhanAnak'])->name('masterdata.spa');
        Route::get('/indeks-standar-antropometri-anak', [MasterDatacontroller::class, 'indeksStandar'])->name('masterdata.indeks-standar');
    });


    Route::prefix('pengukuran')->group(function () {
        // POSYANDU
        Route::get('/', [BalitaUkurController::class, 'index'])->name('balitaukur.index');
        Route::get('/detail/{id}', [BalitaUkurController::class, 'detail'])->name('balitaukur.detail');

        Route::get('/add/{id?}', [BalitaUkurController::class, 'add'])->name('balitaukur.add');

        Route::get('/edit/{id?}', [BalitaUkurController::class, 'edit'])->name('balitaukur.edit');
        Route::put('/update-zscore/{id}', [BalitaUkurController::class, 'updateZScore'])->name('balitaukur.updateZScore');

        Route::post('/hitung/{id?}', [BalitaUkurController::class, 'hitung'])->name('balitaukur.hitung');
        Route::post('/simpan-zscore', [BalitaUkurController::class, 'simpanZScore'])->name('balitaukur.simpanZScore');
    });

    Route::prefix('laporan')->group(function () {
        // POSYANDU
        Route::get('/', [LaporanController::class, 'index'])->name('laporan.index');
        Route::get('/export/pengukuran-balita', [LaporanController::class, 'exportPengukuran'])->name('laporan.export-pengukuranbalita');
    });

    // Route untuk mengambil RT dan RW berdasarkan dusun_id
    Route::get('/api/rt/{dusunId}', [OrtuController::class, 'getRtByDusun']);
    Route::get('/api/rw/{dusunId}', [OrtuController::class, 'getRwByDusun']);

    // Route untuk mengambil Posyandu berdasarkan dusun_id orangtua
    Route::get('/api/posyandu/{dusunId}', [BalitaController::class, 'getPosyanduByDusunId']);


    // Log Out
    Route::post('logout', [AuthController::class, 'logout'])->name('logout');
});
