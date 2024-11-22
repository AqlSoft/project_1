<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

class DasboardController extends Controller
{
    //

    public function index () {

        return view('admin.dashboard');
    }

    /**
     * Log the current user out.
     *
     * @return \Illuminate\Http\Response
     */
    public function fun () {
        auth()->logout();
        return view('admin.home');
    }

}
