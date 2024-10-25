<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\OrtuController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

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
        return view('pages.main.balita.add');
    })->name('dashboard');

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

    Route::prefix('orangtua')->group(function () {
        //  Index
        Route::get('/', [OrtuController::class, 'index'])->name('orangtua.index');

        // ADD
        Route::get('/add', [OrtuController::class, 'add'])->name('orangtua.add');
        Route::post('/store', [OrtuController::class, 'store'])->name('orangtua.store');
    });


    // Route untuk mengambil RT dan RW berdasarkan dusun_id
    Route::get('/api/rt/{dusunId}', [OrtuController::class, 'getRtByDusun']);
    Route::get('/api/rw/{dusunId}', [OrtuController::class, 'getRwByDusun']);


    // Log Out
    Route::get('logout', [AuthController::class, 'logout'])->name('logout');
});
