<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AdminRolePermission;

use App\Models\AdminRole;
use App\Models\Permission;
use App\Models\Menu;
use App\Models\SubMenu;
use App\Models\Role;
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
         $user = auth()->user();

         $vars = [
            'user' => $user,
            'roles'=>Role::all()
        ];
        
         return view ('admin.admindashboard.admins.roles.index', $vars);
     }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
     public function nonactive()
     {
         //
         $user = auth()->user();

         $vars = [
            'user' => $user,
            'roles'=>Role::where('status', '!=' , 1)->get()
        ];
         return view ('admin.admindashboard.admins.roles.nonactive', $vars);
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create() 
     {
         //
 
         $vars = [
             'user' => auth()->user(),
         ];
         return view ('admin.settings.roles.create', $vars);
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
        function nameIsExist ($condition, $model)
        {
            return $model::where($condition)->first();
        }
        return nameIsExist(['name'=>$request->name]);
        $role = new Role ();
        $role->name                 =  $request->name;
        $role->display_name_ar      =  $request-> display_name_ar;
        $role->display_name_en      =  $request-> display_name_en;
        $role->created_at           =  date('Y-m-d H:i:s');;
        $role->status               =  true;
        $role->created_by           =  auth()-> user() -> id;
        if ($role->save()) {
            return redirect()->back()->with(['success' => 'تم الحفظ بنجاح :)']);
        } return redirect()->back()->with(['error' => 'حدث خطأ أثناء الحفظ']);
     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function view($id)
     {
        $role = Role::find($id);
        $role->permissions = AdminRolePermission::where(['role_id'=>$id])->get();
         //
         $vars = [
            'user' => auth()->user(),
            'role' => $role,   
        ];
        return view ('admin.users.roles.view', $vars);
     }

     /**
      * @return [type]
      */
     public function rolesPermissions() {
        $user = auth()->user();
        $user->roles = AdminRole::where(['user_id'=>$user->id])->get();
        $user->permissions = [];
        $user->getPermissions();
        //return $user->permissions; 
        
        $permissions = Permission::all();
        $roles = Role::all();
        $menues = Menu::all();
        foreach($menues as $menu){
            $menu->permissions = Permission::where('menu_id', $menu->id)->get();
        }
        $vars=[
            'user'=>$user,
            'roles'=> $roles,
            'menues' => $menues,
            'permissions'=>$permissions
        ];
        return view ('admin.admindashboard.admins.roles.permissions', $vars);
     }
 
  
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function addActions($id)
     {
        //
        $role = Role::find ($id);
        $menues = Menu::all();
        foreach($menues as $mi => $menu) {
            $menu->subMenues = SubMenu::where(['main_menu'=> $menu->id]);
        }
        $vars = [
           'menues' => $menues,
           'role' => $role,
        ];
        return view ('admin.settings.roles.addActions', $vars);
     }
 
     /**
      * Display the specified resource.
      *
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */
     public function storeActions(Request $req)
     {
        //
        $role = Role::find ($req->id);
        $roleActions = RolePermission::where(['role_id' => $req->id, 'submenu'=> $req->submenu])->get();
  
        $roleActionsArr = [];
        foreach ($roleActions as $n => $ra) {
            $roleActionsArr[]=$ra->permission_id;
        }
        
        $selectedActions = $req->action;
        $actionsToBeDeleted = $selectedActions == null ? $roleActionsArr : array_diff($roleActionsArr, $selectedActions);
        //$action_1 = RolePermission::where(['role_id' => $req->id, 'permission_id' => $action_id])->first();
        if (count($actionsToBeDeleted)) {
            foreach ($actionsToBeDeleted as $action_id) {
                RolePermission::where(['role_id' => $req->id, 'permission_id' => $action_id])->first()->delete();
            } 
        }
        
        if ($selectedActions!=null) {
            foreach ($selectedActions as $action_id) {
                $exAction = RolePermission::where(['role_id' => $req->id, 'permission_id' => $action_id])->first();
                if ($exAction) {
                    continue;
                } else {
                    $ra = new RolePermission();
                    $ra->role_id            = $req->id;
                    $permission             = Permission::find($action_id);
                    $ra->permission_id      = $action_id;
                    $ra->menu               = $permission->menu_id;
                    $ra->submenu            = $permission->submenu_id ;
                    
                    $ra->created_by = auth()->user()->id;
                    $ra->created_at = date('Y-m-d H:i:s');
                    $ra->save();
                }
                
            }
        }

        //var_dump($roleActionsArr, $selectedActions, $actionsToBeDeleted);
        //
        return redirect () ->back()->with (['success' => 'تم تحديث بيانات الدور بنجاح']);
        
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
         $role = Role::find ($id);
         $vars = [
            'role' => $role ,
            'user' => auth()->user(),
         ];
         return view ('admin.admindashboard.admins.roles.edit', $vars);
     }

     /**
      * Add one or more main menues to the role according to id.
      *
      * @param  \Illuminate\Http\Request  $request
      * @param  int  $id
      * @return \Illuminate\Http\Response
      */

    public function assignRoleToAdmin(Request $req) {

        $roleMenu = new RoleMenu();
        $roleMenu->role_id  =$req->role_id;
        $roleMenu->menu_id  =$req->menu_id;
        
        $roleMenu->company  =auth()->user()->company;
        $roleMenu->created_by  =auth()->user()->id;
        $roleMenu->created_at  =date('Y-m-d H:i:s');

        if ( $roleMenu->save() ) {
            return redirect()->back()->with(['success' => 'تمت إضافة القائمة إلى الدور بنجاح :)']);
        }   return redirect()->back()->with(['error' => 'حدث خطأ أثناء الحفظ']);
    }

    /**
    * @return [type]
    */
    public function ajaxRolePermissions(Request $req) {
        $aj_role = Role::find($req->id);
        
        // $role->roleName = Role::find($role->role_id);
        //$role->name = Role::find($role->role_id)->name;
        $aj_roles = Role::all();
        $aj_menues = Menu::all();
        $aj_role->getPermissions ();


        foreach($aj_menues as $menu){
            $menu->permissions = Permission::where('menu_id', $menu->id)->get();
        }
        
        $permissions = Permission::all();
        $vars = [
            'aj_role'=> $aj_role,
            'aj_roles'=> $aj_roles,
            'aj_menues' => $aj_menues,
            'permissions'=>$permissions
        ];
        return view ('admin.admindashboard.admins.roles.ajPermissions', $vars);
    }

 
    /**
     * Add one or more main menues to the role according to id.
    *
    * @param  \Illuminate\Http\Request  $request
    * @param  int  $id
    * @return \Illuminate\Http\Response
    */

    public function assignPermissionsToRole(Request $req) {
        $role = Role::find($req->role_id);
        $permissionsFromClient  = $req->permissions;
        $user = auth()->user()->id;
        //return (null==$req->permissions || null == $role)
        if (null == $role) {
            return redirect()->back()->withError('Role Error');
        }

        $role->getPermissions();
        
        $permissionsFromDB      = $role->getPermissionsArray();
        $permissionsToSave      = null == $permissionsFromDB ? $permissionsFromClient : array_diff($permissionsFromClient, $permissionsFromDB);
        
        $permissionsToDelete    = null == $permissionsFromDB ? [] : array_diff($permissionsFromDB, $permissionsFromClient);
        
        // return ['fromClient'=>$permissionsFromClient, 'fromDB'=>$permissionsFromDB, 'toSave'=>$permissionsToSave, 'toDel'=>$permissionsToDelete];
        if (!empty($permissionsToSave)) {
            foreach ($permissionsToSave as $pts) {
                
                if (null==AdminRolePermission::where(['role_id'=>$req->role_id, 'permission_id'=>$pts])->first()) {
                    AdminRolePermission::create([
                        'role_id'=>$role->id,
                        'permission_id'=>$pts,
                        'created_by'=>$user
                    ]);
                } else {continue;}
            } 
        } 
        if (!empty($permissionsToDelete)) {
            foreach ($permissionsToDelete as $i => $p) {
                $ptd = AdminRolePermission::where(['role_id'=>$req->role_id, 'permission_id'=>$p])->first();
                if (null != $ptd) {
                    $ptd->delete();
                }
            }
        }
        if (empty($permissionsToSave) && empty($permissionsToDelete)) {
            return redirect()->back()->withError('لم تقم بـ أى تغيير');
        }

        return redirect()->back()->withSuccess('تم تحديث صلاحيات الدور بنجاح');
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
        $role = Role::find ($request->id);
        if (!$role) {
        return redirect()->back()->with(['error' => 'الدور الذى تحاول تعديله غير موجود، تأكد من أنك تمتلك كافة الصلاحيات لهذا العمل']);
        }
        
        $role->name          =  $request->name;
        $role->display_name_ar          =  $request->display_name_ar;
        $role->display_name_en          =  $request->display_name_en;
        $role->brief           =  $request->brief;
        $role->updated_by      =  auth()-> user() -> id;
        
        $role->created_at      =  date('Y-m-d H:i:s');;
        $role->status          =  $request->status != null ? true : false;
        if ($role->update()) {
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح :)']);
        } return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث البيانات']);
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
        if (Role::find($id)->delete()) {
        return redirect()->back()->with(['success'=>'تم حذف الدور بنجاح']);
        }
    }
}
