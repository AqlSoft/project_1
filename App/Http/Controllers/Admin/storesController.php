<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use App\Models\Store;
use Exception;
use Illuminate\Http\Request;

class storesController extends Controller
{
    //
    public function index()
    {
        $stores = Store::all();
        $branches = Branch::all();
        $vars = [
            'stores' => $stores,
            'branches' => $branches,
        ];
        return view('admin.stores.index', $vars);
    }


    public function home()
    {
        return view('admin.stores.home');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            Store::create([
                'name'          => $request->name,
                'address'       => $request->address,
                'brief'         => $request->brief,
                'code'          => $request->store_code,
                'store_id'      => $request->store_id,
                'branch_id'     => $request->branch_id,
                'ismovable'     => $request->ismovable,
                'status'        => $request->status !== null ? $request->status : 0,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id,

            ]);
            return redirect()->back()->withSuccess('Saves Successfully');
        } catch (Exception $err) {
            return redirect()->back()->withError('Failed to save, due to: ' . $err);
        }
    }
}
