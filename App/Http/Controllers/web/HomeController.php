<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    //

    public function index () {
        return view('front.home');
    }
}
