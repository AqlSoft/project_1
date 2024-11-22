<?php

namespace App\Http\Controllers\Admin;

// Models
use App\Models\ReceiptEntry;
use App\Models\Receipt;

// Controllers
use App\Http\Controllers\Controller;


use Illuminate\Http\Request;

class StockController extends Controller
{
    private static $type = 5;
    
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($tab=1)
    {
        $confirmation = $tab == 2 ? 'approved' : 'inprogress';
        $receipts = Receipt::select('receipts.*', 'clients.name as client_name', 'contracts.s_number as contract_serial')
            ->join('clients', 'clients.id', '=', 'receipts.client_id')
            ->join('contracts', 'contracts.id', '=', 'receipts.contract_id')
            ->where(['receipts.type' => 1, 'receipts.confirmation'=>$confirmation])->orderBy('s_number', 'ASC')->paginate(10);
        foreach($receipts as $in => $receipt) {
            $receipt->total_inputs = ReceiptEntry::where(['receipt_id'=>$receipt->id])->sum('inputs');
        }

        $vars = [
            'receipts'                  => $receipts,
            'tab'                       => $tab,
        ];
       return view('admin.operating.stock.receipts.all', $vars);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return var_dump('hello');
        $contracts = Contract::select('contracts.*', 'clients.name as client_name')
        ->join('clients','clients.id','=','contracts.client')
        ->where(['contracts.status'=>1])->get();
        $lir = Receipt::where(['type' => 1])->orderBy('id', 'desc')->first();
        
        $vars = [
            'lir'                       => $lir != null ? intval($lir->s_number, 10) +1 : '000001',
            'contract_id'               => $id,
            'contracts'                 => $contracts,
            'type'                      => $id
        ];
        return view('admin.operating.input.receipts.create', $vars);
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
