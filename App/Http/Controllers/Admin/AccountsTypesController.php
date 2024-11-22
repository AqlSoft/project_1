<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsTypesCreateRequest;
use App\Models\AccountsType;
use Illuminate\Http\Request;

class AccountsTypesController extends Controller
{
    //
    public function index () {
        $types = AccountsType::all();

        $vars = [
            'types'     => $types,
        ];
        return view ('admin.accounts.types.home', $vars);
    }

    public function store (AccountsTypesCreateRequest $req) {
        $type = new AccountsType();
        $type->a_name = $req->a_name;
        $type->e_name = $req->e_name;
        $type->brief = $req->brief;
        $type->company = auth()->user()->company;
        $type->created_by = auth()->user()->id;
        $type->created_at = date('Y-m-d H:i:s');
        if ($type->save()) {
            return redirect()->back()->with(['success' => 'Category has been saved successfully', ]);
        }
    }

    public function update (AccountsTypesCreateRequest $req) {
        $type = AccountsType::where(['id' => $req->id])->first();
        if ($type != null) {
            $type->a_name = $req->a_name;
            $type->e_name = $req->e_name;
            $type->brief = $req->brief;
            $type->company = auth()->user()->company;
            $type->updated_by = auth()->user()->id;
            $type->updated_at = date('Y-m-d H:i:s');
            if ($type->update()) {
                return redirect()->back()->with(['success' => 'Category has been saved successfully', ]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Category not found', ]);
        }

    }
    public function delete ($id) {
        $type = AccountsType::where(['id' => $id])->first();
        if ($type != null) {
            if ($type->delete()) {
                return redirect()->back()->with(['success' => 'Category has been deleted successfully', ]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Category not found', ]);
        }

    }
}
