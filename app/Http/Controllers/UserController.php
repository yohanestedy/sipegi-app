<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
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

        $user = User::with('posyandu')->get();
        return view('pages.main.user.index', compact('user'));
    }

    // view tambah user
    public function add()
    {
        $listPosyandu = Posyandu::all();

        return view('pages.main.user.add', compact('listPosyandu'));
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

        return Redirect::route('user.index')->with('success', 'Berhasil mendaftarkan akun');
    }

    // view edit
    public function edit($id)
    {
        $user = User::where('id', $id)->with('posyandu')->first();
        $listPosyandu = Posyandu::all();
        return view('pages.main.user.edit', compact('user', 'listPosyandu'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|min:3',
            'role' => 'required',
            'posyandu' => [
                'required_if:role,admin', // hanya diperlukan jika role adalah admin
            ],
            'username' => 'required',
        ], [
            'name.required' => 'Form nama harus di isi',
            'role.required' => 'Pilih role akun petugas',
            'posyandu.required_if' => 'Posyandu harus di pilih', // pesan kustom untuk posyandu
            'username.required' => 'Form username harus di isi',
        ]);
        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        User::find($id)->update([
            "name" => $request->name,
            "role" => $request->role,
            "posyandu_id" => $request->posyandu,
            "username" => $request->username,
            "password" => bcrypt($request->password),
        ]);

        return Redirect::route('user.index')->with('success', 'Data berhasil di update.');
    }

    // Delete User
    public function delete($id)
    {

        User::find($id)->delete();
        return Redirect::route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
