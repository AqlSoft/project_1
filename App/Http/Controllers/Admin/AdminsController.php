<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper;

use App\Models\AdminProfile;
use App\Models\Possitions;
use App\Models\UserRule;
use App\Models\Admin;
use App\Models\AdminRole;
use App\Models\Rule;
use Illuminate\Database\QueryException;
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
        $users = Admin::where([])->with('profile')->with('roles')->get();

        $vars = [
            'users' => $users,
            'professions' => static::$professions
        ];
        return view('admin.admins.home', $vars);
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
            'jobs' => Possitions::all(),
        ];
        return view('admin.admins.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     * @param  \Illuminate\Http\Request  $request.
     * @return \Illuminate\Http\Response.
     */

    public function store(Request $request)
    {
        //
        $admin = Admin::create([
            'userName'         => $request->userName,
            'email'            => $request->email,
            'password'         => bcrypt($request->password),
            'created_at'       => date('Ymd H:i:s'),
            'created_by'       => auth()->user()->id
        ]);

        if ($admin != null) {
            $profile = AdminProfile::newProfile($request);
            $profile->user_id = $admin->id;
            try {
                $profile->save();
                return redirect()->route('display-admin', [$admin->id])->withSuccess('New admin has been added successfully.');
            } catch (QueryException $e) {
                $admin->delete();
                return redirect()->back()->withError('Admin creation process failed');
            }
        }
        return redirect()->back()->withError('Admin creation process failed');
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

        return view('admin.admins.edit', ['user' => Admin::find($id)->with('profile')->first()]);
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
        $profile = AdminProfile::where(['user_id' => $request->id])->first();

        if (null == $admin) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث بيانات الموظف']);
        }
        try {
            $admin->update([
                'userName'         => $request->userName  ?? $admin->userName,
                'email'            => $request->email     ?? $admin->email,
                'updated_at'       => date('Ymd H:i:s')   ?? $admin->updated_at,
                'updated_by'       => auth()->user()->id  ?? $admin->updated_by,
            ]);

            $profile->update([
                'first_name'    => $request->first_name     ?? $profile->first_name,
                'last_name'     => $request->last_name      ?? $profile->last_name,
                'possition'     => $request->possition      ?? $profile->possition,
                'gender'        => $request->gender         ?? $profile->gender,
                'dob'           => $request->dob            ?? $profile->dob,
                'natId'         => $request->natId          ?? $profile->natId,
                'image'         => $request->image          ?? $profile->image,
                'user_id'       => $request->user_id        ?? $profile->user_id,
                'updated_at'    => $request->updated_at     ?? $profile->updated_at,
                'phone'         => $request->phone          ?? $profile->phone,
                'address'       => $request->address        ?? $profile->address
            ]);
            return redirect()->back()->with(['success' => 'Admin info updated successfully.']);
        } catch (QueryException $e) {
            return redirect()->back()->with(['error' => "Error updating admin info due to: $e"]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function display($id)
    {
        // return to users if the id is wrong
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->route('admins.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
        }
        $vars = [
            'admin' => Admin::where('id', $id)->with('profile')->first(),
        ];

        return view('admin.admins.profile', $vars);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function displayRoles($id)
    {
        // return to users if the id is wrong
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->route('display-admins-list')->withError('No admins has been found with provided id, please select admins from the list.');
        }
        $profile = $admin->profile();
        $admin->getRoles();
        $roles = $admin->assignedRoles;

        $vars = [
            'admin' => $admin,
            'profile' => $profile,
            'roles' => $roles,
        ];

        return view('admin.admins.roles', $vars);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function displayLog($id)
    {
        // return to users if the id is wrong
        $admin = Admin::find($id);
        if (!$admin) {
            return redirect()->route('admins.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
        }
        $vars = [
            'admin' => Admin::where('id', $id)->with('profile')->first(),
        ];

        return view('admin.admins.log', $vars);
    }

    public function addRules(Request $req)
    {
        //
        $userRule = new AdminRole();

        $userRule->user_id      = $req->user_id;

        $userRule->rule_id      = $req->rule_id;

        $userRule->created_by   = auth()->user()->id;

        $userRule->created_at   = date('Y-m-d H:i:s');

        $userRule->company      = auth()->user()->company;

        if ($userRule->save()) {

            return redirect()->back()->with(['success' => 'تمت إضافة الدور للمستخدم بنجاح.']);
        }
        return redirect()->back()->with(['error' => 'لم تتم إضافة الدور للمستخدم بسبب حدوث خطأ. نرجو مراجعة مدير التطبيق.']);
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
        $profile = AdminProfile::where(['userId' => $request->id])->first();

        if (null == $profile) {
            return redirect()->back()->with(['error' => 'حدث خطأ ما، يرجى مراجعة الإدارة!!']);
        }

        $profile->firstName         = $request->firstName;
        $profile->lastName          = $request->lastName;
        $profile->title             = $request->title;
        $profile->gender            = $request->gender;
        $profile->dob               = $request->dob;
        $profile->natId             = $request->natId;
        $profile->phone             = $request->phone;
        $profile->profession        = $request->profession;


        $profile->updated_at       = date('Ymd H:i:s');
        $profile->updated_by       = auth()->user()->id;

        if ($profile->update()) {

            return redirect()->back()->with(['success' => 'تم تعديل بيانات الموظف بنجاح']);
        }
        return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث بيانات الموظف']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRoles(Request $req)
    {
        //
        foreach ($req->admins as $admin_id)
            try {
                AdminRole::create([
                    'role_id' => $req->role_id,
                    'admin_id' => $admin_id
                ]);
            } catch (QueryException $err) {
                return redirect()->back()->withError('failed to assign role due to: ' . $err);
            }
        return redirect()->back()->with(['success' => 'Role assigned successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function assignRole($admin_id, $role_id)
    {
        //
        $admin=Admin::find($admin_id);
        $sm = "تم تعيين الدور بنجاح إلى $admin->userName";
        $em = "لم يتم تعيين الدور إلى $admin->userName بسبب: ";
        try {
            $admin->assignRole($role_id);
            return redirect()->back()->with(['success' => $sm]);
        }
        catch (QueryException $err) {
            return redirect()->back()->withError($em . $err);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function dettachRole($admin_id, $role_id)
    {
        //
        $admin_role=AdminRole::where(['admin_id'=>$admin_id, 'role_id'=>$role_id])->first();
        
        try {
            $admin_role->delete();
            return redirect()->back()->with(['success' => "تمت ازالة الدور بنجاح"]);
        }
        catch (QueryException $err) {
            return redirect()->back()->withError("فشل فى ازالة الدور بسبب: " . $err);
        }
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
            return redirect()->back()->with(['success' => 'تم حذف المدير بنجاح']);
        }
        return redirect()->route('admins.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
    }
}
