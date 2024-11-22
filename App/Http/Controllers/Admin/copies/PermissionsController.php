<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\MainMenu;
use App\Models\SubMenu;
use App\Models\Permission;
use App\Models\RulePermission;
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
     
        $menues = MainMenu::all();
        foreach ($menues as $menu) {
            $menu->permissions =  Permission::where(['menu_id'=>$menu->id])->orderBy('id', 'ASC')->paginate(10);
        }
        
        $vars = [
            'menues'            => $menues,
            
        ];
        return view('admin.settings.permissions.home', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
        $mainmenues = MainMenu::all();
        $subMenues = SubMenu::all();

        $vars = [
            'mainmenues'            => $mainmenues,
            'submenues'             => $subMenues,
            

        ];

        return view ('admin.settings.permissions.create', $vars);
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
        $foundPermit = Permission::where(['name'=>$request->name])->orWhere(['display_name_ar'=>$request->display_name_ar])->orWhere(['display_name_en'=>$request->display_name_en])->first();
        
        if (null != $foundPermit) {
            return redirect ()->back()->withError('الصلاحية موجودة بالفعل');
        }
        try {
            $p = Permission::create([
                'name'              => $request->name,
                'menu_id'           => $request->menu_id,
                'url'               => $request->url,
                'display_name_ar'   => $request->display_name_ar,
                'display_name_en'   => $request->display_name_en,
                'status'            => $request->status,
                'type'              => $request->type,
                'created_by'        => auth()->user()->id,
                'created_at'        => date('Y-m-d H:i:s')
            ]);
            return $p;

            return redirect()->back()->with(['success'=>'تم حفظ الصلاحية بنجاح']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>'حدث خطأ ما ولم نتمكن من حفط الصلاحية'.$e]);
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
        
        
        foreach($actions as $pi => $action) {
            $ra = RulePermission::where(['rule_id' => $req->rule_id, 'permission_id'=> $action->id])->first();
            
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
        $p = Permission::find($id);
        $p->menu = MainMenu::find($p->menu_id);
        $menues = MainMenu::all();
        $vars = [
            'permission'    => $p,
            'menues'=>$menues,
        ];
        // return $p;
        return view('admin.settings.permissions.edit', $vars);
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
            $p->edit($request);
            $p->update();
            return redirect()->back()->with(['success'=>'تم تحديث البيانات بنجاح']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=>'خطأ فى تحديث البيانات: '.$e]);
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
            return redirect()->back()->with(['success'=>'تم حذف القائمة بنجاح']);
        } return redirect()->back()->with(['error'=>'خطأ فى حذف القائمة']);
    }
}
