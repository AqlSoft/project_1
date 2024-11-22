<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;

use App\Models\Service;

class SalesController extends Controller
{
    //

    public function index () {
        return view('admin.Sales.index');
    }

    public function create () {
        return view('admin.Sales.index');
    }

    public function services () {
        $services = Service::where([])->orderBy('id', 'asc')->paginate(15);
        $vars = [
            'services' => $services
        ];
        return view('admin.sales.services.index', $vars);
    }

    public function createService () {
        
        return view('admin.sales.services.create');
    }
    
    public function storeService (Request $req) {
        $service = new Service();

        $service->name=$req->name;
        $service->brief=$req->brief;
        $service->price=0;
        $service->company=auth()->user()->company;
        $service->created_by=auth()->user()->id;
        $service->created_at=date('Y-m-d H:i:s');

        if($service->save()) {
            return redirect()->back()->withSuccess('تم تسجيل خدمة جديدة بنجاح');
        }
        
    }


}
