<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Account;
use App\Models\ItemsCategory;
use Illuminate\Http\Request;

!defined('PAGES') ? define('PAGES', 10) : null;
class AccountsController extends Controller
{


    public function index () {
        $rootAccounts = Account::where(['type' => 'root'])->get();
        $accounts = Account::where('id','>',1)->get();
        foreach ($accounts as $in => $account) {
            $account->parent = Accounts::where(['id' => $account->parent])->first();
        }
        $vars = [
            'roots'         => $rootAccounts,
            'cats'          => $accounts,
            'rootsTypes'    => Account::$rootsTypes,
            'types'         => Account::$types,
        ];
        return view ('admin.accounts.home', $vars);
    }
    public function create ($type) {
        $accounts = Account::where('id','>',1)->get();
        foreach ($accounts as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $rootAccounts = Account::where('level', 1)->get();
        foreach ($rootAccounts as $in => $rCat) {
            $rCat->cats = Account::where(['parent_cat' => $rCat->id])->get();
            foreach ($rCat->cats as $im => $cat) {
                $cat->children = Account::where(['parent_cat' => $cat->id])->get();
            }
        }
        $vars = [
            'roots'         => $rootAccounts,
            'parent'        => [],
            'cats'          => $accounts,
            'rootsTypes'    => Account::$rootsTypes,
            'types'         => Account::$types,
            'theType'       => $type
        ];

        return view('admin.accounts.create', $vars);

    }

    public function setting () {
        $type=1;
        $accounts = Account::where('id','>',1)->get();
        foreach ($accounts as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $rootAccounts = Account::where('level', 1)->get();
        foreach ($rootAccounts as $in => $rCat) {
            $rCat->cats = Account::where(['parent_cat' => $rCat->id])->get();
            foreach ($rCat->cats as $im => $cat) {
                $cat->children = Account::where(['parent_cat' => $cat->id])->get();
            }
        }
        $vars = [
            'roots'         => $rootAccounts,
            'parent'        => [],
            'cats'          => $accounts,
            'rootsTypes'    => Account::$rootsTypes,
            'types'         => Account::$types,
            'theType'       => $type
        ];

        return view('admin.accounts.create', $vars);

    }

    public function store(Request $req) {
        var_dump($req->fin_report);
    }
}
