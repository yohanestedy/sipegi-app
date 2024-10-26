<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    //VIEW Halaman Login
    public function login()
    {
        return view('pages.auth.login');
    }

    // STORE DATA LOGIN
    public function storeLogin(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'username' => 'required',
            'password' => 'required'
        ], [
            'username.required' => 'Masukan username.',
            'password.required' => 'Masukan password.',
        ]);

        if ($validator->fails()) {
            return Redirect::back()->withErrors($validator)->withInput();
        }

        $credential = $request->only('username', 'password');
        $user = User::where('username', $request->username)->first();

        // cek apakah berhasil login
        if (Auth::attempt($credential, $request->filled('remember'))) {
            $request->session()->regenerate();
            return Redirect::intended('/')->with([
                'successToast' => 'Login Berhasil',
                'user_name' => $user->name // menyimpan nama di session
            ]);
        }

        return Redirect::back()->with('error', 'Username atau Password salah')->withInput();
    }

    // public function logout()
    // {
    //     Auth::logout();
    //     return redirect('/login')->with(['logout' => 'Logout Success']);
    // }

    public function logout(Request $request)
    {
        Auth::logout(); // Menghapus sesi pengguna

        // Menghapus semua data sesi
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('login')->with('message', 'Anda telah logout.');
    }
}
