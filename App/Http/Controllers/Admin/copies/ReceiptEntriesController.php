<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Models\Receipt;
use App\Models\Contract;
use App\Models\Client;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Table;
use App\Models\TableContent;
use App\Models\ReceiptEntry;

class ReceiptEntriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.clients.receipts.home');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $receipt = Receipt::find($id);
        //var_dump($receipt->contract_id);
        $entries = ReceiptEntry::where(['receipt_id'=>$id, 'contract_id' => $receipt->contract_id])->get();
        $inputs = ReceiptEntry::groupBy('table_id')->select('table_id', ReceiptEntry::raw('SUM(tableItemQty) as total_qty'))
        ->where(['contract_id' => $receipt->contract_id, 'type'=>1])->get();
        $outputs = ReceiptEntry::groupBy('table_id')->select('table_id', ReceiptEntry::raw('SUM(tableItemQty) as total_qty'))
        ->where(['contract_id' => $receipt->contract_id, 'type'=>2])->get();
        $full = 0;
        foreach ($inputs as $t => $in) {
            foreach ($outputs as $o => $out) {
                if ($out->table_id == $in->table_id) {
                    $in->net_qty = intval($in->total_qty) - intval($out->total_qty);
                }
                var_dump($in->net_qty);
            }
            if ($in->net_qty === null ) {$full++;}
        }
        foreach ($entries as $in => $entry) {$entry->table = Table::find($entry->table_id);}
        $receipt->theContract = Contract::find($receipt->contract_id);
       
        $receipt->theClient = Client::find($receipt->theContract->client);
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'receipt'                   => $receipt,
            'items'                     => $items,
            'full'                      => $full,
            'boxes'                     => $boxes,
            'entries'                   => $entries,
            'tables'                    => $tables,
            'largeTablesCredit'         => $receipt->theContract->getLargeTablesCredit(),
        ];

        return view('admin.operating.input.entries.create', $vars);
    }

    public function create_out($id)
    {
        $receipt = Receipt::find($id);
        if (!$receipt == null) {
            $allContractTables = Table::where(['contract_id' => $receipt->contract_id])->get();
            $tables = ReceiptEntry::select('table_id', 'tables.name as name')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->where(['receipt_entries.contract_id'=> $receipt->contract_id, 'type'=>1])->groupBy('receipt_entries.table_id')->get();
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
    public function store(Request $request)
    {
        //check if the table is exists
        $table = Table::where(['name' => $request->table_name])->first();
        
        if ($table != null) {
            $receipt = Receipt::find($request->receipt_id); // find the receipt
            $contract = Contract::find($receipt->contract_id); // find the contract
            // return $contract->isApproved();
            if ($contract->isApproved() && $contract->isActive()) {
                $entry = new ReceiptEntry();
                $now = date('Y-m-d H:i:s');
                $current_user = auth()->user()->id;
                $entry -> type                      = $receipt  -> type;
                $entry -> table_id                  = $table    -> id;
                $entry -> receipt_id                = $receipt  -> id;
                $entry -> date                      = $receipt  -> hij_date;
                $entry -> client_id                 = $receipt  -> client_id;
                $entry -> contract_id               = $receipt  -> contract_id;

                $entry -> table_size                = $table    -> size;
                $entry -> item_id                   = $request  -> item_id;
                $entry -> box_size                  = $request  -> box_size;
                $entry -> tableItemQty              = $request  -> qty;
                $entry -> created_by                = $current_user;
                $entry -> created_at                = $now;
                if ($entry->save()) {
                    $table -> table_status          = 1;
                    $table -> contract_id           = $entry -> contract_id;
                    $table -> client_id             = $entry -> client_id;
                    $table -> the_load              = $table -> the_load + $request -> qty;
                    $table -> updated_by            = $current_user;
                    $table -> updated_at            = $now;
                    if ($table->update()) {
                        return redirect()->back()->with(['success' => 'تمت الإضافة بنجاح']);
                    }
                }
            } return redirect()->back()->with(['error' => 'ربما تم تعطيل العقد أو تم توقيفه من قبل الإدارة', 'success'=>'رسالة أخرى'])->withInput();
        } else {
            return redirect()->back()->with(['error' => 'Table is not exist'])->withInput();
        }
  
    }

    public function store_out(Request $request)
    {
        //check if the table is exists
        $table = Table::where(['id' => $request->table_id])->first();
        // return $table;
        if ($table != null) {
            $receipt = Receipt::find($request->receipt_id); // find the receipt
            $contract = Contract::find($receipt->contract_id); // find the contract

            if ($contract->isApproved() && $contract->isActive()) {
                $entry = new ReceiptEntry();

                $entry -> type                      = $receipt  -> type;
                $entry -> table_id                  = $table    -> id;
                $entry -> receipt_id                = $receipt  -> id;

                $entry -> table_size                = $table    -> size;
                $entry -> item_id                   = $request  -> item_id;
                $entry -> box_size                  = $request  -> box_size;
                $entry -> tableItemQty              = $request  -> qty;

                $entry -> date                      = $receipt  -> hij_date;
                $entry -> client_id                 = $receipt  -> client_id;
                $entry -> contract_id               = $receipt  -> contract_id;
                $entry -> created_by                = auth()->user()->id;
                $entry -> created_at                = date('Y-m-d H:i:s');
                if ($entry->save()) {
                    return redirect()->back()->with(['success' => 'تمت الإضافة بنجاح']);
                }
            }
        } else {
            return redirect()->back()->with(['error' => 'Table is not exist'])->withInput();
        }
  
    }

    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    public static function isTableExist ($id) {
        return Table::where(['name'=>$id])->first()!=null;
    }


    public function checkTable (Request $req) {
        //البحث عن الطبلية وفقا للرقم المدخل
        $table = Table::where(['name'=>$req->table_id])->first();
        // العمل على جلب البيانات اذا كانت الطبلية موجودة
        if ($table) {
        // اذا كانت الحالة = 1 فهذا يعنى أنها تحتوى على بضاعة مخزنة ومرتبطة بعقد وعميل ويجب جلب البيانات
            if ($table->table_status == 1) {
                $table = Table::where(['name'=>$req->table_id])->first();
                $table->the_client = Client::find($table->client_id)->name;
                $table->the_contract = Contract::find($table->contract_id)->s_number;
                return $table;
            }
        }
        
        return $table;
    }
    public function table_contents (Request $req) {
        $table = Table::find($req->table_id) ;
        
        
        $entries = ReceiptEntry::select('item_id', 'box_size', ReceiptEntry::raw('SUM(tableItemQty) AS total_item_qty'))
        -> where(['contract_id'=>$table->contract_id, 'table_id' => $table->id])
        -> groupBy('item_id', 'box_size')
        -> get();
        foreach ($entries as $index => $entry) {$entry->itemName = StoreItem::find($entry->item_id)->name;}
        return $entries;
    }

    
    public function tableItemQty(Request $req)
    {
        $table = Table::find($req->table_id) ;
        $inputs = ReceiptEntry::select(ReceiptEntry::raw('SUM(tableItemQty) AS total_item_qty'))
        -> where(['type'=>1, 'contract_id'=>$table->contract_id, 'table_id' => $table->id, 'item_id' => $req->item_id, 'box_size' => $req->box_size])
        -> get();
        $outputs = ReceiptEntry::select(ReceiptEntry::raw('SUM(tableItemQty) AS total_item_qty'))
        -> where(['type'=>2, 'contract_id'=>$table->contract_id, 'table_id' => $table->id, 'item_id' => $req->item_id, 'box_size' => $req->box_size])
        -> get();
        
        return intval($inputs[0]->total_item_qty) - intval($outputs[0]->total_item_qty);
    }

    public function tableItemBox(Request $req)
    {
        $table = Table::find($req->table_id) ;
        $sizes = ReceiptEntry::select('box_size')
        -> where(['contract_id'=>$table->contract_id, 'table_id' => $table->id])
        -> groupBy('box_size')
        -> get();
        foreach ($sizes as $in => $size) {$size->name = StoreBox::find($size->box_size)->name;}
        return $sizes;
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
        $entry = ReceiptEntry::find($request->id);
        if ($entry->table_id == $request->table && $entry->item_id == $request->item && $entry->box_size == $request->box && $entry->tableItemQty == $request->qty) {
            return redirect()->back()->with(['error' => 'لا يوجد شىء لحفظه']);
        } 
        $table = Table::find($request->table_id);
        $now = date('Y-m-d H:i:s');
        $current_user = auth()->user()->id;

        $oldQty = $entry->tableItemQty;
        $newQty = $request->qty;
        $entry  -> table_size           = $table    -> size;
        $entry  -> item_id              = $request  -> item;
        $entry  -> box_size             = $request  -> box;
        $entry  -> tableItemQty         = $request  -> qty;

        $entry -> updated_by            = $current_user;
        $entry -> updated_at            = $now;
        
        $table -> table_status          = 1;
        $table -> contract_id           = $entry -> contract_id;
        $table -> client_id             = $entry -> client_id;
        $table -> the_load              = $table -> the_load  - $oldQty + $newQty;
        $table -> updated_by            = $current_user;
        $table -> updated_at            = $now;
        // return $table;
        if ($entry->update()) {
            if ($table->update()) {
                return redirect()->back()->with(['success' => 'تم التحديث بنجاح']);
            }
        }

        // return [$entry, $table];
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
        if ($entry) {
            $table = Table::find($entry->table_id);
            
            $table->the_load = $table->the_load - $entry->tableItemQty;
            $table->table_status = $table->the_load > 0 ? 1 : 0;
            $table->contract_id = $table->the_load == 0 ? null : $entry->contract_id;
            $table->client_id = $table->the_load == 0 ? null : $entry->client_id;
            

            if ($table->update()) {
                if ($entry->delete()) {
                    return redirect()->back()->with(['success' => 'تم الحذف']);
                }
            }
        } return redirect()->back()->with(['error' => 'غير موجودة']);  
    }

        /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroyOutputEntry($id)
    {
        $entry = ReceiptEntry::find($id);
        if ($entry) {
            $table = Table::find($entry->table_id);
            
            $table->the_load = $table->the_load - $entry->tableItemQty;
            $table->table_status = $table->the_load > 0 ? 1 : 0;
            $table->contract_id = $table->the_load == 0 ? null : $entry->contract_id;
            $table->client_id = $table->the_load == 0 ? null : $entry->client_id;
            

            if ($table->update()) {
                if ($entry->delete()) {
                    return redirect()->back()->with(['success' => 'تم الحذف']);
                }
            }
        } return redirect()->back()->with(['error' => 'غير موجودة']);  
    }
}
