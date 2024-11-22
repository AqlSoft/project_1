<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

//Models
use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class MenuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roots = Menu::roots()->get();
        $menues = Menu::where('id', '!=', 0)->where([])->with('parent_menu')->get();

        return  view('admin.menues.home', ['menues' => $menues, 'roots' => $roots]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Purchaces Inventory Sales Production Operations Reports Settings Help Security
    }

    public function createSubmenu($id)
    {
        $root = Menu::find($id);
        
        return  view('admin.menues.create.submenu', ['root' => $root]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        try {
            Menu::create([
                'label'             => $request->label,
                'parent'           => $request->menu_id,
                'url_name'          => $request->url,
                'icon'              => $request->icon,
                'display_name_ar'   => $request->display_name_ar,
                'display_name_en'   => $request->display_name_en,
                'brief'             => $request->brief,
                'display'           => true,
                'created_by'        => auth()->user()->id
            ]);
            return redirect()->back()->with('success', 'تمت إضافة قائمة جديدة بنجاح.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'فشل فى عملية الإضافة بسبب: ' . $e);
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
        //
        $roots = Menu::roots()->get();
        $menu = Menu::find($id);
        return  view('admin.menues.edit', ['menu' => $menu, 'roots' => $roots]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $menu =  Menu::find($request->id);
        try {
            $menu->update([
                'label'             => $request->label,
                'parent'           => $request->menu_id,
                'url_name'               => $request->url,
                'icon'              => $request->icon,
                'display_name_ar'   => $request->display_name_ar,
                'display_name_en'   => $request->display_name_en,
                'brief'             => $request->brief,
                'updated_by'        => auth()->user()->id
            ]);
            return redirect()->back()->with('success', 'تم تحديث بيانات القائمة بنجاح.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'فشل فى تحديث البيانات بسبب: ' . $e);
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
        return redirect()->back()->with('error', 'القائمة ليست فارغة، جرب إزالة السجلات المرتبطة وحاول مرة أخرى.');
        $menu =  Menu::find($id);
        try {
            $menu->delete();
            return redirect()->back()->with('success', 'تم حذف القائمة والقوائم المرتبطة بها');
        } catch (QueryException $e) {
            return redirect()->back()->with('error', 'فشل فى حذف القائمة بسبب: ' . $e);
        }
    }
}
