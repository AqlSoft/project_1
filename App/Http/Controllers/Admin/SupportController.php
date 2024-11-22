<?php

namespace App\Http\Controllers\Admin;

use App\Models\Support;
use App\Models\MainMenu;
use App\Models\SubMenu;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SupportController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */ 
    public function gallery ($id)
    {
        $menues = MainMenu::all();
        foreach ($menues as $i => $menu) {
            $menu->submenues = SubMenu::where(['main_menu'=>$menu->id])->get();
            foreach($menu->submenues as $m => $sm) {
                $sm->files = Support::where(['cat_id'=>$sm->id])->get();
            }
        }
        $vars['display'] = Support::where(['id'=> $id])->first();

        $vars['menues'] = $menues;


        return view ('admin.files.gallery', $vars);
        //
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function upload (Request $req)
    {

        $req->validate([
            'file' => 'required|mimes:jpg,png,jpeg,pdf|max:10000',
        ]);
        
        $fileHandler = $req->file;
        $newName = 'testing' . date('_Ymd_Hsi') . '.' . $req->file->extension();
        try{
            $saveName = $fileHandler->storeAs('admin/uploads/documents', $newName);
            //$dashboard->file = $saveName;
            return redirect() -> route('files.gallery', ['file'=>$saveName]);
        } catch(Exception $e) {
            return $e->getMessage();
        }
                
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
    public function store(Request $req)
    {
        
        $fileHandler = $req->file;
        $fileHandler->type = explode('/', $fileHandler->getMimeType())[0];
        $userSuggest = !$req->name ? $req->name : '_std';
        $folder = $fileHandler->type == 'image' ? 'images' : 'documents';
        return $req->file;
        
        if($req->hasFile('file')) {
            
            $fileHandler = $req->file;
            $fileHandler->type = explode('/', $fileHandler->getMimeType())[0];
            $userSuggest = !$req->name ? $req->name : '_std';
            $folder = $fileHandler->type == 'image' ? 'images' : 'documents';
            return $fileHandler->type;
           
            $file_path = "admin/uploads/$folder";
            $newName = 'support_file' . $userSuggest . date('_Ymd_Hsi') . '.' . $req->file->extension();
            $lastInserted = Support::where([])->orderBy('serial', 'DESC')->first();
            $fileHandler->storeAs($file_path, $newName);
            var_dump('');
                $serial= $lastInserted == null ? '24000000001' : $lastInserted->serial++;

            $support = new Support();
            $support->name = $req->name;
            $support->file_name = $newName;
            $support->file_path = $file_path;
            $support->brief = $req->brief;
            $support->type = $fileType;
            $support->serial = $serial;
            $support->cat_id = $req->parent;
            $support->created_by = auth()->user()->id;
            $support->created_at = date('Y-m-d H:i:s');
            
            try {
                $support->save();
                return redirect()->back()->withSuccess('تم الحفظ بنجاح');
            } catch (Exception $e) {
                return redirect() ->back()->withSuccess('فشل رفع الملف '.$e->getMessage());
                    
            }
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
        //
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
