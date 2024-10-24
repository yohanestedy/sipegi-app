<?php

namespace App\Http\Controllers;

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
        return view('pages.main.balita.add');
    }
}
