<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Item;
use App\Models\ItemsCategory;
use App\Models\MeasuringUnit;
use Illuminate\Http\Request;
!defined('PAGES') ? define('PAGES', 4) : null;
class ItemsController extends Controller
{
    //
    public function home () {
        $items = Item::where([])->orderBy('id', 'ASC')->paginate(PAGES);
        $vars = [
            'items' => $items
            ];
        return view('admin.items.home', $vars);
    }
    public function settings () {
        $items = Item::where([])->orderBy('id', 'ASC')->paginate(PAGES);
        $vars = [
            'items' => $items
        ];
        return view('admin.items.home', $vars);
    }

    public function create () {

        $cats = ItemsCategory::where(['level'=>3])->get();
        $mu = MeasuringUnit::all();

        foreach ($cats as $in => $cat) {
            $cat->_parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $itemsCats = new ItemsCategory();

        $vars = [

            'mu'        => $mu,
            'cats'      => $cats,
        ];
        return view('admin.items.create', $vars);
    }

    public function store (Request $req) {
        $item = Item::createNewInstance($req);
        $msg = '';
        if ($req->hasFile('image')) {
            $fileHandler = $req->image;
            $newName = 'item_image_' . date('_Ymd_Hsi') . '.' . $req->image->extension();
            $fileHandler->storeAs('assets/admin/uploads/items', $newName);
            $item->image = $newName;
            $msg = 'new file has been uploaded.';
        } else {
            $item->image = 'no_product_image.jpeg';
            $msg='no files has benn uploaded';
        }
        if ($item->save()) {
            return redirect()->route('items.home')->with(['success' => 'New Item has been issued successfully, and '.$msg]);
        }

    }

    public function edit () {

        $cats = ItemsCategory::where(['level'=>3])->get();
        $mu = MeasuringUnit::all();

        foreach ($cats as $in => $cat) {
            $cat->_parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $itemsCats = new ItemsCategory();

        $vars = [

            'mu'        => $mu,
            'cats'      => $cats,
        ];
        return view('admin.items.edit', $vars);
    }

    public function setting () {
        return view('admin.items.setting');
    }

    public function measuringUnitsHome () {
        $mus = MeasuringUnit::all();
        $vars['master_units'] = $mus;
        return view('admin.items.mu.home', $vars);
    }

    public function measuringUnitsCreate () {
        $master_units = MeasuringUnit::all();
        $vars['master_units'] = $master_units;
        return view('admin.items.mu.create', $vars);
    }

    public function measuringUnitsEdit ($id) {
        $mu = MeasuringUnit::where(['id' => $id])->first();
        $vars['mu'] = $mu;
        return view('admin.items.mu.edit', $vars);
    }

    public function measuringUnitsDelete ($id) {
        $the_id = intval($id);
        $mu = MeasuringUnit::where(['id' => $the_id])->first();

        if ($mu->delete()) {
            return redirect()->route('items.mu.home')->with(['success' => 'New measuring unit has been deleted successfully.']);
        }
    }

    public function measuringUnitsInsert (Request $req) {
        $mu = new MeasuringUnit();
        var_dump($req->a_name);
        $exist = MeasuringUnit::where(['a_name' => $req->a_name])->orWhere(['e_name' => $req->e_name,])->first();
        if (!$exist) {
            $mu->a_name = $req->a_name;
            $mu->e_name = $req->e_name;
            $mu->is_master = $req->is_master;
            $mu->a_label = $req->a_label;
            $mu->e_label = $req->e_label;
            $mu->company = auth()->user()->company;
            $mu->created_by = auth()->user()->id;
            $mu->created_at = date('Y-m-d H:i:s');
            var_dump($mu);
            if ($mu->save()) {
                return redirect()->route('items.mu.home')->with(['success' => 'New measuring unit has been added successfully.']);
            }
        }
        return redirect()->back()->with(['error' => 'Error Saving Unit']);
    }

    public function measuringUnitsUpdate (Request $req) {
        $the_id = intval($req->id);

        $mu = MeasuringUnit::where(['id' => $the_id])->first();
        if ($mu) {
            $mu->a_name = $req->a_name;
            $mu->e_name = $req->e_name;
            $mu->is_master = $req->is_master;
            $mu->a_label = $req->a_label;
            $mu->e_label = $req->e_label;
            $mu->company = auth()->user()->company;
            $mu->updated_by = auth()->user()->id;
            $mu->updated_at = date('Y-m-d H:i:s');

            if ($mu->save()) {
                return redirect()->route('items.mu.home')->with(['success' => 'New measuring unit info has been updated successfully.']);
            }
        }
        return redirect()->back()->with(['error' => 'Error Saving Unit']);
    }

    public function createItemCat ($parent = null) {
        $cats = ItemsCategory::where('id','>',1)->get();
        foreach ($cats as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $rootCats = ItemsCategory::where('level' ,1)->get();
        foreach ($rootCats as $in => $rCat) {
            $rCat->cats = ItemsCategory::where(['parent_cat' => $rCat->id])->get();
            foreach ($rCat->cats as $im => $cat) {
                $cat->children = ItemsCategory::where(['parent_cat' => $cat->id])->get();
            }
        }
        $vars = [
            'roots'     => $rootCats,
            'parent'    => $parent,
            'cats'      => $cats
        ];
        return view('admin.items.cats.create', $vars);
    }
    public function itemCatHome () {
        $cats = ItemsCategory::where('id','>',1)->get();
        foreach ($cats as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $rootCats = ItemsCategory::where('level' ,1)->get();
        foreach ($rootCats as $in => $rCat) {
            $rCat->cats = ItemsCategory::where(['parent_cat' => $rCat->id])->get();
            foreach ($rCat->cats as $im => $cat) {
                $cat->children = ItemsCategory::where(['parent_cat' => $cat->id])->get();
            }
        }
        $vars = [
            'roots'     => $rootCats,
            'cats'      => $cats
        ];
        return view('admin.items.cats.home', $vars);
    }
    public function itemCatEdit ($id)
    {
        $ic = ItemsCategory::where('id', $id)->first();
        $cats = ItemsCategory::where('id', '>', 1)->get();
        foreach ($cats as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $vars = [
            'cat' => $ic,
            'cats' => $cats
        ];
        return view('admin.items.cats.edit', $vars);
    }

    public function itemCatView ($id) {
        $ic = ItemsCategory::where('id', $id)->first();
            $ic->parent = ItemsCategory::where(['id' => $ic->parent_cat])->first();
        switch ($ic->level) {
            case $ic->level <= 2:
                $ic->children = ItemsCategory::where(['parent_cat' => $ic->id])->get();
                break;
            case 3:
                $ic->children = Item::where(['parent_cat' => $ic->id])->get();
                break;
            default:
                return redirect()->back()->with(['error' => 'Something went wrong']);
        }
        $cats = ItemsCategory::where('id','>',1)->get();
        foreach ($cats as $in => $cat) {
            $cat->parent = ItemsCategory::where(['id' => $cat->parent_cat])->first();
        }
        $vars = [
            'cat' => $ic,
            'cats' => $cats
        ];
        return view('admin.items.cats.view', $vars);
    }
    public function itemCatStore (Request $req) {
        $ic = new ItemsCategory();
        $ic->a_name         = $req->a_name;
        $ic->e_name         = $req->e_name;
        $ic->brief          = $req->brief;
        $ic->code           = $req->code;
        $ic->parent_cat     = explode('|', $req->parent_cat)[1];
        $ic->level          = explode('|', $req->parent_cat)[0] + 1;
        $ic->company        = auth()->user()->company;
        $ic->created_by     = auth()->user()->id;
        $ic->created_at     = date('Y-m-d H:i:s');
        if ($ic->save()) {
            return redirect()->route('items.cats.home')->with('success', 'New category has been added successfully.');
        }
    }
    public function itemCatUpdate (Request $req ) {
        $ic = ItemsCategory::where('id', $req->id)->first();
        $ic->a_name = $req->a_name;
        $ic->e_name = $req->e_name;
        $ic->brief = $req->brief;
        $ic->code = $req->code;
        $ic->parent_cat = explode('|', $req->parent_cat)[1];
        $ic->level = explode('|', $req->parent_cat)[0] + 1;

        $ic->updated_by = auth()->user()->id;
        $ic->updated_at = date('Y-m-d H:i:s');
        if ($ic->update()) {
            return redirect()->route('items.cats.view', $ic->id)->with('success', 'Category info has been updated successfully.');
        }
    }
    public function itemCatDelete ($id ) {
        $ic = ItemsCategory::where('id', $id)->first();
        if(!$ic) {
            return redirect()->back()->with('error', 'error Deleting Category.');
        }
        if ($ic->delete()) {
            return redirect()->back()->with('success', 'Category info has been removed successfully.');
        }
    }


}
