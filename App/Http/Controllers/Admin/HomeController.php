<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsCategoryCreateRequest;
use App\Models\Client;
use App\Models\Log;
use App\Models\Contract;
use App\Models\Table;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\AccountsCategory;
use Illuminate\Http\Request;


class HomeController extends Controller
{
    //

    public function index () {
        $categories = AccountsCategory::where([])->orderBy('id', 'ASC')->paginate(10);

        $vars = [
            'clients'           => Client::count(),
            'contracts'         => Contract::count(),
            'pallets'           => Table::count(),
            'storeItems'        => StoreItem::count(),
            'storeBox'          => StoreBox::count(),
        ];
        return view ('admin.home.index', $vars);
    }

    public function log() {

        $log = Log::select('log.*', 'admins.userName as admin')
        ->join('admins', 'admins.id', '=', 'log.created_by')
        ->orderBy('created_at', 'ASC')
        ->paginate(25);
        return view ('admin.home.log', ['log'=>$log]);
    }

    
}
