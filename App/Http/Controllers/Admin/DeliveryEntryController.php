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
use App\Http\Requests\DeliveryEntryCreateRequest;
use Illuminate\Http\Request;

class DeliveryEntryController extends Controller
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
        $receipt = Receipt::find($id);
        if (!$receipt == null) {
            $allContractTables = Table::where(['contract_id' => $receipt->contract_id])->get();
            $tables = ReceiptEntry::select('table_id', 'tables.name as name')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->where(['receipt_entries.contract_id'=> $receipt->contract_id, 'type'=>1])->groupBy('receipt_entries.table_id')->orderBy('name', 'ASC')->get();
            // return  var_dump($tables);
            $currentReceiptEntries = ReceiptEntry::where(['receipt_id'=>$id, 'type' => 2])->get();
            foreach ($currentReceiptEntries as $in => $entry) {$entry->table = Table::find($entry->table_id);}
            $receipt->theContract = Contract::find($receipt->contract_id);
            $receipt->theClient = Client::find($receipt->client_id);

            $items = StoreItem::all();
            $boxes = StoreBox::all();
            
            $vars = [
                'receipt'                   => $receipt,
                'items'                     => $items,
                'boxes'                     => $boxes,
                'tables'                    => $tables,
                'receipt_entries'           => $currentReceiptEntries,
                'largeTablesCredit'         => $receipt->theContract->getLargeTablesCredit(),
            ];

            return view('admin.operating.output.entries.create', $vars);
        } 
        else {return redirect () -> route ('receipts.home') -> with (['error' => 'السند المطلوب غير موجود']);}
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(DeliveryEntryCreateRequest $request)
    {
        //check if the table is exists
        $table = Table::find($request->table_id);
        
        
        
        $receipt = Receipt::find($request->receipt_id); // find the receipt
        $contract = Contract::find($receipt->contract_id); // find the contract
        if ($contract->isActive()) { // if the contract is approved and still have time
            // create new arrange receipt entry
            try { //Try saving record
            $entry = ReceiptEntry::create([
                
                'type'              => $receipt-> type,
                'table_id'          => $request->table_id,
                'item_id'           => null != $request->item_id ? $request->item_id : 2,
                'table_size'        => $table->size ,
                'box_size'          => null != $request->box_size ? $request->box_size : 2,
                
                'inputs'            => 0,
                'outputs'           => intval($request->outputs),
                
                'receipt_id'        => $receipt->id,
                'receipt_type'      => $receipt->type,
                
                'client_id'         => $receipt->client_id,
                'contract_id'       => $contract->id,
                'created_by'        => auth()->user()->id,
            ]);
            
                
                
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
        $entry = ReceiptEntry::find($request->id);
        $entry -> outputs       = intval($request->outputs) ;
        $entry -> updated_by    = auth()->user()->id;
        //return $request->copy;
        try {// Update entry info;
            $entry->update();
            return redirect()->back()->with(['success' => 'تم تحديث البيانات بنجاح']);
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
