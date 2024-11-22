<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;

// Models 
use App\Models\ItemsCategory;
use App\Models\StorePoint;
use App\Models\Section;
use App\Models\Store;
use App\Models\Table;
use App\Models\Item;
use App\Models\User;
use App\Models\Room;

// Requests
use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;


class SectionsController extends Controller
{
    private static $sections = [1=>'A', 2=>'B', 3=>'C', 4=>'D'];

    //
    public function home () {
        
       
        $vars=[
            'sections'        => Section::all(),
        ];
        return view('admin.store.sections.home', $vars);
    }
   
    public function create () {
        
        return view('admin.store.sections.create', ['keepers'=>User::all()]);
    }

    //
    public function view ($id) {
        $section =Section::find($id);
        $section->the_admin = User::find($section->keeper);
        $section->rooms = Room::where(['section' => $section->id])->get();
        $vars=[
            'section'        => $section,
            'branches'        => Store::$branches,
        ];
        return view('admin.store.sections.view', $vars);
    }
    
    public function edit ($id) {
        $stores = Store::where('id', '!=', 1)->get();
        $allStores = [];
        foreach($stores as $in => $store) {$allStores[$store->id] = $store;}
        $vars=[
            'stores'        => $allStores,
            'sizes'         => ['', 'كبيرة', 'وسط', 'صغيرة'],
            'room'          => Room::where(['id' => $id])->first(),
        ];
        
        return view('admin.items.rooms.edit', $vars);
    }

    public function store (Request $req) {

       $section = Section::create([
            'a_name'            => $req->a_name, 
            'e_name'            => $req->e_name, 
            'branch'            => $req->branch,
            'status'            => $req->status, 
            'keeper'            => $req->keeper, 
            'code'              => $req->code, 
            'created_by'        => auth()->user()->id, 
            
       ]);

        if($section->save()) {
            return redirect()->back()->withSuccess('تمت إضافة قسم مخازن جديد بنجاح');
        }
        
    }

    public function update (RoomRequest $req) {

        $room              = Room::where(['id' => $req->id])->first();
        
        $room->e_name       = $req->e_name;
        $room->serial       = $req->serial;
        $room->store        = $req->store;
        $room->size         = $req->size;
        $room->code         = $req->code;
        $room->company      = auth()->user()->company;
        $room->created_by   = auth()->user()->id;
        $room->created_at   = date('Y-m-d H:i:s');

        if($room->update()) {
            return redirect()->route('rooms.home')->withSuccess('تم تحديث بيانات الغرفة بنجاح');
        }
        
    }
   
    public function delete ($id) {

        $room            = Room::where(['id' => $id])->first();
        
        if($room->delete()) {
            return redirect()->back()->withSuccess('تم إزالة الغرفة بنجاح');
        }
        
    }

}
