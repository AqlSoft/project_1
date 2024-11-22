<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SubMenu;
use App\Models\MainMenu;
use App\Models\Permission;
use Illuminate\Http\Request;
use App\Http\Requests\CreateSubmenuRequest;

class SubMenuesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

     
     public function index()
     {
         //
         $query = SubMenu::query()
            ->select('sub_menues.*', 'main_menues.name as parent')
            ->join('main_menues', 'main_menues.id', '=', 'sub_menues.main_menu')
            ->where([]);
            
            $submenues = $query->orderBy('id', 'ASC')->paginate(10);
 
            foreach ($submenues as $sm => $menu) {
                $menu->actions=Permission::where(['submenu_id'=>$menu->id, 'menu_id'=>$menu->main_menu])->get();
            }

         $vars = [
            'submenues' => $submenues,
            
         ];
         return view ('admin.settings.submenues.home', $vars);
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function create($mainMenu) 
     {
         //
        $mms = MainMenu::all();
 
         $vars = [
            'mainMenuId'            => $mainMenu,
            'mainmenues'            => $mms,
         ];
         return view ('admin.settings.submenues.create', $vars);
     }
 
     /**
      * Show the form for creating a new resource.
      *
      * @return \Illuminate\Http\Response
      */
     public function getMenuesOf(Request $req) 
     {
        //
        $subMenues = SubMenu::where(['main_menu' => $req->id])->get();
       
    // var_dump ($subMenues);
    
        return $subMenues;
     }
 
     /**
      * Store a newly created resource in storage.
      *
      * @param  \Illuminate\Http\Request  $request
      * @return \Illuminate\Http\Response
      */
     public function store(CreateSubmenuRequest $request)
     {
        //
        $submenu = new SubMenu ();
        $submenu->name         =  $request->name;
        $submenu->main_menu    =  $request->main_menu;
        // return $request->main_menu;
        $submenu->status       =  $request->status;
        $submenu->menu_link    =  $request->menu_link;
        
        $submenu->created_by   =  auth()-> user() -> id;
        $submenu->created_at   =  date('Y-m-d H:i:s');;
        



        if ($submenu->save()) {
            return redirect()->back()->with(['success' => 'تم الحفظ بنجاح :)']);
        } return redirect()->back()->with(['error' => 'حدث خطأ أثناء الحفظ']);
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
        $query = SubMenu::query()
            ->select('sub_menues.*', 'main_menues.name as parentName')
            ->join('main_menues', 'main_menues.id', '=', 'sub_menues.main_menu')
            ->where(['sub_menues.id'=>$id]);
        $subMenu = $query->first();


        $permissions = Permission::where(['submenu_id' => $subMenu->id, 'menu_id' => $subMenu->main_menu])->get();
        $subMenu->permissions = $permissions;

        $vars = [
            'subMenu'               => $subMenu,
            
         ];

        return view ('admin.settings.submenues.show', $vars);
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
         $mms = MainMenu::all();
         $sm = SubMenu::find($id);
 
         $vars = [
            'submenu'               => $sm,
            'mainmenues'           => $mms,
         ];
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
        $submenu = SubMenu::find ($request->menuId);

        if (!$submenu) {
            return redirect()->back()->with(['error' => 'القائمة الفرعية التى تحاول تعديلها غير موجود، تأكد من أنك تمتلك كافة الصلاحيات لهذا العمل']);
        }

        $submenu->name         =  $request->name;
        $submenu->menu_link    =  $request->menu_link;
        $submenu->main_menu    =  $request->main_menu ? $request->main_menu : $submenu->main_menu;
        $submenu->status       =  $request->status;
        
        $submenu->updated_by   =  auth()-> user() -> id;
        $submenu->updated_at   =  date('Y-m-d H:i:s');
        // return $submenu;
        
        if ($submenu->update()) {
            return redirect()->back()->with(['success' => 'تم التحديث بنجاح :)']);
        } return redirect()->back()->with(['error' => 'حدث خطأ أثناء تحديث البيانات ']);
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

         if (Submenu::find($id)->delete()) {
            return redirect()->back()->with(['success'=>'تم حذف القائمة بنجاح']);
        } return redirect()->back()->with(['error'=>'خطأ فى حذف القائمة']);
     }
}
