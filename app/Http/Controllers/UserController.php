<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    //

    // view user index
    public function index()
    {
        return view('pages.main.user.index');
    }

    // view tambah user
    public function add()
    {

        return view('pages.main.user.add');
    }

    // view edit
    public function edit()
    {
        return view('pages.main.user.edit');
    }

    // STORE DATA USER
    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'role' => 'required',
            'posyandu' => [
                'required_if:role,admin', // hanya diperlukan jika role adalah admin
            ],
            'username' => 'required',
            'password' => 'required',
        ], [
            'name.required' => 'Form nama harus di isi',
            'role.required' => 'Pilih role akun petugas',
            'posyandu.required_if' => 'Posyandu harus di pilih', // pesan kustom untuk posyandu
            'username.required' => 'Form username harus di isi',
            'password.required' => 'Form password harus di isi',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        User::create([
            "name" => $request->name,
            "role" => $request->role,
            "posyandu_id" => $request->posyandu,
            "username" => $request->username,
            "password" => bcrypt($request->password),
        ]);

        return Redirect::route('user.add')->with('register', 'Berhasil mendaftarkan akun');
    }
}
