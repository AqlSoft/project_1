<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClientsCategoriesController extends Controller
{
    //

    public static $scopes = [1=>'فردى', 2=>'مؤسسة', 3=>'شركة', 4=>'مصنع', 5=>'مزرعة', 6=>'تاجر',];

    public function index () {
        $vars = [
            'scopes'        => static::$scopes
        ];
        return view ('admin.clients.categories.home', $vars);
    }
}
