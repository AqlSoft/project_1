<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper;

use App\Models\UserProfile;
use App\Models\UserRole;
use App\Models\User;
use App\Models\Menu;
use App\Models\Role;

use Illuminate\Http\Request;

class UsersController extends Controller
{

    use Helper;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    protected static $professions = [
        ['Software Manager', 'مدير النظم'],  
        ['general manager', 'المدير العام'], 
        ['Financial Manager', 'المدير المالى'], 
        ['Inventory Man', 'أمين المخازن'], 
        ['Accountant', 'المحاسب'], 
        ['Store Man', 'مسئول المخازن'], 
        ['Load Unload Worker', 'عامل'],
        ['Purchases Representative', 'مسئول المشتريات'],
        ['Purchases Representative', 'مدير الموارد البشرية'],
    ];
    public function index()
    {
        //
        $users = User::where([])->orderBy('id', 'ASC')->paginate(25);
        foreach($users as $u => $user) {$user->profile = UserProfile::where(['userId' => $user->id])->first();}
        
        $vars = [
            'user'=>auth()->user(),
            'users' => $users,
            'professions' => static::$professions
        ];
        return view ('admin.users.index', $vars);
    }

    public function showBasicInfo ($id) {
         // return to users if the id is wrong
         $user = User::find($id);
         $user->profile = UserProfile::where(['userId' => $user->id])->first();
         
         // return var_dump(static::$professions);
         $user->roles = UserRole::where(['user_id'=>$id])->get();
         foreach ($user->roles as $role) {
            $role->getPermissions();
         }
 
         
         $vars = [
             
             'roles' => Role::all(),
             'user' => $user,
             'professions'=>self::$professions
         ];

        return view ('admin.users.show.basicInfo', $vars);
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
        $user = User::find(auth()->user()->id);
        $query = UserRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();
        $menues = Menu::all();
        foreach($menues as $menu) {
            $menu->getRelatedPermissions();
        }
        $vars = [
            'menues'=>$menues,
            'user'=>$user,
            'roles' => Role::all(),
            'professions'=>self::$professions
        ];
        return view('admin.users.show.permissions', $vars);
    }

        /**
     * Show the admin given permissions according to his role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function changePassword()
    {
        //
        return 'password changed';
    }

    
        /**
     * Show the admin given permissions according to his role.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response 
     */
    public function diaries($id)
    {
        //
        $menues = Menu::all();
        foreach($menues as $menu) {
            $menu->getRelatedPermissions();
        }
        $vars = [
            'user'=>User::find($id),
            'menues'=>$menues,
            'roles'=>Role::all(),
            'professions'=>self::$professions
        ];
        return view('admin.users.show.diaries', $vars);
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
        $user = User::find(auth()->user()->id);
        $query = UserRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();

        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            
        ];
        return view('admin.users.show.roles', $vars);
    }

    public function addRoles (Request $req)
    {   
        $admin = User::find($req->id);
        $admin->roles = UserRole::where(['user_id'=>$req->id])->get();
        $rolesToDel = $admin->roles;

        //
        $sentRoles = $req->roles;

        $rolesSaved = 0;

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
                $rolesSaved--;
            }
            return redirect() -> back() -> with(['success' => 'تمت إضافة '.$rolesSaved.' أدوار للمستخدم بنجاح.']) ;
        } catch (Exception $e) {
            return redirect() -> back() -> with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']) ;
        }

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
        $user = User::find(auth()->user()->id);
        $query = UserRole::where(['user_id'=>$user->id]);
        $user->roles = $query->get();
        
        $vars = [
            'user'=>$user,
            'roles' => Role::all(),
            
        ];
        return view('admin.users.show.contactInfo', $vars);
    }


    // /**
    //  * Update the specified resource in storage.
    //  *
    //  * @param  \Illuminate\Http\Request  $request
    //  * @param  int  $id
    //  * @return \Illuminate\Http\Response
    //  */
    public function updateProfile(Request $request)
    {
        $profile = UserProfile::where(['userId'=>$request->id])->first();

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
    public function store(Request $request)
    {
        //
        $user = new User();

        $user->userName         = $request->userName;
        $user->email            = $request->email;
        $user->password         = bcrypt($request->password);
        $user->company          = auth()->user()->company;
        $user->created_at       = date('Ymd H:i:s');

        if ($user->save()) {
            $profile = UserProfile::initiateNewProfile($request);
            $profile->userId = $user->id;
            if ($profile->save()) {
                return redirect () -> route('users.show', [$user->id, 1])->withSuccess('تمت الإضافة بنجاح');
            } 
            return redirect () -> back()->withError('تم إضافة موظف جديد بنجاح');
        } 
        return redirect () -> back()->withError('حدث خطأ أثناء حفظ الموظف الجديد');
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
        ->select('users_`role`s.id', 'roles.name as name')
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
     * Show the admin given permissions according to his role.
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

    // public function addRoles (Request $req)
    // {   
    //     //
    //     $userRole = new UserRole();

    //     $userRole->user_id      = $req->user_id;
        
    //     $userRole->role_id      = $req->role_id;
        
    //     $userRole->created_by   = auth()->user()->id;
        
    //     $userRole->created_at   = date('Y-m-d H:i:s');
        
    //     $userRole->company      = auth()->user()->company;
        
    //     if  ($userRole->save()) {

    //         return redirect() -> back() -> with(['success' => 'تمت إضافة الدور للمستخدم بنجاح.']) ;

    //     } return redirect() -> back() -> with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']) ;
    // }

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
