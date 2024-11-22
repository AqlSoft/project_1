<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AccountsCategoryCreateRequest;
use App\Models\AccountsCategory;
use Illuminate\Http\Request;


class AccountsCategoriesController extends Controller
{
    //

    public function index () {
        $categories = AccountsCategory::where([])->orderBy('id', 'ASC')->paginate(10);

        $vars = [
            'cats'     => $categories,
        ];
        return view ('admin.accounts.categories.home', $vars);
    }

    public function store (AccountsCategoryCreateRequest $req) {
        $cat = new AccountsCategory();
        $cat->a_name = $req->a_name;
        $cat->e_name = $req->e_name;
        $cat->brief = $req->brief;
        $cat->company = auth()->user()->company;
        $cat->created_by = auth()->user()->id;
        $cat->created_at = date('Y-m-d H:i:s');
        if ($cat->save()) {
            return redirect()->back()->with(['success' => 'Category has been saved successfully', ]);
        }
    }

    public function update (AccountsCategoryCreateRequest $req) {
        $cat = AccountsCategory::where(['id' => $req->id])->first();
        if ($cat != null) {
            $cat->a_name = $req->a_name;
            $cat->e_name = $req->e_name;
            $cat->brief = $req->brief;
            $cat->company = auth()->user()->company;
            $cat->updated_by = auth()->user()->id;
            $cat->updated_at = date('Y-m-d H:i:s');
            if ($cat->update()) {
                return redirect()->back()->with(['success' => 'Category has been saved successfully', ]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Category not found', ]);
        }

    }
    public function delete ($id) {
        $cat = AccountsCategory::where(['id' => $id])->first();
        if ($cat != null) {
            if ($cat->delete()) {
                return redirect()->back()->with(['success' => 'Category has been deleted successfully', ]);
            }
        } else {
            return redirect()->back()->with(['error' => 'Category not found', ]);
        }

    }
}
