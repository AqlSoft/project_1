<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

class HomeCotroller extends Controller
{
    //

    public function index () {
        return view('home.index');
    }
}
