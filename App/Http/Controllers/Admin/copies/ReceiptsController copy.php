<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Client;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\ReceiptEntry;
use App\Models\Table;
use App\Models\StoreItem;
use App\Models\StoreBox;
class ReceiptsController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function home()
    {
        return view('admin.operating.receipts.home');
    }

    /**
    * Display a listing of the resource.
    *
    * @return \Illuminate\Http\Response
    */
    public function all($tab=1)
    {
        
        $receipts = Receipt::select('receipts.*', 'clients.name as clientName', 'contracts.s_number as contractNumber')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type'=>$tab, 'receipts.status'=>1, 'receipts.confirmation'=>'approved'])->orderBy('id', 'ASC')->paginate(10);
            // return var_dump($in[0]);

        $vars = [
            'receipts'          => $receipts,
            'type'              => $tab,
            
        ];

        return view('admin.operating.receipts.all', $vars);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function input_receipts($tab = 1) {

        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract', ReceiptEntry::raw('SUM(tableItemQty) AS total_boxes'))
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('receipt_entries', 'receipt_entries.receipt_id', '=', 'receipts.id')
            ->groupBy('receipts.id')
            ->where(['receipts.type' => 1, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(20);
            
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $tab
        ];
       return view('admin.operating.input.receipts.all', $vars);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function inventory_receipts($tab = 1) {

        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => 4, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $tab
        ];
       return view('admin.operating.inventory.receipts.all', $vars);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_input_receipts(Request $req) {
        $confirmation = $req->tab == 2 ? 'approved' : 'inprogress';
        $query = intval($req->search);
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract', ReceiptEntry::raw('SUM(tableItemQty) AS total_boxes'))
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('receipt_entries', 'receipt_entries.receipt_id', '=', 'receipts.id')
            ->groupBy('receipts.id')
            ->where(['receipts.type' => 1, 'receipts.confirmation'=>$confirmation])
            ->where('receipts.s_number' , 'LIKE', "%{$query}%")
            ->orderBy('s_number', 'ASC')->paginate(30);
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $req->tab
        ];
       return view('admin.operating.input.receipts.search', $vars);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function parked_receipts($tab) {
        $ipr = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.status' => 4])->orderBy('id', 'ASC')->paginate(10);
                
        $vars = [
            'receipts'              => $ipr,
            'type'                  => $tab,
            
        ];
       return view('admin.operating.parked.receipts.home', $vars);
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  output_receipts($tab = 1) {
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract', ReceiptEntry::raw('SUM(tableItemQty) AS total_boxes'))
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('receipt_entries', 'receipt_entries.receipt_id', '=', 'receipts.id')
            ->groupBy('receipts.id')
            ->where(['receipts.type' => 2, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $tab
        ];
        return view('admin.operating.output.receipts.all', $vars);
    }
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search_output_receipts(Request $req) {
        $confirmation = $req->tab == 2 ? 'approved' : 'inprogress';
        $query = intval($req->search);
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract',ReceiptEntry::raw('SUM(tableItemQty) AS total_boxes'))
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('receipt_entries', 'receipt_entries.receipt_id', '=', 'receipts.id')
            ->groupBy('receipts.id')
            ->where(['receipts.type' => 2, 'receipts.confirmation'=>$confirmation])
            ->where('receipts.s_number' , 'LIKE', "%{$query}%")
            ->orderBy('s_number', 'ASC')->paginate(10);
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $req->tab
        ];
       return view('admin.operating.output.receipts.search', $vars);
    }


        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function  arrange_receipts($tab = 1) {
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.name as the_client', 'contracts.s_number as the_contract')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => 3, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        
        $vars = [
            'receipts'                  => $receipts,
            'type'                      => $tab
        ];
        return view('admin.operating.arrange.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInputReceipt($id)
    {
        $contracts = Contract::where(['status' => 1])->get();

        
        
        foreach($contracts as $t => $contract) {$contract->theClient = Client::find($contract->client);}
        
        $lir = Receipt::where(['type' => 1])->orderBy('id', 'desc')->first();
        $lor = Receipt::where(['type' => 2])->orderBy('id', 'desc')->first();

        $s_number = str_pad(1, 9, date('y').'0000000000', STR_PAD_LEFT); 
        $vars = [
            'lir'                       => $lir != null ? intval($lir->s_number, 10) +1 : $s_number,
            'lor'                       => $lor != null ? intval($lor->s_number, 10) +1 : $s_number,
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'type'                      => $id
        ];
        return view('admin.operating.input.receipts.create', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createInventoryReceipt($id)
    {
        $contracts = Contract::where(['status' => 1])->get();

        
        
        foreach($contracts as $t => $contract) {$contract->theClient = Client::find($contract->client);}
        
        $sn = Receipt::where(['type' => 4])->orderBy('id', 'desc')->first();

        $s_number = str_pad(1, 9, date('y').'1300000000', STR_PAD_LEFT); 
        $vars = [
            'the_serial'                => $sn != null ? intval($sn->s_number, 10) +1 : $s_number,
            
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'type'                      => $id
        ];
        return view('admin.operating.inventory.receipts.create', $vars);
    }
    
     /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function createOutputReceipt($id)
    {
        $contracts = Contract::where(['status' => 1])->get();
        
        foreach($contracts as $t => $contract) {$contract->theClient = Client::find($contract->client);}
        
        $rs = Receipt::where('type',2)->OrderBy('id', 'DESC')->first()->s_number;
        $the_serial = str_pad($rs+1, 10, '45107'.'0000000', STR_PAD_LEFT) ;

        
        $vars = [
            'the_serial'                => $the_serial,
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'type'                      => $id
        ];
        return view('admin.operating.output.receipts.create', $vars);
    }
    
    public function test () {
        return view('admin.clients.test');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if ($request->type == 2) {
            return redirect()->back()->with(['error' => 'لا يوجد بضاعة لإخراجها على هذا العقد، قم بإدخال البضاعة أولا لتتمكنم من اخراجها']);
        }
        $recipt = new Receipt();
        $ex = Receipt::where(['contract_id'=> $request->contract, 'driver' => $request->driver, 'greg_date' => $request->greg_date])->first();
        $rs = count(Receipt::all());
        $recipt->s_number = str_pad($rs, 8, 'IN0000', STR_PAD_LEFT) +1;

        $recipt->type = $request->type;
        $recipt->s_number = $request->s_number;

        $recipt->greg_date = $request->greg_date_input;
        $recipt->hij_date = $request->hij_date_input;
        $recipt->contract_id = explode(',',$request->contract)[0];
        $recipt->client_id = explode(',',$request->contract)[1];
        $recipt->driver = $request->driver;
        $recipt->status = 1;
        $recipt->farm = $request->farm == null ? 'غير معرف' : $request->farm;
        $recipt->notes = $request->notes == null ? 'لا يوجد ملاحظات' : $request->notes;

        $recipt->created_by = auth()->user()->id;
        $recipt->created_at = date('Y-m-d H:i:s');
        $destination = $receipt->type==1?'receipt.entry.create':'receipt.entry.out';
        if ($recipt->save()) {
            return redirect()->back()->with(['success' => 'تم انشاء سند إدخال بنجاح، يمكنك الان استقبال وتخزين البضاعة على السند.']);
        }
    }

    public function storeInputReceipt(Request $request)
    {
        if ($request->type == 2) {
            return redirect()->back()->with(['error' => 'لا يوجد بضاعة لإخراجها على هذا العقد، قم بإدخال البضاعة أولا لتتمكنم من اخراجها']);
        }

        if (Receipt::where(['s_number'=>$request->s_number])->first()) {
            return redirect()->back()->with(['error' => 'الرقم المسلسل مستخدم مسبقا']);
        }

        if ($request->contract == 'no_client') {
            return redirect()->back()->with(['error' => 'من فضلك اختر العميل']);
        }

        $recipt = new Receipt();
        $ex = Receipt::where(['contract_id'=> $request->contract, 'driver' => $request->driver, 'greg_date' => $request->greg_date])->first();
        $rs = count(Receipt::all());
        $recipt->s_number = str_pad($rs, 8, trim(date('m'), 0).'000000', STR_PAD_LEFT) +1;

        //return var_dump ($request->greg_date_input);
        $recipt->type = $request->type;
        $recipt->s_number = $request->s_number;

        $recipt->greg_date = $request->greg_date_input;
        $recipt->hij_date = $request->hij_date_input;
        $recipt->contract_id = explode(',',$request->contract)[0];
        $recipt->client_id = explode(',',$request->contract)[1];
        $recipt->driver = $request->driver;
        $recipt->status = 1;
        $recipt->farm = $request->farm == null ? 'غير معرف' : $request->farm;
        $recipt->notes = $request->notes == null ? 'لا يوجد ملاحظات' : $request->notes;

        $recipt->created_by = auth()->user()->id;
        $recipt->created_at = date('Y-m-d H:i:s');
        
        if ($recipt->save()) {
             return redirect()->back()->withInput()->with(['success' => 'تم انشاء سند إدخال بنجاح، يمكنك الان استقبال وتخزين البضاعة عل على السند.']);
        }
    }

    public function storeOutputReceipt(Request $request)
    {
        $recipt = new Receipt();

        if (Receipt::where(['s_number'=>$request->s_number])->first()) {
            return redirect()->back()->with(['error' => 'الرقم المسلسل مستخدم مسبقا']);
        }

        if ($request->contract == 'no_client') {
            return redirect()->back()->with(['error' => 'من فضلك اختر العميل']);
        }

        $ex = Receipt::where(['contract_id'=> $request->contract, 'driver' => $request->driver, 'greg_date' => $request->greg_date])->first();
        $rs = Receipt::where('type',2)->count();
        $recipt->s_number = str_pad($rs, 10, trim(date('m'), 0).'000000', STR_PAD_LEFT) +1;

        $recipt->type = $request->type;
        $recipt->s_number = $request->s_number;

        // return $request;
        $recipt->greg_date = $request->greg_date;
        // return $request;
        $recipt->hij_date = $request->hij_date_input;
        $recipt->contract_id = explode(',',$request->contract)[0];
        $recipt->client_id = explode(',',$request->contract)[1];
        $recipt->driver = $request->driver;
        $recipt->status = 1;
        $recipt->farm = $request->farm == null ? 'غير معرف' : $request->farm;
        $recipt->notes = $request->notes == null ? 'لا يوجد ملاحظات' : $request->notes;

        $recipt->created_by = auth()->user()->id;
        $recipt->created_at = date('Y-m-d H:i:s');
        
        if ($recipt->save()) {
            return redirect()->back()->withInput()->with(['success' => 'تم انشاء سند إخراج بنجاح، يمكنك الان اخراج البضاعة بموجب هذا السند.']);
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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $r = Receipt::find($id);
        $c = ReceiptEntry::where('receipt_id',  $id)->where('tableItemQty', '>', 0)->count();
        if ($c == 0) {
            return redirect ()->back()-> with (['warning' => 'انت بتستهبل؟']);
        }
        
        $r->confirmation = 'approved';
        if ($r->update()) {
            return redirect ()->back()-> with (['success' => 'تم اعتماد السند، يمكنك الان الطباعة أو المشاركة مع العميل']);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function input_receipts_view($id)
    {
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.input.receipts.print', $vars);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function output_receipts_view($id)
    {
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.output.receipts.print', $vars);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function review($id)
    {
        //
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.input.receipts.review', $vars);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_input_receipts($id)
    {
        //
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.input.receipts.print', $vars);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_output_receipts($id)
    {
        //
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.output.receipts.print', $vars);


    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function print_arrange_receipts($id)
    {
        //
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.arrange.receipts.print', $vars);


    }

    
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function log()
    {
        //
       
        $vars = [
            'receipts' => []
        ];
        return view('admin.operating.receipts.log', $vars);


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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editInputReceipt($id)
    {
        //
        $receipt = Receipt::find($id);
        
        if (null == $receipt) {
            return redirect()->route('receipts.input_receipts', [1])->with(['error' => 'انت تحاول الوصول إلى سند غير موجود، من فضلك استخدم الروابط ولا تحاول الوصول المباشر إلى السندات']);
        } 
        // if ($receipt->confirmation == 'approved') {
        //     return redirect()->route('receipts.input_receipts', [1])->with(['error' => 'لا يمكن تعديل سند معتمد من الإدارة، يلزمك إلغاء التفعيل أولا لكى تتمكن من التعديل.']);
        // }
            $receipt->the_client = Client::select('name')->where('id', $receipt->client_id)->first();
            $receipt->the_contract = Contract::select('s_number')->where('id', $receipt->contract_id)->first();
            $vars = [
                'item'       => $receipt,
                
            ];
            return view ('admin.operating.input.receipts.edit', $vars);
    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editInventoryReceipt($id)
    {
        //
        $receipt = Receipt::find($id);
        if (null != $receipt) {
            $receipt->the_client = Client::select('name')->where('id', $receipt->client_id)->first();
            $receipt->the_contract = Contract::select('s_number')->where('id', $receipt->contract_id)->first();
            $vars = [
                'item'       => $receipt,
                
            ];
            return view ('admin.operating.inventory.receipts.edit', $vars);
        } return redirect()->route('receipts.inventory_receipts', [1])->with(['error' => 'انت تحاول الوصول إلى سند غير موجود، من فضلك استخدم الروابط ولا تحاول الوصول المباشر إلى السندات']);

    }

        /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function editOutputReceipt($id)
    {
        //
        $receipt = Receipt::find($id);
        if (null != $receipt) {
            $receipt->the_client = Client::select('name')->where('id', $receipt->client_id)->first();
            $receipt->the_contract = Contract::select('s_number')->where('id', $receipt->contract_id)->first();
            $vars = [
                'item'       => $receipt,
                
            ];
            return view ('admin.operating.output.receipts.edit', $vars);
        } return redirect()->route('receipts.input_receipts', [1])->with(['error' => 'انت تحاول الوصول إلى سند غير موجود، من فضلك استخدم الروابط ولا تحاول الوصول المباشر إلى السندات']);

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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateInputReceipt(Request $request)
    {
        //

        $receipt = Receipt::find($request->id);
        if($receipt->driver == $request->driver && $receipt->farm == $request->farm && $receipt->notes == $request->notes && $receipt->s_number == $request->s_number) {
            return redirect()->back()->with(['error'=> 'لا يوجد تعديلات لحفظها.']);
        }
        $receipt->driver = $request->driver;
        $receipt->farm = $request->farm;
        $receipt->notes = $request->notes;
        $receipt->s_number = $request->s_number;

        $receipt->updated_by = auth()->user()->id;
        $receipt->updated_at = date('Y-m-d H:i:s');
        if($receipt->update()) {
            return redirect()->back()->with(['success'=> 'تم تحديث بيانات السند بنجاح.']);
        }
    }
    
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function displayReceiptInfo(Request $request)
    {
        $receipt = Receipt::find($request->id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_id' => $request->id])->get();
        $tables = Table::where(['table_status' => 0])->orWhere(['table_status'=>1, 'contract_id'=>$receipt->contract_id])->get();
        $items = StoreItem::all();
        $boxes = StoreBox::all();

        $view = [ 1 => 'input', 2 => 'output', 3 => 'arrange', 4 => 'inventory'];

        $vars = [
            'items'                 => $items,
            'boxes'                 => $boxes,
            'tables'                => $tables,
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view("admin.operating.{$view[$receipt->type]}.receipts.info", $vars);
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Receipt::find($id);
    
        try {
            $item->delete();
            return redirect()->back()->withSuccess('تم حذف السند بنجاح');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('خطأ، لا يمكنك حذف سند مرتبط بسجلات أخرى.');
        }
       
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function park($id)
    {
        $item = Receipt::find($id);

        $item->status = 4;
        $item->confirmation = 'inprogress';
    
        try {
            $item->update();
            return redirect()->back()->withSuccess('تمت إتاحة السند للتعديل بنجاح');
        } catch (\Illuminate\Database\QueryException $e) {
            return redirect()->back()->withError('خطأ، لا يمكنك حذف بيانات سند مرتبط بسجلات أخرى.');
        }
       
    }
}
