<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Helper;
use App\Models\User;
use App\Models\Rule;
use App\Models\UserRule;
use App\Models\UserProfile;
use Illuminate\Http\Request;

class UsersController extends Controller
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
        $users = User::where([])->orderBy('id', 'ASC')->paginate(25);
        foreach($users as $u => $user) {$user->profile = UserProfile::where(['userId' => $user->id])->first();}
        
        $vars = [
            'users' => $users,
            'professions' => static::$professions
        ];
        return view ('admin.users.index', $vars);
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
        // return to users if the id is wrong
        if (!User::find($id)) {
            return redirect () -> route('users.home')->withError('لا يوجد موظفين مرتبطين بهذا الرقم التعريفى، رجاءا اختر موظفين من القائمة');
        }

        $query = UserRule::query()
        ->select('users_rules.id', 'rules.name as name')
        ->join('rules', 'rules.id', '=', 'users_rules.rule_id');
    
        $userRules = $query->get();
        
        $vars = [
            'userRules' => $userRules,
            'rules' => Rule::all(),
            'user' => User::find($id),
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

    public function addRules (Request $req)
    {   
        //
        $userRule = new UserRule();

        $userRule->user_id      = $req->user_id;
        
        $userRule->rule_id      = $req->rule_id;
        
        $userRule->created_by   = auth()->user()->id;
        
        $userRule->created_at   = date('Y-m-d H:i:s');
        
        $userRule->company      = auth()->user()->company;
        
        if  ($userRule->save()) {

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
    public function update(Request $request, $id)
    {
        //
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
