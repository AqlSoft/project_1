<?php

namespace App\Http\Controllers\Admin;

//Models
use App\Models\ContractPallets;
use App\Models\ReceiptEntry;
use App\Models\StorePoint;
use App\Models\StoreItem;
use App\Models\Contract;
use App\Models\StoreBox;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Table; 
use App\Models\Room; 
use App\Models\Log; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class PositionEntryController extends Controller
{

    protected static $type = 5;
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $copy)
    {
        // 
        //
        $receipt = Receipt::find($id);
        $entries = StorePoint::select('store_points.*', 'tables.name as table_name')
        ->join('tables', 'tables.id', '=', 'store_points.table_id')
        ->where(['store_points.positioning_receipt_id'=>$id])->get();
        
        $vars = [
            'receipt'                   => $receipt,
            'rooms'         => Room::all(),
            'client'                    => Client::find($receipt->client_id),
            'contract'                  => Contract::find($receipt->contract_id),
            'items'                     => StoreItem::all(),
            'boxes'                     => StoreBox::all(),
            'entries'                   => $entries,
        ];

        return view('admin.operating.position.entries.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $req)
    {
         //check if the table is exists
        $table = Table::where(['name' => $req->table_name])->first();
        if (null == $table) {
            return redirect ()->back()->withInput()->with(['error'=> 'مفيش طبلية بالرقم دة: ']);
        }
        $positions = StorePoint::where(['table_id'=> $table->id])->get();
        foreach ($positions as $pos) {
            $pos->delete();
        }
        try {
            storePoint::create ([
            'table_id'          =>$table->id, 
            'positioning_receipt_id'        =>$req->receipt_id,
            'section'           =>2,
            'room'              =>2, 
            'partition'         =>'F', 
            'position'          =>1, 
            'rack'              =>'A', 
            'code'              =>'X1F01A',
            'created_by'        =>auth()->user()->id,
        ])->save();
            return redirect ()->back()->withInput()->with(['success'=> 'تمت اضافة الطبلية للسند']);
        } catch (Exception $e) { // If any errors happened
            // Return error message tells us about the error
            return redirect ()->back()->withInput()->with(['error'=> 'فشل حفظ السجل بسبب: ' .$e]);
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
    public function update(Request $request)
    {
        //check if the table is exists
        $room = Room::find($request->room);
        $code = $room->code.$request->partition.$request->position.$request->rack;
        try {
            StorePoint::edit($request->entry_id, [
                'section'           => $room->section,
                'room'              => $request->room,
                'partition'         => $request->partition,
                'position'          => $request->position,
                'rack'              => $request->rack,
                'code'              => $code,
                'updated_by'        => auth()->user()->id,
            ])->update();
            return redirect()->back()->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حفظ البيانات'.$e]);
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
        $entry = ReceiptEntry::find($id);
        try {
            $entry->delete();
            return redirect()->back()->withSuccess(' تم حذف السجل بنجاح.');
        }
        catch (Exception $e) {
            return redirect()->back()->withError('لم يتم حفظ البيانات بسبب: ' . $e);
        }
    }
}
