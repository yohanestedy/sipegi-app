<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //

    // view user index
    public function index()
    {
        return view('pages.main.user.index');
    }

    // view tambah user
    public function add()
    {

        return view('pages.main.user.add');
    }

    public function edit()
    {
        return view('pages.main.user.edit');
    }

    // STORE DATA USER
    public function store(Request $request) {}
}
