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
use App\Models\ContractPallets;

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
        $contract = Contract::find($receipt->contract_id);
        foreach ($entries as $in => $entry) {$entry->table = Table::find($entry->table_id);}

        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);

        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $cp = new ContractPallets();

        //$cp->largePalletsCredit = $contract->pallets(2);
        //$cp->smallPalletsCredit = $contract->pallets(1);
        
        $vars = [
            'pallets'                   => $cp,
            'receipt'                   => $receipt,
            'items'                     => $items,
            'boxes'                     => $boxes,
            'entries'                   => $entries,
            'tables'                    => $tables 
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

    public function view($id)
    {
        $receipt = Receipt::find($id);
        
    
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as table_name', 'store_items.name as item_name', 'store_boxes.name as box_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.receipt_id'=> $id])->get();
        $tables = ReceiptEntry::groupBy('table_id')->select('receipt_entries.table_id', 'tables.name as table_name')
        ->join('tables','tables.id','=','receipt_entries.table_id')
        ->where(['receipt_entries.contract_id'=>$receipt->contract_id])->get();
        
        $vars = [
            'client'=>Client::find($receipt->client_id),
            'contract'=>Contract::find($receipt->contract_id),
            'items' => StoreItem::all(), 
            'boxes' => StoreBox::all(), 
            'receipt'=>Receipt::find($id),
            'entries'=>$entries,
            'tables'=>$tables,
            'copy'=>1
        ];
        return view('admin.operating.entries.create', $vars);
    }
    public function create_inv($id) {
        $receipt = Receipt::find($id);
        $receipt->client = Client::where('id',$receipt->client_id)->first();
        $receipt->contract = Contract::where('id',$receipt->contract_id)->first();
        if (!$receipt == null) {
            $cTables = ReceiptEntry::where(['receipt_entries.contract_id' => $receipt->contract_id])
            ->select ('table_id', 'table_size', 'receipt_entries.contract_id', 'tables.name as tableName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->groupBy('table_id', 'contract_id', 'table_size')->get();
           
            $tablesArray = $cTables->sortBy('tableName');
            foreach ($tablesArray as $i => $table) {
                $table->itemsArray = ReceiptEntry::groupBy('item_id')->select('item_id', 'store_items.name as itemName')->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')->where(['contract_id'=>$table->contract_id, 'table_id'=>$table->table_id])->get();
            
                foreach($table->itemsArray as $ii => $item) {
                    $table->itemsBoxes[$table->id][$item->item_id] = ReceiptEntry::groupBy('box_size')->select('box_size', 'store_boxes.name as boxName')->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')->where(['contract_id'=>$table->contract_id, 'table_id'=>$table->table_id, 'item_id'=> $item->item_id] )->first();
                    
                    foreach ($table->itemsBoxes as $ib => $box) {
                        $inputs = ReceiptEntry::getTotalInputsFor($table->table_id, $table->contract_id, $item->item_id, $box[$item->item_id]->box_size);
                        $outputs = ReceiptEntry::getTotalOutputsFor($table->table_id, $table->contract_id, $item->item_id, $box[$item->item_id]->box_size);
                        $table->itemsBoxes[$table->id][$item->item_id]->totalQty = $inputs - $outputs;
                    }
                }
            }
            $entries = ReceiptEntry::where(['contract_id'=> $receipt->contract->id, 'receipt_type'=>4])->get();
            foreach ($entries as $in => $entry) {
                $entry->table = Table::find($entry->table_id);
                $entry->item = StoreItem::find($entry->item_id);
                $entry->box = StoreBox::find($entry->box_size);
            }
           
                
            $vars = [
                'receipt'                   => $receipt,
                'tables'                    => $tablesArray,
                'entries'                   => $entries,
            ];

            return view('admin.operating.inventory.entries.create', $vars);
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInventoryReceipt(Request $request)
    {
        //check if the table is exists
        $table = Table::find($request->table);

        
        if ($table != null) {
            $receipt = Receipt::find($request->receipt); // find the receipt
            $contract = Contract::find($receipt->contract_id); // find the contract
            // return $contract->isApproved();
            if ($contract->isApproved()) {
                $entry = new ReceiptEntry();
                $now = date('Y-m-d H:i:s');
                $current_user = auth()->user()->id;
                
                $entry -> receipt_type              = $receipt  -> type;
                $entry -> table_id                  = $table    -> id;
                $entry -> receipt_id                = $receipt  -> id;
                $entry -> date                      = $receipt  -> hij_date;
                $entry -> client_id                 = $receipt  -> client_id;
                $entry -> contract_id               = $receipt  -> contract_id;
                
                $entry -> type                      = $request  -> type;
                $entry -> table_size                = $table    -> size;
                $entry -> item_id                   = $request  -> item;
                $entry -> box_size                  = $request  -> box;
                $entry -> tableItemQty              = abs($request  -> totalQty);
                $entry -> created_by                = $current_user;
                $entry -> created_at                = $now;
                
                

                if ($entry->save()) {
                    $table -> table_status          = 1;
                    $table -> updated_by            = $current_user;
                    $table -> updated_at            = $now;
                    if ($table->update()) {
                        return redirect()->back()->with(['success' => 'تمت التسوية بنجاح']);
                    }
                }
            } return redirect()->back()->with(['error' => 'ربما تم تعطيل العقد أو تم توقيفه من قبل الإدارة', 'success'=>'رسالة أخرى'])->withInput();
        } else {
            return redirect()->back()->with(['error' => 'هذه الطبلية غير مدرجة فى مدخلات هذا العقد'])->withInput();
        }
  
    }

    public function store_out(Request $request)
    {
        //check if the table is exists
        $table = Table::where(['id' => $request->table_id])->first();
        //return $table;
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

                
                $entry -> client_id                 = $receipt  -> client_id;
                $entry -> contract_id               = $receipt  -> contract_id;
                $entry -> created_by                = auth()->user()->id;
                $entry -> created_at                = date('Y-m-d H:i:s');
                $entry -> updated_at                = date('Y-m-d H:i:s');

                try {
                    $entry->save();
                    $table -> the_load              = $table -> the_load - $request -> qty;
                    if ($table->the_load == 0) {
                        $table -> table_status          = 0;
                    }
                    if ($table->update()) {
                        return redirect()->back()->with(['success' => 'تمت الإضافة بنجاح']);
                    }
                } catch (Exception $e) {
                    
                    return $e;
                }
            } return redirect ()->back()->withInput()->with(['error'=> 'هنلك مشكلة بالعقد يرجى مراجعة الإدارة']);
        } else {
            return redirect()->back()->with(['error' => 'Table is not exist'])->withInput();
        }
  
    }

    public function saveEntry(Request $request)
    {
        //
        //check if the table is exists
        $table = Table::where(['id' => $request->table_id])->first();
        
        //return $table;
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
                $entry -> tableItemQty              = $request  -> inputs ? intval($request->inputs) : intval($request->outputs) ;
                $entry -> inputs                    = intval($request  -> inputs);
                $entry -> outputs                   = intval($request  -> outputs);
                
                
                $entry -> client_id                 = $receipt  -> client_id;
                $entry -> contract_id               = $receipt  -> contract_id;
                $entry -> created_by                = auth()->user()->id;

                try {
                    $entry->save();
                    $table -> the_load              += intval($request -> inputs);
                    $table -> the_load              -= intval($request -> outputs);

                    if ($table->the_load <= 0) {
                        $table->table_status = 1;
                        $table->contract_id=null;
                        $table->client_id=null;
                    }
                   
                    if ($table->update()) {
                        return redirect()->back()->with(['success' => 'تمت الإضافة بنجاح']);
                    }
                } catch (Exception $e) {
                    
                    return $e;
                }
            } return redirect ()->back()->withInput()->with(['error'=> 'هنلك مشكلة بالعقد يرجى مراجعة الإدارة']);
        } else {
            return redirect()->back()->with(['error' => 'Table is not exist'])->withInput();
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
        
    }

    public static function isTableExist ($id) {
        return Table::where(['name'=>$id])->first()!=null;
    }


    public function checkTable (Request $req) {
        //البحث عن الطبلية وفقا للرقم المدخل
        $table = Table::where(['name'=>$req->table_id])->first();
        // العمل على جلب البيانات اذا كانت الطبلية موجودة
        if (null != $table) {
        // اذا كانت الحالة = 1 فهذا يعنى أنها تحتوى على بضاعة مخزنة ومرتبطة بعقد وعميل ويجب جلب البيانات
            if ($table->table_status == 1) {
                $record = ReceiptEntry::where (['table_id'=>$table->id])->orderBy('updated_at', 'DESC')->first();
                if (null != $record) {
                    $table = $record;
                    $table->the_client = Client::find($table->client_id)->name;
                }
                
                // $inputs = ReceiptEntry::select(ReceiptEntry::raw('SUM(tableItemQty) AS total_item_qty'))
                //     -> where(['type'=>1, 'contract_id'=>$table->contract_id, 'table_id' => $table->id, 'item_id' => $req->item_id, 'box_size' => $req->box_size])
                //     -> get();
                // $outputs = ReceiptEntry::select(ReceiptEntry::raw('SUM(tableItemQty) AS total_item_qty'))
                //     -> where(['type'=>2, 'contract_id'=>$table->contract_id, 'table_id' => $table->id, 'item_id' => $req->item_id, 'box_size' => $req->box_size])
                //     -> get();
                
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

    public function table_info_to_extract_items(Request $req) {
        $items = ReceiptEntry::groupBy('item_id')->select('item_id', 'store_items.name as item_name') 
        -> join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
        ->where(['table_id'=>$req->table, 'contract_id'=>$req->contract])->get();
        return $items;
    }

    public function item_qty_to_extract_items(Request $req) {
        $inputs = ReceiptEntry::where(['table_id'=>$req->table, 'contract_id'=>$req->contract, 'item_id' => $req->item, 'box_size'=>$req->box])->sum('inputs'); 
        $outputs = ReceiptEntry::where(['table_id'=>$req->table, 'contract_id'=>$req->contract, 'item_id' => $req->item, 'box_size'=>$req->box])->sum('outputs'); 
        $total = intVal($inputs) - intVal($outputs);
        return $total;
    }

    public function item_Box_to_extract_items(Request $req) {
        $boxes = ReceiptEntry::groupBy('box_size')->select('box_size', 'store_boxes.short as name') 
        -> join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
        ->where(['receipt_entries.table_id'=>$req->table,  'receipt_entries.contract_id'=>$req->contract])->get(); 
        return $boxes;
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
        
        return intval($inputs[0]->total_item_qty);
        // return intval($outputs[0]->total_item_qty);
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
    public function tableContents(Request $req)
    {
        //
        $tableInputs = ReceiptEntry::where(['table_id'=>$req->table_id, 'contract_id'=>$req->contract])->sum('inputs');
        $tableOutputs = ReceiptEntry::where(['table_id'=>$req->table_id, 'contract_id'=>$req->contract])->sum('outputs');
        return intval($tableInputs)-intval($tableOutputs);
    }

    /**
     * Returns the items array according to table_id and contract_id
     *
     * @param  Request  $req
     * @return array [item_id] 
     */
    public function tableItemsArray(Request $req)
    {
        //
        $tableItems = ReceiptEntry::groupBy('receipt_entries.item_id')->select('receipt_entries.item_id', 'store_items.name as itemName')
        ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
        ->where(['receipt_entries.table_id'=>$req->table_id, 'receipt_entries.contract_id'=>$req->contract])->get()->toArray();
        
        return $tableItems;
    }

    /**
     * Returns the boxez array according to table_id, item_id and contract_id 
     *
     * @param  Request  $req
     * @return array [box_size] 
     */
    public function tableItemsBoxesArray(Request $req)
    {
        //
        $boxes = ReceiptEntry::groupBy('box_size')->select('box_size')->where(['table_id'=>$req->table_id, 'item_id'=>$req->item_id, 'contract_id'=>$req->contract])->get();
        foreach ($boxes as $box) {$box->boxName=StoreBox::find($box->box_size)->short;}
        return $boxes; //$items;
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
        $entry  -> table_id             = $request->table_id;
        $entry  -> table_size           = $table    -> size;
        $entry  -> item_id              = $request  -> item;
        $entry  -> box_size             = $request  -> box;
        $entry  -> tableItemQty         = $request  -> qty;

        $entry -> updated_by            = $current_user;
        $entry -> updated_at            = $now;
        
        return $table;
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
