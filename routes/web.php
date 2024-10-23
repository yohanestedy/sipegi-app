<?php

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

Route::get('/', function () {
    return view('pages.main.user.add');
});

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

    //

});
