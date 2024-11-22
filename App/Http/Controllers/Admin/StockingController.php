<?php

namespace App\Http\Controllers\Admin;

// Models
use App\Models\ReceiptEntry;
use App\Models\Receipt;
use App\Models\Contract;
use App\Models\Contact;
use App\Models\Client;

// Controllers
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class StockingController extends Controller
{
    private static $type = 6;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab=1)
    {
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.a_name as client_name', 'contracts.s_number as contract_serial')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => self::$type, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        foreach($receipts as $in => $receipt) {
            $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
        }

        $vars = [
            'receipts'                  => $receipts,
            'tab'                       => $tab,
        ];
       return view('admin.operating.stocking.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        $contracts = Contract::select('contracts.*', 'clients.a_name as client_name')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $lir = Receipt::where('type', 6)->orderBy('id', 'desc')->first();
        // return $lir;
        $vars = [
            'lir'                       => $lir != null ? intval($lir->s_number, 10) +1 : '000001',
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'contacts'                  => Contact::all(),
            'type'                      => $id
        ];
        return view('admin.operating.stocking.receipts.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $taken_sn = Receipt::where(['s_number'=>$request->s_number])->first();
        $contract = Contract::find($request->contract);
        if (null == $contract) {
            return redirect()->back()->withInput()->with(['error'=>'قم باختيار عقد أو عميل لاتمام السند']);
        }
        if ($taken_sn) {
            return redirect()->back()->withInput()->with(['error'=>'الرقم المسلسل مأخوذ بالفعل']);
        }
// return $contract;
        try {
            Receipt::create([
                'id'                => uniqid(),
                'greg_date'         =>	$request->greg_date,
                'hij_date'          =>	$request->hijri_date,
                'type'              =>	$request->type,
                'contract_id'       =>	$request->contract,
                'client_id'         =>	$contract->client,
                'contact'           =>	$request->contact,
                'reason'            =>	$request->reason,
                'notes'             =>	$request->notes,
                's_number'          =>	$request->s_number,
            ])->save();
            return redirect()->back()->with(['success'=>'تم حفظ السند بنجاح']);
        } catch (QueryException $qe) {
            return redirect()->back()->with(['error'=>'لم يتم حفظ السند بسبب: '.$qe]);
        }

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function entries_create($id)
    {
        //

        $receipt = Receipt::find($id);
        $contract = Contract::find($receipt->contract_id);
        // return $contract;
        $client = Client::find($receipt->client_id);

        $vars = [
            'receipt' => $receipt,
            'contract' => $contract,
            'client' => $client,
            'tables' => [],
        ];
        return view('admin.operating.stocking.entries.create', $vars);
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
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
