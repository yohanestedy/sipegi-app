<?php

namespace App\Http\Controllers;

use App\Models\Posyandu;
use Illuminate\Http\Request;

class MasterDataController extends Controller
{
    //
    public function listPosyandu()
    {
        $user = auth()->user();
        if ($user->posyandu_id !== null) {
            $posyandus = Posyandu::where('id', $user->posyandu_id)->with('dusun', 'user')->get();
        } else {

            $posyandus = Posyandu::with('dusun', 'user')->get();
        }

        return view('pages.main.master-data.list-posyandu', compact('posyandus'));
    }
}
