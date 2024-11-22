<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\ItemsCategory;
use App\Models\Account;
use App\Models\Country;
use App\Models\Driver;
use App\Models\Truck;

use Illuminate\Http\Request;

!defined('PAGES') ? define('PAGES', 10) : null;
class DriversController extends Controller
{

    public function index () {
        $drivers = Driver::where([])
        ->orderBy('a_name', 'ASC')->paginate(20);
        
        $vars = [
            'drivers' => $drivers
        ];
        return view ('admin.drivers.home', $vars);
    }

    public function create () {
        $vars = [
            'contries' => Country::all(),
            'trucks' => Truck::all(),
        ];

        return view('admin.drivers.create', $vars);

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
        if ($req->a_name ) {
            $driver = Driver::create([
                'id'                => uniqid(),
                'a_name'            => $req->a_name,
                'e_name'            => $req->e_name,
                'car_type'          => $req->car_type,
                'nationality'       => $req->nationality, 
                'iqama'             => $req->iqama,
                'phone_number'      => $req->phone_number,
                'car_panel'         => $req->car_panel,
                'car_model'         => $req->car_model,
                'created_by'        => auth()->user()->id,
            ]);
            try {
                $driver->save();
                return redirect()->back()->withInput()->withSuccess('ابسط يا سيدى ضفت سواق');
            } catch (Exception $e) {
                return redirect()->back()->withInput()->withError('مش قادرين نضيف سواق جديد' . $e);
            }
        }
    }

    public function edit( $id) {
        $vars = [
            'driver' => Driver::find($id),
            'contries' => Country::all(),
            'trucks' => Truck::all(),
        ];

        return view('admin.drivers.edit', $vars);
        
    }

    public function update(Request $req) {
        
        $data = [
            'a_name'            => $req->a_name,
            'e_name'            => $req->e_name,
            'car_type'          => $req->car_type,
            'nationality'       => $req->nationality, 
            'iqama'             => $req->iqama,
            'phone_number'      => $req->phone_number,
            'car_panel'         => $req->car_panel,
            'car_model'         => $req->car_model,
            'updated_by'        => auth()->user()->id,
        ];
        $driver = Driver::edit($req->id, $data);
        try {
            $driver->update();
            return redirect()->back()->withInput()->withSuccess('ابسط يا سيدى عدلت بيانات السواق');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withError('مش قادرين نعدل بيانات السواق' . $e);
        }
    }

    public function destroy( $id) {
        $driver = Driver::find($id);
        try {
            $driver->delete();
            return redirect()->back()->withInput()->withSuccess('ابسط يا سيدى حذفت السواق');
        } catch (Exception $e) {
            return redirect()->back()->withInput()->withError('مش قادرين نحذف السواق' . $e);
        }
    }
}
