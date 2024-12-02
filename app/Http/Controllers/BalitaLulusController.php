<?php

namespace App\Http\Controllers;

use App\Models\BalitaLulus;
use Illuminate\Http\Request;

class BalitaLulusController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();
        $query = BalitaLulus::with(['posyandu', 'orangtua']);
        if ($user->posyandu_id !== null) {
            $query->where('posyandu_id', $user->posyandu_id);
        }
        $balitas = $query->get();

        // return $balitas;
        return view('pages.main.balita-lulus.index', compact('balitas'));
    }
}
