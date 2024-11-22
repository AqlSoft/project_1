<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\http\Controllers\info;
use App\Models\Admin;
use App\Models\Store;
use Illuminate\Http\Request;

class RepositoriesController extends Controller
{
    //

    use info;

    public function home () {

        $repos = Store::where('id', '!=', 1)->get();
        $admins = Admin::where([])->get();
        $adminArray = []; foreach($admins as $i => $admin) {$adminArray[$admin->id] = $admin;}
        $vars = [
            'admins' => $adminArray,
            'repos' => $repos
        ];
        return view ('admin.repositories.home', $vars);
    }

    public function create () {

        $repos = Store::where([])->get();
        $vars = [
            'repos' => $repos
        ];
        return view ('admin.repositories.create', $vars);
    }

    public function view () {
        return 'view Repo';
    }
    public function edit () {
        return 'edit Repo';
    }
    public function delete () {
        return 'delete Repo';
    }

    public function store (Request $req) {
        $repo = new Store();
        $repo->a_name = $req->a_name;
        $repo->e_name = $req->e_name != '' ? $req->e_name :  $req->a_name;
        $repo->brief = $req->brief;
        $repo->phone_number = $req->phone_number != ''? $req->phone_number : 'undefined';
        $repo->parent = explode('|', $req->parent)[1];
        $repo->level = explode('|', $req->parent)[0];
        $repo->code = $req->code != ''? $req->code : 'undefined';
        $repo->company = auth()->user()->company;
        $repo->address = $req->address != ''? $req->address : 'undefined';;
        $repo->created_by = auth()->user()->id;
        $repo->created_at = date('Y-m-d H:i:s');;

        if ($repo->save()) {
            return redirect()->back();
        }

        return ('saving....');
    }
}
