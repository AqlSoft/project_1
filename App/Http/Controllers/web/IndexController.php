<?php

namespace App\Http\Controllers\Web;

use Illuminate\Http\Request;

class IndexController extends Controller
{
    //

    public function index () {
        return view('front.home');
    }
}