<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Http\Controllers\Controller;
use App\Models\Admin;
use App\Models\Menu;
use App\Models\Permission;
use App\Models\RolePermission;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;

class RolesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
        $roles = Role::where([])->orderBy('id', 'ASC')->paginate(10);
        $vars = [
            'roles' => $roles,
        ];
        return view('admin.roles.home', $vars);
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
    public function store(Request $request)
    {
        //
        try {
            Role::create([
                'name'              =>  $request->name,
                'display_name_ar'   =>  $request->display_name_ar,
                'display_name_en'   =>  $request->display_name_en,
                'brief'             =>  $request->brief,
                'updated_by'        =>  auth()->user()->id,
                'updated_at'        =>  date('Y-m-d H:i:s'),
                'status'            =>  true,
                'created_at'        =>  date('Y-m-d H:i:s'),
                'updated_at'        =>  date('Y-m-d H:i:s'),
                'status'            =>  true,

            ]);
            
            return redirect()->back()->with(['success' => 'تمت إضافة دور بنجاح']);
           
        } catch (QueryException $err) {
            return redirect()->back()->withInput()->with(['error' => 'فشلت عملية الأضافة بسبب: ' . $err . '.']);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        //
        $role = Role::find($request->id);
        try {
            $role->update([
                'name'              =>  $request->name,
                'display_name_ar'   =>  $request->display_name_ar,
                'display_name_en'   =>  $request->display_name_en,
                'brief'             =>  $request->brief,
                'updated_by'        =>  auth()->user()->id,
                'updated_at'        =>  date('Y-m-d H:i:s'),

            ]);
            
            return redirect()->back()->with(['success' => 'تمت عملية تحديث بيانات الدور بنجاح.']);
           
        } catch (QueryException $err) {
            return redirect()->back()->withInput()->with(['error' => 'فشلت عملية تحديث البيانات بسبب: ' . $err . '.']);
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
        $permissions = Permission::all();
        $subMenues = Menu::where('parent', '>', 0)->get();
        $menues = Menu::where(['parent' => 0])->with('subMenues')->get();
        $role = Role::where('id', $id)->with('admins')->first();
        $role->permissions = $role->permissions()->get();
        $vars = [
            'role'          => $role,
            'roots'         => $menues,
            'menues'        => $menues,
            'subMenues'     => $subMenues,
            'permissions'   => $permissions,
            'admins'        => Admin::where([])->with('profile')->get()
        ];
        return  view('admin.roles.edit', $vars);
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function permissions($id)
    {
        $permissions = Permission::all();
        $menues = Menu::where(['parent'=>  1])->where('id', '>', 1)->with('subMenues')->get();
        $role = Role::where('id', $id)->with('admins')->first();
        $role->permissions = $role->permissions()->get();
        $vars = [
            'role' => $role,
            'permissions' => $permissions,
            'menues' => $menues,
            'admins' => Admin::where([])->with('profile')->get(),
        ];
        return  view('admin.roles.permissions', $vars);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function attachPermissions(Request $req, $role_id)
    {
        if (!empty($req->permissions)) {

            foreach ($req->permissions as $key => $p_id) {
                try {
                    RolePermission::create([
                        'role_id'           =>  $role_id,
                        'permission_id'     =>  $p_id,
                        'created_by'        =>  auth()->user()->id,
                    ]);
                } catch (QueryException $err) {
                    return redirect()->back()->withInput()->with(['error' => 'فشلت عملية الإضافة بسبب: ' . $err . ' ']);
                }
            }
            return redirect()->back()->with(['success' => 'تمت إضافة الصلاحية للدور بنجاح.']);
        }
        return redirect()->back()->with(['error' => 'انت لم تقد باختيار شىء جديد.']);
    }

    /**
     * Delete the specified resource in storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dettachPermission($id)
    {
        $rp = RolePermission::find($id);
        return $rp;
        if ($rp->delete()) {
            return redirect()->back()->with(['success' => 'Permission has been removed from role permissions list successfully.']);
        }
        return redirect()->back()->with(['error' => 'Error Deleting Role Permission']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        if (Role::find($id)->delete()) {
            return redirect()->back()->with(['success' => 'Role has been removed successfully.']);
        }
        return redirect()->back()->with(['error' => 'Error Deleting Role']);
    }
}
