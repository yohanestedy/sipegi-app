<?php

namespace App\Http\Controllers;

use App\Models\Balita;
use Illuminate\Http\Request;

class BalitaUkurController extends Controller
{
    //
    public function index()
    {
        return view('');
    }

    public function add($id = null)
    {
        $user = auth()->user();
        if ($id) {
            $balitas = Balita::with('posyandu')->where('id', $id)->get();
        } else {
            if ($user->posyandu_id !== null) {
                $balitas = Balita::with('posyandu')->where('posyandu_id', $user->posyandu_id)->get();
            } else {
                $balitas = Balita::with('posyandu')->get();
            }
        }
        return $balitas;




        return view('pages.main.balita-ukur.add', compact('balitas'));
    }
}
