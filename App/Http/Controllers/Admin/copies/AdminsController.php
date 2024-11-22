<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper;
use App\Models\Admin;
use App\Models\Role;
use App\Models\AdminRole;
use App\Models\AdminProfile;
use Illuminate\Http\Request;

class AdminsController extends Controller
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
        $users = Admin::where([])->orderBy('id', 'ASC')->paginate(25);
        foreach($users as $u => $user) {$user->profile = AdminProfile::where(['userId' => $user->id])->first();}
        
        $vars = [
            'users' => $users,
            'professions' => static::$professions
        ];
        return view ('admin.admindashboard.admins.index', $vars);
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
        return view ('admin.admindashboard.admins.create', $vars);
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
        $admin = new Admin();

        $admin->userName         = $request->userName;
        $admin->email            = $request->email;
        $admin->password         = bcrypt($request->password);
        
        $admin->created_at       = date('Ymd H:i:s');
        $admin->created_by       = auth()->user()->id;

        if ($admin->save()) {
            $profile = AdminProfile::initiateNewProfile($request);
            $profile->userId = $admin->id;
            if ($profile->save()) {
                return redirect () -> route('admins.show', [$admin->id, 1])->withSuccess('تمت الإضافة بنجاح');
            } 
            return redirect () -> back()->withError('تم إضافة موظف جديد بنجاح');
        } 
        return redirect () -> back()->withError('حدث خطأ أثناء حفظ الموظف الجديد');
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
        $admin = Admin::find($request->id);
        if (null == $admin) { return redirect () -> back()->with(['error'=>'حدث خطأ أثناء تحديث بيانات الموظف']); }

        $admin->userName         = $request->userName;
        $admin->email            = $request->email;
        
        $admin->updated_at       = date('Ymd H:i:s');
        $admin->updated_by       = auth()->user()->id;

        if ($admin->update()) {
            return redirect()->back()->with(['success'=>'تم تحديث البيانات بنجاح']);
        } 
        return redirect()-> back()->with(['error'=>'حدث خطأ أثناء حفظ الموظف الجديد']);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function showBasicInfo($id)
    {
        // return to users if the id is wrong
        $admin = Admin::find($id);
        $admin->profile = AdminProfile::where(['userId' => $admin->id])->first();
        
        // return var_dump(static::$professions);
        $admin->roles = AdminRole::where(['user_id'=>$id])->get();
        foreach ($admin->roles as $role) {
            $role->getPermissions();
        }

        
        $vars = [
            'adminRoles'=>$admin->getPermissions(),
            'roles' => Role::all(),
            'admin' => $admin,
            'professions'=>self::$professions
        ];

        return view ('admin.admindashboard.admins.show.basicInfo', $vars);

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
        // return to users if the id is wrong
        $user = auth()->user();
        $user->profile = AdminProfile::where(['userId' => $user->id])->first();
        $user->professions = static::$professions;
        
        // return var_dump(static::$professions);
        $user->roles = AdminRole::select('id', 'user_id', 'role_id')->where(['user_id'=>$user->id])->get();
        
        $vars = [
            'roles' => Role::all(),
            'user' => $user,
        ];

        return view ('admin.admindashboard.admins.show.basicInfo', $vars);

    }

        /**
     * Show the admin given permissions according to his role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function permissions()
    {
        //
        $user = Admin::find(auth()->user()->id);
        $query = AdminRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();

        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            'professions'=>self::$professions
        ];
        return view('admin.admindashboard.admins.show.permissions', $vars);
    }

        /**
     * Show the admin given permissions according to his role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function roles($id)
    {
        //
        $user = Admin::find(auth()->user()->id);
        $query = AdminRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();

        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            
        ];
        return view('admin.admindashboard.admins.show.roles', $vars);
    }

    /**
     * Show the admin given permissions according to his role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function loginInfo($id)
    {
        //
        $user = Admin::find(auth()->user()->id);
        $query = AdminRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();
        
        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            
        ];
        return view('admin.admindashboard.admins.show.contactInfo', $vars);
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

    public function addRoles (Request $req)
    {   
        $admin = Admin::find($req->id);
        $admin->roles = AdminRole::where(['user_id'=>$req->id])->get();
        $rolesToDel = $admin->roles;

        //
        $sentRoles = $req->roles;

        $rolesSaved = 0;

        try {
            if ($sentRoles > 0)
            foreach ($sentRoles as $role) {
                $nr = new AdminRole();
                $nr->user_id       = intval($req->id);
                $nr->role_id       = $role;
                $nr->created_at    = date('Y-m-d H:i:s');
                $nr->created_by    = auth()->user()->id;
                $nr->save();
                $rolesSaved++;
            }
            foreach ($rolesToDel as $rtd) {
                $roleToDel=AdminRole::find($rtd->id)->delete();
                $rolesSaved--;
            }
            return redirect() -> back() -> with(['success' => 'تمت إضافة '.$rolesSaved.' أدوار للمستخدم بنجاح.']) ;
        } catch (Exception $e) {
            return redirect() -> back() -> with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']) ;
        }

    }

    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function profile_update(Request $request)
    {
        $profile = AdminProfile::where(['userId'=>$request->id])->first();

        if (null == $profile) { return redirect()->back()->with(['error'=>'حدث خطأ ما، يرجى مراجعة الإدارة!!']); }

        $profile->editProfile($request);
        
        $profile->updated_at       = date('Ymd H:i:s');
        $profile->updated_by       = auth()->user()->id;

        if ($profile->update()) {
            
            return redirect () -> back()->with(['success'=>'تم تعديل بيانات الموظف بنجاح']);
        } 
        return redirect () -> back()->with(['error'=>'حدث خطأ أثناء تحديث بيانات الموظف']);
    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {
        //
        $admin = Admin::find($id);
        if ($admin->delete()) {
            return redirect() -> back() -> with(['success' => 'تم حذف المدير بنجاح']) ;
        } return redirect () -> route('admins.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
    }
}
