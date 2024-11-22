<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper;
use App\Models\User;
use App\Models\Role;
use App\Models\UserRole;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UsersRolesController extends Controller
{

    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected static $professions = [['Application Admin', 'مدير التطبيق'],  ['general manager', 'المدير العام'], ['Financial Manager', 'المدير المالى'], ['Inventory Man', 'أمين المخازن'], ['Accountant', 'المحاسب'], ['Store Man', 'مسئول التخزين'], ['labourer', 'عامل']];
    public function index()
    {
        //
        
        return view ('admin.users.index', $vars);
    }

    public function showBasicInfo ($id) {
        $user = User::find($id);
        $user->profile = UserProfile::where(['userId' => $user->id])->first();
        $user->professions = static::$professions;
        $user->roles = [];

        return view ('admin.users.show.basicInfo', ['user'=>$user]);
    }

    public function showcontactInfo ($id) {
        $user = User::find($id);
        $user->profile = UserProfile::where(['userId' => $user->id])->first();
        $user->professions = static::$professions;
        $user->roles = [];

        return view ('admin.users.show.contactInfo', ['user'=>$user]);
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
            'professions' => static::$professions,
        ];
        return view ('admin.users.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updateUserRoles(Request $req)
    {
        $user = User::find($req->id);
        $user->roles = UserRole::where(['user_id'=>$req->id])->get();
        $rolesToDel = $user->roles;

        //
        $sentRoles = $req->roles;

        $rolesSaved = 0;
        $rolesRemoved = 0;

        try {
            if ($sentRoles > 0)
            foreach ($sentRoles as $role) {
                $nr = new UserRole();
                $nr->user_id       = intval($req->id);
                $nr->role_id       = $role;
                $nr->created_at    = date('Y-m-d H:i:s');
                $nr->created_by    = auth()->user()->id;
                $nr->save();
                $rolesSaved++;
            }
            foreach ($rolesToDel as $rtd) {
                $roleToDel=UserRole::find($rtd->id)->delete();
                $rolesRemoved++;
            }
            return redirect() -> back() -> with(['success' => "تم تحديث أدوار للمستخدم بنجاح.</p><ul><li>الأدوار المضافة: ".$rolesSaved." دور</li><li>الأدوار المحذوفة: ".$rolesRemoved."دور/أدوار</li><ul>"]) ;
        } catch (Exception $e) {
            return redirect() -> back() -> with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']) ;
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id, $tab)
    {
        $user = User::find($id);
        // return to users if the id is wrong
        if (!$user) {
            return redirect () -> route('users.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
        }

        $query = UserRole::query()
        ->select('users_roles.id', 'roles.name as name')
        ->join('roles', 'roles.id', '=', 'users_roles.role_id');
    
        $userRoles = $query->get();
        
        $vars = [
            'userRoles' => $userRoles,
            'roles' => Role::all(),
            'user' => $user,
            'profile' => UserProfile::where(['userId' => $id])->first(),
            'professions' => static::$professions,
            'tab' => $tab
        ];

        return view ('admin.users.show', $vars);

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
    }
    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function showUserPermissions($id)
    {
        //
        $user = User::find($id);
        $query = UserRole::query()
        ->select('users_roles.id', 'roles.name as name')
        ->join('roles', 'roles.id', '=', 'users_roles.role_id');
    
        $user->roles = $query->get();
        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            
        ];
        return view('admin.users.show.permissions', $vars);
    }

    public function addRoles (Request $req)
    {   
        //
        $userRole = new UserRole();

        $userRole->user_id      = $req->user_id;
        
        $userRole->role_id      = $req->role_id;
        
        $userRole->created_by   = auth()->user()->id;
        
        $userRole->created_at   = date('Y-m-d H:i:s');
        
        $userRole->company      = auth()->user()->company;
        
        if  ($userRole->save()) {

            return redirect() -> back() -> with(['success' => 'تمت إضافة الدور للمستخدم بنجاح.']) ;

        } return redirect() -> back() -> with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']) ;
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
        $user = User::find($request->id);
        $user->edit($request);
        try {
            $user->update();
            return redirect()->back()->withSuccess('تم تحديث البيانات بنجاح');
        } catch (Exception $err) {
            return redirect()->back()->withSuccess('فشل تحديث البيانات :' . $err);
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
        
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function deleteRole($id)
    {
        $role = Role::find($id);
        return ($role);
    }
}
