<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

//Models
use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\Contract;
use App\Models\StoreBox;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Table; 
use App\Models\Log; 

class ArrangementEntryController extends Controller
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
        $receipt = Receipt::find($id);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as table_name', 'store_items.name as item_name', 'store_boxes.name as box_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.receipt_id'=> $receipt->id])->get();
        // $the_entries = ReceiptEntry::where(['receipt_entries.receipt_id'=> 3299])->get();
        // return $entries;
        $tables = ReceiptEntry::groupBy('table_id')->select('receipt_entries.table_id', 'tables.name as table_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();

        $items = ReceiptEntry::groupBy('item_id')->select('receipt_entries.item_id', 'store_items.name as item_name')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();
        
        $boxes = ReceiptEntry::groupBy('box_size')->select('receipt_entries.box_size', 'store_boxes.name as box_name')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();

        $vars = [
            'client'=>Client::find($receipt->client_id),
            'contract'=>Contract::find($receipt->contract_id),
            'items' => $items, 
            'boxes' => $boxes, 
            'receipt'=>Receipt::find($id),
            'entries'=>$entries,
            'tables'=>$tables,
            
        ];
        return view('admin.operating.arrange.entries.create', $vars);
    }

    public function tableContent (Request $req) {
        $table = Table::find($req->table);
        $entries = $table->content($req->contract);
        foreach($entries as $entry) {
            $entry->number = $table->name;
            $entry->itemName = StoreItem::find($entry->item_id)->name;
            $entry->boxName = StoreBox::find($entry->box_size)->name;
            $entry->quantity = $entry->total_inputs - $entry->total_outputs;
        }
        return view('admin.operating.arrange.entries.content', ['entries' => $entries]) ;
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function copy($id, $copy)
    {
        //
        $theCopy = ReceiptEntry::find($copy);
        $receipt = Receipt::find($id);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as table_name', 'store_items.name as item_name', 'store_boxes.name as box_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.receipt_id'=> $receipt->id])->get();
         
        $tables = ReceiptEntry::groupBy('table_id')->select('receipt_entries.table_id', 'tables.name as table_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();

        $items = ReceiptEntry::groupBy('item_id')->select('receipt_entries.item_id', 'store_items.name as item_name')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();
        
        $boxes = ReceiptEntry::groupBy('box_size')->select('receipt_entries.box_size', 'store_boxes.name as box_name')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();

        $vars = [
            'client'=>Client::find($receipt->client_id),
            'contract'=>Contract::find($receipt->contract_id),
            'items' => $items, 
            'boxes' => $boxes, 
            'receipt'=>Receipt::find($id),
            'entries'=>$entries,
            'the_copy'=>$theCopy,
            'tables'=>$tables,
            
        ];
        return view('admin.operating.arrange.entries.create', $vars);
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
        $table = Table::where(['id' => $request->table_id])->first();
        
         //return $table;
        if ($table != null) {
            $receipt = Receipt::find($request->receipt_id); // find the receipt
            $contract = Contract::find($receipt->contract_id); // find the contract
            if ($contract->isActive()) { // if the contract is approved and still have time
                // create new arrange receipt entry
                $entry = ReceiptEntry::create([
                    'id'                => uniqid(),
                    'receipt_type'      => $receipt-> type,
                    'type'              => $request->inputs > 0 ? 1 : 2,
                    'table_id'          => $table->id,
                    'item_id'           => $request->item_id,
                    'table_size'        => $table->size,
                    'box_size'          => $request->box_size,
                    
                    'inputs'            => intval($request->inputs),
                    'outputs'           => intval($request->outputs),
                    
                    'receipt_id'        => $receipt->id,
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
    } else { 
        // if the user didnot selected a table ? return error message telling him to select a table due to adding record
        return redirect()->back()->with(['error' => 'يرجى اختيار طبلية لوضع البضاعة عليها'])->withInput();
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
        $entry = ReceiptEntry::edit($request->entry_id, [
            'inputs'       => intval($request  -> inputs),
            'outputs'      => intval($request  -> outputs),
            'updated_by'   => auth()->user()->id,
        ]);
                
        
        //return $request->copy;
        try {
            // Update entry info;
            $entry->update();
            return redirect()->route('arrange.entries.create', [$entry->receipt_id, 0])->with(['success' => 'تم تحديث البيانات بنجاح']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error' => 'حدث خطأ أثناء حفظ البيانات']);
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
