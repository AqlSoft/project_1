<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Item;
use App\Models\ItemsCategory;
use App\Models\Table;
use App\Models\StorePoint;
use App\Models\Room;
use App\Models\User;
use App\Models\Store;
use App\Models\Section;


use Illuminate\Http\Request;
use App\Http\Requests\RoomRequest;
use Illuminate\Database\QueryException;


class RoomsController extends Controller
{
    private static $sections = [1=>'A', 2=>'B', 3=>'C', 4=>'D'];

    
    /**
     * To display all rooms and related properties
     *
     * @return [view]
     * 
     */
    public function all () {
        $stores = Store::where('id', '!=', 1)->get();
        $allStores = [];
        foreach($stores as $in => $store) {$allStores[$store->id] = $store;}
        $sizes = ['', 'كبيرة', 'وسط', 'صغيرة'];
        $vars=[
            'stores'        => $allStores,
            'sizes'         => $sizes,
            'sections'      => self::$sections,
            'rooms'         => Room::all()
        ];
        return view('admin.store.rooms.all', $vars);
    }
    /**
     * [Description for home]
     *
     * @return [type]
     * 
     */
    public function home () {
        $rooms = Room::select('rooms.*', 'sections.e_name as the_section', 'admins.username as the_admin')
        ->join('sections','sections.id','=','rooms.section')
        ->join('admins','admins.id','=','rooms.created_by')
        ->where([])->get();
      
        $sizes = ['', 'صغيرة', 'كبيرة', 'مخصصة'];
        $vars=[
           
            'sizes'         => $sizes,
            'sections'      => self::$sections,
            'rooms'         => $rooms
        ];
        return view('admin.store.rooms.home', $vars);
    }
    

    public function create () {
        
        
        $lastRoom = Room::where([])->orderBy('id', 'DESC')->first();

        $vars=[
            'sections'        => Section::all(),
            'branches'        => Store::$branches,
            'lir'               => $lastRoom == null ? 4515000001 : $lastRoom->serial + 1,
        ];
        return view('admin.store.rooms.create', $vars);
    }

    public function store (Request $req) {
    // return $req->section;
            // return $req->scheme;
        try {
            Room::create([
            'a_name'         => $req->a_name,
            'e_name'         => $req->e_name,
            'serial'         => $req->serial,
            'scheme'         => $req->scheme,
            'section'        => $req->section,
            'size'           => $req->size,
            'code'           => $req->code,
            'status'         => 1,
            'branch'         => $req->branch,
            'created_by'     => auth()->user()->id,
            ])->save();
            return redirect()->back()->withSuccess('تمت إضافة الغرفة بنجاح');
        } catch (QueryException $e) {
            return redirect()->route('rooms.home')->withError('لم نتمكن من إضافة الغرفة بسبب: '.$e->getMessage());
        }
        
    }

    //
    public function view ($id) {
        $room =Room::find($id);

        $room->contents = StorePoint::select('store_points.*', 'tables.name as table_name')
        ->join('tables', 'tables.id', '=', 'store_points.table_id')
        ->where(['store_points.room'=>$id])->orderBy('table_name', 'ASC')->get();
        // var_dump($room->contents->toArray());
        $large_tables = array_filter($room->contents->toArray(), function($object) {
            return $object['table_name'] >= 3000; 
        });
        $room->large_tables = count($large_tables);
        $room->total_tables = count($room->contents);
        
        $room->the_section = Section::find($room->section);
        $room->the_branch = Store::$branches[$room->branch];
        $room->the_keeper = User::find($room->the_section->keeper);
        $vars=[
            'room'        => $room,
        ];
        return view('admin.store.rooms.view', $vars);
    }

        
    public function edit ($id) {
        $stores = Store::where('id', '!=', 1)->get();
        $allStores = [];
        foreach($stores as $in => $store) {$allStores[$store->id] = $store;}
        $vars=[
            'stores'        => $allStores,
            'sizes'         => ['', 'صغيرة', 'كبيرة', 'مخصصة'],
            'room'          => Room::where(['id' => $id])->first(),
        ];
        
        return view('admin.store.rooms.edit', $vars);
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
