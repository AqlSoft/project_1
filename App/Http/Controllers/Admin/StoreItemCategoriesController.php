<?php

namespace App\Http\Controllers\Admin;



use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Models\StoreItemCategory;
use Illuminate\Database\QueryException;

class StoreItemCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //C:\wamp64\www\cpanel.new\resources\views\admin\store\items\categories\home.blade.php
        $parents = StoreItemCategory::where('parent_id', 10)->get();
        $categories = StoreItemCategory::parents()->with('children')->paginate(12);
        return view ('admin.store.items.categories.home', ['categories'=>$categories, 'parents'=>$parents]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
        //

        try {
            StoreItemCategory::create ([
                'name'          =>$req->name,
                'parent_id'     =>$req->parent,
                'brief'         =>$req->brief,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id,
            ]);
            return redirect() ->back() ->withSuccess('تمت عملية الإضافة بنجاح');

        } catch (QueryException $err) {
            return redirect() ->back() ->withInput()->withError('فشلت عملية الإضافة'.$err);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //C:\wamp64\www\cpanel.new\resources\views\admin\store\items\categories\home.blade.php
        $categories = StoreItemCategory::parents()->with('children')->get();
        $category = StoreItemCategory::find($id);
        $category->parent();
        return view ('admin.store.items.categories.edit', ['item'=>$category, 'categories'=>$categories]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $req, $id)
    {
        $category = StoreItemCategory::find($id);
        try {
            $category->update ([
                'name'          =>$req->name,
                'parent_id'     =>$req->parent,
                'brief'         =>$req->brief,
                'updated_by'    => auth()->user()->id,
            ]);
            return redirect() ->back() ->withSuccess('تمت عملية التحديث بنجاح');

        } catch (QueryException $err) {
            return redirect() ->back() ->withInput()->withError('فشلت عملية التحديث بسبب: '.$err);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
