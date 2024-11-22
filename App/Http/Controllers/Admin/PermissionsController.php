<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\RolePermission;
use App\Models\Permission;
use App\Models\Menu;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class PermissionsController extends Controller
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
        $nonRoots = Menu::nonRoots();
        $permissions =  Permission::where([])->with('menu')->get();
        
        $vars = [
            'roots'             => $roots,
            'permissions'       => $permissions,
            'menues'            => $nonRoots,
        ];
        return view('admin.permissions.home', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($mm, $sm)
    {
        //
        $menues = Menu::all();
        
        $vars = [
            'menues'            => $menues,
        ];

        return view('admin.settings.permissions.create', $vars);
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
            Permission::create([
                'name'              => $request->name,
                'display_name_ar'   => $request->display_name_ar,
                'display_name_en'   => $request->display_name_en,
                'menu_id'           => $request->menu_id,
                'brief'             => $request->brief,

                'created_by' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Permission has been Created successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Permission Creation failed due to: ' . $e);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function getActionsOf(Request $req)
    {
        //
        $actions = Permission::where(['submenu_id' => $req->id])->get();


        foreach ($actions as $pi => $action) {
            $ra = RolePermission::where(['rule_id' => $req->rule_id, 'permission_id' => $action->id])->first();

            $action->inActions = $ra != null ? true : false;
        }
        return $actions;
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
        $permission = Permission::find($id);
        $menues = Menu::where('parent', '!=', 1)->with('parent_menu')->get();
        $vars = [
            'permission' => $permission,
            'menues'            => $menues,
        ];


        return view('admin.permissions.edit', $vars);
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
        $p = Permission::find($request->id);
        try {
            $p->update([
                'name'              => $request->name,
                'display_name_ar'   => $request->display_name_ar,
                'display_name_en'   => $request->display_name_en,
                'menu_id'           => $request->menu_id,
                'brief'             => $request->brief,

                'updated_by' => auth()->user()->id,
            ]);
            return redirect()->back()->with('success', 'Permission has been Updated successfully.');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->with('error', 'Permission Update Process failed due to: ' . $e);
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
        if (Permission::find($id)->delete()) {
            return redirect()->back()->with(['success' => 'تم حذف القائمة بنجاح']);
        }
        return redirect()->back()->with(['error' => 'خطأ فى حذف القائمة']);
    }
}
