<?php

namespace App\Http\Controllers\Admin;

use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Contract;
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

class PositionController extends Controller
{

    private static $type = 5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        
        $receipts = Receipt::select('receipts.*', 'admins.userName as the_admin', 'clients.a_name as client_name')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->where(['receipts.type' => self::$type])->orderBy('s_number', 'ASC')->paginate(10);
            
        foreach($receipts as $in => $receipt) {
            $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
        }
        $vars = [
            'receipts'                  => $receipts,
        ];
       return view('admin.operating.position.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $contracts = Contract::select('contracts.*', 'clients.a_name as client_name')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $lir = Receipt::where(['type' => self::$type])->orderBy('id', 'desc')->first();
        $vars = [
            'contracts' => $contracts,
            'lir' => $lir != null ? intval($lir->s_number, 10) +1 : '000001',
        ];
        return view('admin.operating.position.receipts.create', $vars);
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
        $contract = Contract::find($request->contract);
        if (null == $contract) {
            return redirect()->back()->withInput()->with(['error' => 'اختر العقد أو العميل الذى تود أجراء عمليه الترتيب له']);
        }
        $client = Client::find($contract->client);
        // return [$contract, $client];
        try {
            
             Receipt::create([
                'type'          => self::$type,
                's_number'      => $request->s_number,
                
                'greg_date'     => $request->greg_date,
                'hij_date'      => $request->hijri_date,
                
                'client_id'     => $client->id,
                'contract_id'   => $contract->id,
                
                'reason'        => $request->reason == null ? 'غير معرف' : $request->reason,
                'notes'         => $request->notes == null ? 'لا يوجد ملاحظات' : $request->notes,

                'created_by'    => auth()->user()->id,
            ])->save();
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

        $receipt->total_inputs      = $entries->sum('inputs');
        $vars = [

            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view("admin.operating.input.receipts.info", $vars);
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
            return redirect()->route('reception.inputs', [1])->with(['error' => 'انت تحاول الوصول إلى سند غير موجود، من فضلك استخدم الروابط ولا تحاول الوصول المباشر إلى السندات']);
        } 
        if ($receipt->confirmation == 'approved') {
            return redirect()->route('reception.inputs', [1])->with(['error' => 'لا يمكن تعديل سند معتمد من الإدارة، يلزمك إلغاء التفعيل أولا لكى تتمكن من التعديل.']);
        }
        $contracts = Contract::select('contracts.*', 'clients.a_name as client_name')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $vars = [
            'trucks'                    => Truck::all(),
            'contries'                  => Country::all(),
            'drivers'                   => Driver::all(),
            'contracts'     => $contracts,
            'receipt'       => $receipt,
            
        ];
            return view ('admin.operating.input.receipts.edit', $vars);
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
        $receipts = Receipt::select('receipts.*', 'clients.a_name as client_name', 'contracts.s_number as contract_serial', 'admins.userName as the_admin')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])
            ->where('receipts.s_number' , 'LIKE', "%{$query}%")
            ->orderBy('s_number', 'ASC')->paginate(10);
            foreach($receipts as $in => $receipt) {
                $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
            }
        $vars = [
            'receipts'                  => $receipts,
            'tab'                       => $req->tab
        ];
       return view('admin.operating.input.receipts.search', $vars);
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
        $c = ReceiptEntry::where('receipt_id',  $id)->where('inputs', '>', 0)->count();
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
    public function print($id)
    {
        $receipt = Receipt::find($id);
        $receipt->theContract = Contract::find($receipt->contract_id);
        $receipt->theClient = Client::find($receipt->theContract->client);
        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as tableName', 'store_items.name as itemName', 'store_boxes.name as boxName')
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
            ->where(['receipt_entries.receipt_id' => $id])->get();
         
        $receipt->total_inputs      = $entries->sum('inputs');
        $vars = [

            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view('admin.operating.input.receipts.print', $vars);
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
