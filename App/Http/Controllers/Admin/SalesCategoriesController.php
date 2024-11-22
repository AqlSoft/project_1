<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use Illuminate\Http\Request;
use App\Models\SalesCategory;
use App\Http\Requests\SalesCategoryCreateRequest;
use App\Http\Requests\SalesCategoryUpdateRequest;
define('PAGES', 10);
class SalesCategoriesController extends Controller
{
    //

    
    public function index () {

        $cats = SalesCategory::where([])->orderBy('id', 'desc')->paginate(PAGES);
        $allAdmins = Admin::all();$admins = [];
        foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
        return view('admin.sales.categories.index', ['cats' => $cats, 'admins' => $admins]);
    }

    public function home () {

        $cats = SalesCategory::where([])->orderBy('id', 'desc')->paginate(PAGES);
        $allAdmins = Admin::all();$admins = [];
        foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
        return view('admin.sales.categories.index', ['cats' => $cats, 'admins' => $admins]);
    }

    public function create () {
        return view('admin.Sales.categories.create');
    }


    public function store (SalesCategoryCreateRequest $req) {
        $nameInUse = SalesCategory::where(['name' => $req->name])->get()->first();
        if($nameInUse) {
            return redirect()->back()->withError('Category Name is in use');
        } else {
            $cat = new SalesCategory();
            $cat->name         = $req->name;
            $cat->created_by   = auth()->user()->id;
            $cat->created_at   = date('Y-m-d H:i:s');
            $cat->company      = auth()->user()->company;
            $cat->status       = 0;
            if ($cat->save()) {
                return redirect()->route('sales.cats.home')->withSuccess('Category Saved Successfuly');
            }
        }
    }

    public function edit ($id) {
        $the_id = intval($id);
        if (is_int($the_id)) {
            $cat = SalesCategory::where(['id' => $the_id])->get()->first();
            $allAdmins = Admin::all();$admins = [];
            foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
            return view('admin.sales.categories.edit', ['cat' => $cat]);
        } else {
            //return redirect()->back()->withErrors('Bad Request.');
        }
    }

    public function update ($id, SalesCategoryUpdateRequest $req) {
        $the_id = intval($id);
        if (is_int($the_id)) {
            $cat = SalesCategory::where(['id' => $the_id])->get()->first();
            $nameInUse = SalesCategory::where(['name' => $req->name])->where('id', '!=', $the_id)->get()->first();
            if (!$nameInUse) {
                $cat->name = $req->name;
            }
            $cat->updated_by = auth()->user()->id;
            $cat->updated_at = date('Y-m-d H:i:s');
            if ($cat->update()) {
                return redirect()->route('sales.cats.edit', $cat->id)->withSuccess('Updated Successfuly');
            }
        } else {
            //return redirect()->back()->withErrors('Bad Request.');
        }
    }

    public function destroy ($id) {
        $the_id = intval($id);
        if (is_int($the_id)) {
            $cat = SalesCategory::where(['id' => $the_id])->get()->first();
            if ($cat->destroy()) {
                return redirect()->route('sales.cats.home')->withSuccess('Category Deleted Successfuly');
            }
        } else {
            return redirect()->back()->withErrors('Bad Request.');
        }
    }
}
