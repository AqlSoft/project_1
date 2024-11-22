<?php

namespace App\Http\Controllers\Admin;

//Models
use App\Models\ContractPallets;
use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\Contract;
use App\Models\StoreBox;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Table; 
use App\Models\Log; 

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ReceptionEntryController extends Controller
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
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id, $copy)
    {
        // 
        //
        $receipt = Receipt::find($id);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.serial as table_name')
        ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
        ->where(['receipt_entries.receipt_id'=>$id, 'receipt_entries.contract_id' => $receipt->contract_id])->get();
        
        foreach ($entries as $in => $entry) {$entry->table = Table::find($entry->table_id);}
        
        $vars = [
            'receipt'                   => $receipt,
            'client'                    => Client::find($receipt->client_id),
            'contract'                  => Contract::find($receipt->contract_id),
            'items'                     => StoreItem::all(),
            'boxes'                     => StoreBox::all(),
            'entries'                   => $entries,
        ];

        return view('admin.operating.input.entries.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
         //check if the table is exists
        $table = Table::where(['name' => $request->table_name])->first();
        
        // return $table;
        if ($table == null) {
            
            $table = Table::create([
                'id'            => uniqid(),
                'name'          => $request->table_name,
                'serial'        => str_pad($request->table_name, 10, '4505000000', STR_PAD_LEFT),
                'size'          => $request->table_size,
                'size'          => $request->table_size,
                'capacity'      => $request->table_size == 1 ? 208:273,
                'created_by'    => auth()->user()->id,
            ]);
            
            try {$table->save();
                
            } catch (Exception $e) {
                return redirect()->back()->withError('لم تنجح عملية إضافة طبلية، يرجى محاولة إضافتها من الواجهة المخصصة لذلك');
            }
        } 
        $receipt = Receipt::find($request->receipt_id); // find the receipt
        $contract = Contract::find($receipt->contract_id); // find the contract
        if ( $contract->isActive()) { // if the contract is approved and still have time
            // create new arrange receipt entry
            
            $entry = ReceiptEntry::create([
                'id'                => uniqid(),
                'type'              => $receipt-> type,
                'hij_date'          => $receipt-> hij_date,
                'greg_date'         => $receipt-> greg_date,
                'table_id'          => $table->id,
                'item_id'           => null != $request->item_id ? $request->item_id : 2,
                'table_size'        => $table->size ,
                'box_size'          => null != $request->box_size ? $request->box_size : 2,
                
                'inputs'            => intval($request->inputs),
                'outputs'           => 0,
                
                'receipt_id'        => $receipt->id,
                'receipt_type'      => $receipt->type,
                
                'client_id'         => $receipt->client_id,
                'contract_id'       => $receipt->contract_id,
                'created_by'        => auth()->user()->id,
                'updated_by'        => auth()->user()->id,
            ]);
            try { //Try saving record
                $entry->save();
                
                //if table saving process succeed? return success message
                return redirect ()->back()->withInput()->with(['success'=> 'تمت إضافة السجل لبيانات المخزن']);
            } catch (Exception $e) { // If any errors happened
                // Return error message tells us about the error
                return redirect ()->back()->withInput()->with(['error'=> 'فشل حفظ السجل بسبب: ' .$e]);
            }
        }
        // if the contract is not approved or not in the active time return failure message
        return redirect ()->back()->withInput()->with(['error'=> 'هناك مشكلة بالعقد يرجى مراجعة الإدارة']);
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
        $entry = ReceiptEntry::edit($request->entry_id, [
           'inputs'         => intval($request->inputs) ,
           'outputs'        => intval($request->outputs) ,
           'item_id'        => $request  -> item_id,
           'box_size'       => $request  -> box_size,
           'inputs'         => intval($request  -> inputs),
           'outputs'        => 0,
           'updated_by'     => auth()->user()->id,
        ]);
        
        //return $request->copy;
        try {
            // Update entry info;
            $entry->update();
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
