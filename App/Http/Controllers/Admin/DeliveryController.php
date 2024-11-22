<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Contract;
use App\Models\Contact;
use App\Models\Receipt;
use App\Models\Country;
use App\Models\Client;
use App\Models\Driver;
use App\Models\Table;
use App\Models\Admin;
use App\Models\Truck;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;

class DeliveryController extends Controller
{
    

    protected static $type = 2;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    
    public function index($tab=1)
    {
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.a_name as client_name', 'contracts.s_number as contract_serial', 'admins.userName as the_admin')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
            
        foreach($receipts as $in => $receipt) {
            $receipt->total_outputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('outputs');
        }
        $vars = [
            'receipts'                  => $receipts,
            'tab'                      => $tab
        ];
       return view('admin.operating.output.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $contracts = Contract::select('contracts.*', 'clients.a_name as client_name')
        ->join('clients','clients.id','=','contracts.client_id')
        ->where(['contracts.status'=>1])->get();
        $lor = Receipt::where(['type' => self::$type])->orderBy('id', 'desc')->first();
        $last5 = Receipt::select('receipts.*', 'clients.a_name as clientName', 'contracts.s_number as contractSerialNumber', 'admins.userName as theAdmin')
        ->join('clients','clients.id','=','receipts.client_id')
        ->join('contracts','contracts.id','=','receipts.contract_id')
        ->join('admins', 'admins.id', '=', 'receipts.created_by')
        ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>'inprogress'])->orderBy('id', 'desc')->limit(5)->get();
        foreach($last5 as $in => $record) {
            $record->total_outputs = ReceiptEntry::where(['receipt_id'=>$record->id])->sum('outputs');
        }
        $vars = [
            'trucks'                    => Truck::all(),
            'contries'                  => Country::all(),
            'contacts'                  => Contact::all(),
            'drivers'                   => Driver::all(),
            'lor'                       => $lor != null ? intval($lor->s_number, 10) + 1 : '000001',
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'confirmation'              => 'inprogress',
            'type'                      => self::$type,
            'last5'                     => $last5
        ];
        return view('admin.operating.output.receipts.create', $vars);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if (Receipt::where(['s_number'=>$request->s_number])->first()) {
            return redirect()->back()->with(['error' => 'الرقم المسلسل مستخدم مسبقا']);
        }
        
        if (!is_numeric($request->contract)) {
            return redirect()->back()->with(['error' => 'من فضلك اختر العميل']);
        }
        
        $recipt = Receipt::create(
            [
                'type'          => self::$type,
                'client_id'     => Contract::find($request->contract)->client_id,
                's_number'      => $request->s_number,
                
                'greg_date'     => $request->greg_date,
                'hij_date'      => $request->hijri_date,
                
                'contract_id'   => $request->contract,
                'driver'        => $request->driver == null ? 1 : $request->driver,
                'farm'          => $request->farm == null ? 'غير معرف' : $request->farm,
                'notes'         => $request->notes == null ? 'لا يوجد ملاحظات' : $request->notes,
                
                'status'        => 1,
                'created_by'    => auth()->user()->id,
                'updated_by'    => auth()->user()->id,
            ]
        );
        try {
            $recipt->save();
            return redirect()->back()->withInput()->with(['success' => 'تم انشاء سند إدخال بنجاح، يمكنك الان استقبال وتخزين البضاعة عل على السند.']);
        } catch(Exception $e) {
            return redirect()->back()->withInput()->with(['error' => 'لم تنجح عملية انشاء سند بسبب: '.$e]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function view(Request $request)
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

        $receipt->total_outputs      = $entries->sum('outputs');
        $vars = [
            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view("admin.operating.output.receipts.info", $vars);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $receipt = Receipt::find($id);
        
        if (null == $receipt) {
            return redirect()->route('delivery.home', [1])->with(['error' => 'انت تحاول الوصول إلى سند غير موجود، من فضلك استخدم الروابط ولا تحاول الوصول المباشر إلى السندات']);
        } 
        if ($receipt->confirmation == 'approved') {
            return redirect()->route('delivery.home', [1])->with(['error' => 'لا يمكن تعديل سند معتمد من الإدارة، يلزمك إلغاء التفعيل أولا لكى تتمكن من التعديل.']);
        }
        $contracts = Contract::select('contracts.*', 'clients.a_name as client_name')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $vars = [
            'trucks'                    => Truck::all(),
            'contries'                  => Country::all(),
            'drivers'                   => Driver::all(),
            'contracts'                 => $contracts,
            'receipt'                   => $receipt,
        ];
            return view ('admin.operating.output.receipts.edit', $vars);
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
        $contract = Contract::find($request->contract);
        $receipt = Receipt::edit($request->id, [
            'contract_id'       => $contract->id,
            'client_id'         => $contract->client,
            'driver'            => $request->driver,
            'farm'              => $request->farm,
            'notes'             => $request->notes,
            's_number'          => $request->s_number,
            'updated_by'        => auth()->user()->id
        ]);

        try{
            $receipt->update();
            return redirect()->back()->with(['success'=> 'تم تحديث بيانات السند بنجاح.']);
        } catch (Exception $e) {
            return redirect()->back()->with(['error'=> 'لم يتم تعديل السند بسبب:'.$e]);
        }
    }

        /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req) {
        $confirmation = $req->tab == 2 ? 'approved' : 'inprogress';
        $query = intval($req->search);
        $receipts = Receipt::select('receipts.*', 'clients.a_name as the_client', 'contracts.s_number as the_contract', 'admins.userName as the_admin')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])
            ->where('receipts.s_number' , 'LIKE', "%{$query}%")
            ->orderBy('s_number', 'ASC')->paginate(10);
            foreach($receipts as $in => $receipt) {
                $receipt->total_outputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('outputs');
            }
        $vars = [
            'receipts'                  => $receipts,
            'tab'                      => $req->tab
        ];
       return view('admin.operating.output.receipts.search', $vars);
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
        $c = ReceiptEntry::where('receipt_id',  $id)->where('outputs', '>', 0)->count();
        if ($c == 0) {
            return redirect ()->back()-> with (['error' => 'انت بتستهبل؟، السند خال من السجلات. ']);
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
    public function print($id)
    {
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $receipt->theDriver = Driver::find($receipt->driver);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_entries.receipt_id' => $id])->get();
         
        $receipt->total_outputs      = $entries->sum('outputs');
        $vars = [

            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.output.receipts.print', $vars);
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
        } catch (Exception $e) {
            return redirect()->back()->withError('خطأ، لا يمكنك حذف بيانات سند مرتبط بسجلات أخرى.');
        }
       
    }

    /* مؤقت */
    public function deletedReceipts () {
        $receipts = ReceiptEntry::distinct('receipt_id')
        ->where('receipt_entries.type', 4)
        ->get();
        $deleted = [];
        foreach ($receipts as $receipt) {
            if (!Receipt::find($receipt->receipt_id)) {
                $deleted[] = $receipt;
            }
        }
        $vars = [
            'deleted' => $deleted,
            'receipts'    => $receipts
        ];
        return view('admin.operating.receipts.deleted', $vars);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $entries = ReceiptEntry::where(['receipt_id'=>$id])->get ();
        if (count($entries)){
            return redirect () -> back()->with(['error'=>'لا يمكنك فعل ذلك، هناك سجلات مرتبطة بهذا السند.']);
        } else {
            $item = Receipt::find($id);
            try {
                $item->delete();
                return redirect()->back()->withSuccess('تم حذف السند بنجاح');
            } catch (Exception $e) {
                return $e;
                return redirect()->back()->withError('خطأ، لا يمكنك حذف سند مرتبط بسجلات أخرى.');
            } 
        }

    }
}
