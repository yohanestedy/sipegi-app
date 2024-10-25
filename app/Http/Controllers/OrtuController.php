<?php

namespace App\Http\Controllers;

use App\Models\Rt;
use App\Models\Dusun;
use Illuminate\Http\Request;

class OrtuController extends Controller
{
    //
    public function index()
    {
        return view('pages.main.orangtua.index');
    }
    //VIEW ADD BALITA
    public function add()
    {
        $dusuns = Dusun::all();
        return view('pages.main.orangtua.add', compact('dusuns'));
    }

    public function getRtByDusun($dusunId)
    {
        return response()->json(Rt::where('dusun_id', $dusunId)->get());
    }

    public function getRwByDusun($dusunId)
    {
        return response()->json(Dusun::where('id', $dusunId)->pluck('rw'));
    }

    public function store(Request $request)
    {
        return $request;
    }
}
