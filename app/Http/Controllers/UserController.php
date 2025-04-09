<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Posyandu;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
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
            'name' => ['required', 'min:3', 'regex:/^[a-zA-Z\s]+$/'], // Hanya huruf dan spasi diizinkan
            'role' => 'required',
            'posyandu' => [
                'required_if:role,kader_posyandu', // hanya diperlukan jika role adalah admin
            ],
            'username' => [
                'required',
                'unique:users,username', // Username harus unik di tabel users
                'regex:/^\S*$/u' // Tidak boleh ada spasi
            ],
            'password' => 'required', // Password wajib diisi
        ], [
            'name.required' => 'Form nama harus diisi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'role.required' => 'Pilih role akun petugas',
            'posyandu.required_if' => 'Posyandu harus dipilih',
            'username.required' => 'Form username harus diisi',
            'username.unique' => 'Username sudah digunakan, pilih username lain',
            'username.regex' => 'Username tidak boleh mengandung spasi',
            'password.required' => 'Form password harus diisi',
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
            "created_by" => Auth::id(), // Mengisi created_by dengan ID pengguna yang sedang login
        ]);

        return Redirect::route('user.index')->with('successToast', 'Berhasil mendaftarkan akun');
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
            'name' => ['required', 'min:3', 'regex:/^[a-zA-Z\s]+$/'], // Hanya huruf dan spasi diizinkan
            'role' => 'required',
            'posyandu' => [
                'required_if:role,admin', // hanya diperlukan jika role adalah admin
            ],
            'username' => [
                'required',
                Rule::unique('users', 'username')->ignore($id), // Abaikan username untuk user dengan $id
                'regex:/^\S*$/u' // Tidak boleh ada spasi
            ],
            'password' => 'nullable', // Password boleh kosong jika tidak ingin mengubah
        ], [
            'name.required' => 'Form nama harus diisi',
            'name.regex' => 'Nama tidak boleh mengandung angka atau karakter khusus',
            'role.required' => 'Pilih role akun petugas',
            'posyandu.required_if' => 'Posyandu harus dipilih',
            'username.required' => 'Form username harus diisi',
            'username.unique' => 'Username sudah digunakan, pilih username lain',
            'username.regex' => 'Username tidak boleh mengandung spasi',
            'password.required' => 'Form password harus diisi',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $user = User::find($id);
        $user->update([
            "name" => $request->name,
            "role" => $request->role,
            "posyandu_id" => $request->posyandu,
            "username" => $request->username,
            "password" => bcrypt($request->password),
            "password" => $request->password ? bcrypt($request->password) : $user->password, // Hanya update password jika diisi
            "updated_by" => Auth::id(), // Mengisi updated_by dengan ID pengguna yang sedang login
        ]);


        return Redirect::route('user.index')->with('successToast', 'Data berhasil di update.');
    }

    // Delete User
    public function delete($id)
    {

        if ($id == Auth::id()) {
            return Redirect::route('user.index')->with('errorToast', 'Tidak boleh menghapus akun');
        }
        User::find($id)->delete();
        return Redirect::route('user.index')->with('success', 'User berhasil dihapus.');
    }
}
