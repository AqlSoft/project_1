<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Treasury;
use Illuminate\Http\Request;
use App\Models\MoneyPassRule;
use App\Http\Requests\AddMprRequest;
use App\Http\Requests\TreasuriesCreateRequest;
use App\Http\Requests\TreasuriesUpdateRequest;

define('PAGES', 10);

class TreasuriesController extends Controller
{
    //

    public function test () {
        $masterTreasury = Treasury::where(['parent' => 0])->get()->first();
        $masterTreasury->children = Treasury::getChildren($masterTreasury->id);
        foreach($masterTreasury->children as $id => $child) {
            $child->children = Treasury::getChildren($id);
        }
        return view('/admin/treasuries/test', ['master' => $masterTreasury]);

    }

    public function index ()
    {
        $treasuries = Treasury::where([])->orderBy('id', 'ASC')->paginate(PAGES);
        $allAdmins = Admin::all();
        $admins = [];
        foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
        return view('admin.treasuries.index', ['treasuries' => $treasuries, 'admins' => $admins]);
    }

    public function create () {
        // Admins
        $allAdmins = Admin::all(); $admins = [];
        foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
        // Treasuries
        $allTreasuries = Treasury::where('parent', '!=', 0)->get(); $treasuries = [];
        foreach($allTreasuries as $x => $t){$treasuries[$t->id] = $t->name;}
        return view('admin.treasuries.create', ['admins'=>$admins, 'treasuries' => $treasuries]);
    }

    public function store (TreasuriesCreateRequest $req)
    {

        if(Treasury::where('name', $req->name)->first() == false){
            $treasury = new Treasury();
            $treasury->name         = $req->name;
            $treasury->type         = $req->type;
            $treasury->cashier      = $req->cashier;
            $treasury->created_by   = auth()->user()->id;
            $treasury->created_at   = date('Y-m-d H:i:s');
            $treasury->company      = auth()->user()->company;
            $treasury->status       = 0;
            $treasury->parent       = !$req->parent ? 0 : $req->parent;

            if($treasury->save()) {
                $masterTreasury = Treasury::where(['type'=> 1])->where(['company'=>$treasury->company])->first()->id;
                $mpr_1 = New MoneyPassRule();
                $mpr_1->treasury_id = $treasury->id;
                $mpr_1->push_to     = $masterTreasury;
                $mpr_1->created_by  = auth()->user()->id;
                $mpr_1->company     = auth()->user()->company;;
                $mpr_1->created_at  = date('Y-m-d H:i:s');
                if($mpr_1->save()) {
                    return redirect()->route('treasuries.view', $treasury->id)->withSuccess('Treasury Saved Seccessfully');
                }
            }
        } return redirect()->back()->withError('Error Saving Treasury');
    }

    public function deleted ($id) {

    }

    public function delete ($id)
    {
        $the_id = intval($id);
        $treasury = Treasury::where(['id'=>$the_id])->where(['company' => auth()->user()->company])->first();
        if ($treasury) {
            if($treasury->delete()) {
                return redirect()->back()->withSuccess('Treasury Deleted from Database.');
            }
        } return redirect()->back()->withError('Treasury Not Found in Database.');
    }

    public function update($id, TreasuriesUpdateRequest $req) {
        $the_id = intval($id);
        $treasury = Treasury::where(['id'=>$the_id])
        ->where(['company' => auth()->user()->company])->first();
        // Check if the new name is exist on this database
        if ($req->name != $treasury->name) {
            $nameInUse = Treasury::where('name', '=', $req->name)
            ->where('company', '=', $treasury->company)
            ->where('id', '!=', $the_id)
            ->first();
            if ($nameInUse) {
                return redirect()->back()->withError('Name already in use');
            }
            $treasury->name         = $treasury->name !== $req->name ? $req->name : $treasury->name;
        }
        if ($req->type === 1) {
            $thereIsMaster = Treasury::where(['type'=> 1])->where(['company'=>$treasury->company])
            ->where('id', '!=', $the_id)->first()->type;
            if ($thereIsMaster) {
                return redirect()->back()->withError('There\'s already a master treasudry');
            }
        }
        $treasury->type = $req->type;
        $treasury->status       = $treasury->status !== $req->status ? $req->status : $treasury->status;
        $treasury->cashier      = $treasury->cashier !== $req->cashier ? $req->cashier : $treasury->cashier;
        $treasury->updated_by   = auth()->user()->id;
        $treasury->updated_at   = date('Y-m-d H:i:s');

        if ($treasury->update()) {
            return redirect()->route('treasuries.view', $id)->withSuccess('Record Updated Successfully');
        } return redirect()->back()->withError('Name already in use');

    }

    public function status($id) {
        if ($id) {
            $the_id = intval($id);
            $company = auth()->user()->company;
            $treasury = Treasury::where(['id'=>$the_id])
            ->where(['company' => $company])->first();
            $treasury->status = 1;
            if ($treasury->update()){
                return redirect()->back()->withSuccess('Treasury Status Updated Successfuly');
            }
        } return redirect()->back()->withErrors('Error, Unknown Treasury!!');
    }

    public function view ($id) {
        if ($id) {
            $the_id = intval($id);
            $company = auth()->user()->company;
            $treasury = Treasury::where(['id'=>$the_id])
            ->where(['company' => $company])->first();
            $rules = MoneyPassRule::where(['treasury_id' => $the_id]);
            // Admins
            $allAdmins = Admin::all(); $admins = [];
            foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
            // Treasuries
            $allTreasuries = Treasury::all(); $treasuries = [];
            foreach($allTreasuries as $x => $t){$treasuries[$t->id] = $t->name;}
            // Push Money Rules
            $treasuriesPushHere = MoneyPassRule::where(['treasury_id' => $the_id])->where(['company' => $treasury->company])->get();
            $thisPushToTreasuries = MoneyPassRule::where(['push_to' => $the_id])->where(['company' => $treasury->company])->get();
            $Rules['pull_from'] = $treasuriesPushHere;
            $Rules['push_to'] = $thisPushToTreasuries;
            // Assign Master Treasury
            $masterTreasury = Treasury::select('id')->where(['type' => 1])->first();
        }
        return view ('admin.treasuries.view', ['treasury' => $treasury, 'admins' => $admins, 'Rules' => $Rules, 'treasuries' => $treasuries, 'masterTreasury' => $masterTreasury]);
    }

    public function addmpr ($id, AddMprRequest $req) {
        if ($req->push_to) {
            $recordExist = MoneyPassRule::where(['push_to' => $req->push_to])->where(['treasury_id' => $id])->first();
            if ($recordExist != null) {
                if ($recordExist->push_to == $req->push_to) {
                    return redirect()->back()->withError('This Treasury is already in (push_to) list.');
                }
            } else {
                $mpr_1 = New MoneyPassRule();
                $mpr_1->treasury_id = $id;
                $mpr_1->push_to     = $req->push_to;
                $mpr_1->created_by  = auth()->user()->id;
                $mpr_1->company     = auth()->user()->company;
                $mpr_1->created_at  = date('Y-m-d H:i:s');
                if($mpr_1->save()) {
                    $mpr_2 = New MoneyPassRule();
                    $mpr_2->treasury_id = $req->push_to;
                    $mpr_2->pull_from   = $id;
                    $mpr_2->created_by  = auth()->user()->id;
                    $mpr_2->company     = auth()->user()->company;
                    $mpr_2->created_at  = date('Y-m-d H:i:s');
                    if ($mpr_2->save()) {
                        $tr = Treasury::where(['id' => $id])->get()->first();
                        var_dump($tr);
                        $tr->updated_by = auth()->user()->id;
                        $tr->updated_at = date('Y-m-d H:i:s');
                        if ($tr->update()) {
                            return redirect()->back()->withSuccess('Money Pass Rule Added Seccessfully');
                        }
                    }
                }
            }
        } return redirect()->back()->withError('Target Treasury must be selected, you sent null value');
    }


    public function remmpr ($id, Request $req) {
        $treasury = MoneyPassRule::where(['id' => $id])->get()->first();
        if($treasury!== null) {
            if ($treasury->delete()) {
                return redirect()->back()->withSuccess('Money Pass Rule deleted Seccessfully');
            }
        } return redirect()->back()->withError('Targeted Treasury not found');
    }

    public function edit($id) {

        if ($id) {
            $the_id = intval($id);
        // Traget Treasury
            $company = auth()->user()->company;
            $treasury = Treasury::where(['id'=>$the_id])
            ->where(['company' => $company])->first();

            // All Admins
            $allAdmins = Admin::all();$admins = [];
            foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}

            // All Treasuries
            $allTreasuries = Treasury::all();$treasuries = [];
            foreach($allTreasuries as $x => $t){$treasuries[$t->id] = $t->name;}

            // All Pass Money Rules
            $allRules = MoneyPassRule::where(['treasury_id' => $the_id])->where(['company' => $treasury->company])->get(); $Rules = [];
            foreach($allRules as $y => $rule) {if ($rule->push_to != null) {$Rules['push_to'][$rule->push_to] = $treasuries[$rule->push_to];} else {$Rules['pull_from'][$rule->pull_from] = $treasuries[$rule->push_to];}}
            return view('admin.treasuries.edit', ['treasury' => $treasury, 'admins' => $admins, 'treasuries' => $treasuries, 'Rules' => $Rules]);
        }
    }

    public function addPushToTreasury (Request $req) {

    }
    public function ajax_search (Request $req) {
        if ($req->ajax()) {
            $ajax_search_query = $req->search;
            //var_dump($ajax_search_query);
            $allAdmins = Admin::all();
            $admins = [];
            foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
            $data = Treasury::where('name', 'LIKE', "%{$ajax_search_query}%")->orderBy('id', 'DESC')->paginate(2);

        }
        return view('admin.treasuries.ajsearch', ['treasuries' => $data, 'admins' => $admins]);
    }
}
