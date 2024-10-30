<?php

namespace App\Http\Controllers;

use App\Models\Dusun;
use App\Models\Orangtua;
use App\Models\Posyandu;
use Illuminate\Http\Request;

class BalitaController extends Controller
{
    //VIEW INDEX BALITA
    public function index()
    {


        return view('pages.main.balita.index');
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

    public function store(Request $request)
    {

        return $request;
    }
}
