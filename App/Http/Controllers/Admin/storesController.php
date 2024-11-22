<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class storesController extends Controller
{
    //
    public function index()
    {
        return view('admin.stores.index');
    }


    public function home()
    {
        return view('admin.stores.home');
    }
}
