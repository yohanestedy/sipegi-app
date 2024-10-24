<?php

namespace App\Http\Controllers;

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
        return view('pages.main.orangtua.add');
    }
}
