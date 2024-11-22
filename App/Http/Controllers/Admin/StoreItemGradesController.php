<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\StoreItemGrade;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class StoreItemGradesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $grades = StoreItemGrade::all();
        return view ('admin.store.items.grades.home', ['grades'=>$grades]);
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
        try {
            StoreItemGrade::create ([
                'name'          =>$req->name,
                'short'         =>$req->short,
                
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
        
        $category = StoreItemGrade::find($id);
        return view ('admin.store.items.grades.edit', ['item'=>$category]);
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
        $grade = StoreItemGrade::find($id);
        try {
            $grade->update ([
                'name'          =>$req->name,
                'short'         =>$req->short,
                
                'updated_by'    => auth()->user()->id,
            ]);
            return redirect() ->back() ->withSuccess('تمت عملية التحديث بنجاح');

        } catch (QueryException $err) {
            return redirect() ->back() ->withInput()->withError('فشلت عملية التحديث بسبب'.$err);
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

        $grade = StoreItemGrade::find($id);
        try {
                $grade->delete();
            return redirect() ->route('store-items-grades-list') ->withSuccess('تمت عملية الحذف بنجاح');

        } catch (QueryException $err) {
            return redirect() ->back()->withError('فشلت عملية الحذف بسبب'.$err);
        }
    }
}
