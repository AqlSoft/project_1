<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
//Requests
use App\http\Requests\ArrangReceiptCreateRequest;

//Models
use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Contract;
use App\Models\Country;
use App\Models\Driver;
use App\Models\Contact;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Table;
use App\Models\Truck;

class ArrangementController extends Controller
{
    private static $type = 3;
    /**
     * Display and listing all of the arrangement receipts resource.
     *
     * @param tab, to filter the resource according to confirmation status 
     * @return \Illuminate\Http\Response
     */
    public function index($tab = 1)
    {
        //
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.a_name as clientAName', 'clients.e_name as clientEName', 'contracts.s_number as the_contract', 'admins.userName as admin_name')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        
            foreach($receipts as $in => $receipt) {
            $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
            $receipt->total_outputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('outputs');
        }

        $vars = [
            'contacts'                  => Contact::all(),
            'receipts'                  => $receipts,
            'tab'                      => $tab,
        ];

        return view('admin.operating.arrange.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $contracts = Contract::select('contracts.id', 'contracts.s_number', 'contracts.client', 'contracts.id','clients.a_name as clientAName', 'contracts.id','clients.e_name as clientEName')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status' => 1])
        ->get();
        
        $lar = Receipt::where(['type' =>  self::$type])->orderBy('id', 'desc')->first();
        $last5 = Receipt::select('receipts.*', 'clients.a_name as clientName', 'contracts.s_number as contractSerialNumber', 'admins.userName as theAdmin')
        ->join('clients','clients.id','=','receipts.client_id')
        ->join('contracts','contracts.id','=','receipts.contract_id')
        ->join('admins', 'admins.id', '=', 'receipts.created_by')
        ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>'inprogress'])->orderBy('id', 'desc')->limit(5)->get();
        foreach($last5 as $in => $record) {
            $record->total_outputs = ReceiptEntry::where(['receipt_id'=>$record->id])->sum('outputs');
        }

        $s_number = str_pad(1, 9, '4515000000', STR_PAD_LEFT); 
        $vars = [
            
            'lar'                       => $lar != null ? intval($lar->s_number, 10) +1 : '000001',
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'contacts'                  => Contact::all(),
            'type'                      => $id,
            'last5'                     => $last5
        ];
        return view('admin.operating.arrange.receipts.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
        if (Receipt::where(['s_number'=>$request->s_number])->first()) {
            return redirect()->back()->with(['error' => 'الرقم المسلسل مستخدم مسبقا']);
        }

        if ($request->contract == 'no_client') {
            return redirect()->back()->with(['error' => 'من فضلك اختر العميل']);
        }

        //return var_dump($request->contact);

        $contract = Contract::find($request->contract);

        $recipt = Receipt::create([
            'type'                  =>  self::$type,
            's_number'              => $request->s_number,
    
            'greg_date'             => $request->greg_date,
            'hij_date'              => $request->hijri_date,
            'contract_id'           => $contract->id,
            'client_id'             => $contract->client,
            'contact'               => $request->contact ? Contact::find($request->contact)->name : 'لم يحضر',
            'reason'                => $request->reason ? $request->reason : 'طلب الإدارة',
            'status'                => 1,
            
    
            'created_by'            => auth()->user()->id,
            'updated_by'            => auth()->user()->id,
        ]);
        
        //return var_dump ($request->greg_date_input);
        

        if ($recipt->save()) {
             return redirect()->back()->withInput()->with(['success' => 'تم انشاء سند ترتيب طبالى بنجاح، يمكنك الان اختيار الطبالى واجراء التعديلات وفقا للسند.']);
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
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $req) {
        $confirmation = $req->tab == 2 ? 'approved' : 'inprogress';
        $query = intval($req->search);
        $receipts = Receipt::select('receipts.*', 'contracts.id','clients.a_name as clientAName', 'contracts.id','clients.e_name as clientEName', 'contracts.s_number as the_contract', 'admins.userName as the_admin', 'drivers.a_name as the_driver')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('drivers', 'drivers.id', '=', 'receipts.driver')
            ->join('admins', 'admins.id', '=', 'receipts.created_by')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])
            ->where('receipts.s_number' , 'LIKE', "%{$query}%")
            ->orderBy('s_number', 'ASC')->paginate(10);
            foreach($receipts as $in => $receipt) {
                $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
                $receipt->total_outputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('outputs');
            }
        $vars = [
            'receipts'                  => $receipts,
            'tab'                      => $req->tab
        ];
       return view('admin.operating.arrange.receipts.search', $vars);
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
        $receipt->total_outputs      = $entries->sum('outputs');
        $vars = [

            'receipt'               => $receipt,
            'entries'               => $entries,
        ];
        return view("admin.operating.arrange.receipts.info", $vars);
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
         
        $receipt->total_inputs = $entries->sum('inputs');
        $receipt->total_outputs = $entries->sum('outputs');
        $vars = [

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
    public function table_info(Request $req)
    {
        $table = Table::find($req->table_id);
        return $table;
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
        $contracts = Contract::select('contracts.*', 'contracts.id','clients.a_name as clientAName', 'contracts.id','clients.e_name as clientEName')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $vars = [
            'contacts'                   => Contact::all(),
            'contracts'     => $contracts,
            'receipt'       => $receipt,
            
        ];
            return view ('admin.operating.arrange.receipts.edit', $vars);
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
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function approve($id)
    {
        $r = Receipt::find($id);
        $c = ReceiptEntry::where('receipt_id',  $id)->count();
        if ($c < 1) {
            return redirect ()->back()-> with (['error' => 'لا يمكن اعتماد سند لا يحتوى على سجلات']);
        } elseif ($c == 1) {
            return redirect ()->route('arrange.entries.create', [$id, 0])-> with (['error' => 'ترتيب الطبالى هى عملية مزدوجة، لا يمكن اعتماد سند يحتوى على سجل مفرد']);
        }
        
        $r->total_inputs = ReceiptEntry::where(['receipt_id'=>$r->id])->sum('inputs');
        $r->total_outputs = ReceiptEntry::where(['receipt_id'=>$r->id])->sum('outputs');
        
        if ($r->total_inputs !== $r->total_outputs) {
            return redirect ()->route('arrange.entries.create', [$id, 0])-> with (['error' => 'لا بد أن تتساوى مجموع الادخالات مع مجموع الاخراجات على السند']);
        }
        
        if (0==$r->total_inputs && 0==$r->total_outputs) {
            return redirect ()->route('arrange.entries.create', [$id, 0])-> with (['error' => 'السند به سجلات لا تحتوى على مخرجات أو مدخلات']);
        }

        $r = Receipt::edit ($id, [
            'confirmation'  => 'approved',
            'updated_by'    => auth()->user()->id
        ]);
        if ($r->update()) {
            return redirect ()->back()-> with (['success' => 'تم اعتماد السند، يمكنك الان الطباعة أو المشاركة مع العميل']);
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

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $item = Receipt::find($id);
        $entries = ReceiptEntry::where(['receipt_id'=>$id])->get();
        if (!count($entries)) {
            try {
                $item->delete();
                return redirect()->back()->withSuccess('تم حذف السند بنجاح');
            } catch (QueryException $e) {
                return redirect()->back()->withError('حدث خطأ أثناء محاولة حذف السند: '.$e);
            }
        } 
        return redirect()->back()->withError('خطأ، لا يمكنك حذف سند مرتبط بسجلات أخرى.');
    
    }
}
