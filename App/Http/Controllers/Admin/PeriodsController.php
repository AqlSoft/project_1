<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\Item;
use App\Models\Period;

use Illuminate\Database\QueryException;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class PeriodsController extends Controller
{

    /**
     * Show the show the periods list.
     *
     * @return \Illuminate\Http\Response
    */
    public function index() {
        $contracts = Contract::where(['status'=>1])->get();
        foreach ($contracts as $contract) {
            // $contract->client = Client::;
            $contract->periods();
            $contract->remaining();
        }
        
        $vars =[ 
            'contracts'=>$contracts,
        ];
        return view ('admin.clients.reports.periods', $vars);
    }
    

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        //
        $contract = Contract::find($id);
        $items = Item::all();

        $vars = [
            'contract'  => $contract,
            'items'     =>$items
        ];
        return view('admin.sales.contracts.periods.create', $vars);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        // Hijri month = 29.530588 Days

        // Get Period Contract
        $contract = Contract::find($request->contract_id);

        
        
        // Get contract end date (ecpiry date)
       
        try {
            $period = Period::create([
                
                'starts_in'     => $request->starts_in,
                'ends_in'       => $request->ends_in,
                'length'        => $request->length,
                'contract_id'      => $contract->id,
                'client_id'        => $contract->client_id,
                'the_order'     => count($contract->periods)+1,
                'the_code'      => $contract->s_number . '-' . count($contract->periods)+1,
                'status'        => 0,
                'created_by'    =>auth()->user()->id, 
                'updated_by'    =>auth()->user()->id, 
            ]);
            
            for ($i=1; $i<=4; $i++) {
                ContractItem::create([
                    'item_id'              =>$i, 
                    'qty'               =>$request->items[$i], 
                    'price'             =>$request->item_price[$i], 
                    'status'            =>1, 
                    'contract_id'          =>$request->contract_id, 
                    'period_id'            =>$period['id'],
                    'created_by'        =>auth()->user()->id, 
                    'updated_by'        =>auth()->user()->id, 
       
                ]);
            }

            $contract->update([
                'ends_in_greg'      => $request->ends_in,
                'ends_in_hij'       => $request->ends_in_hij,
                'updated_by'        => auth()->user()->id,
                'status'            =>1
            ]);
            
            DB::commit();
            return redirect ()->back()->withSuccess('تمت عملية الإضافة بنجاح');
        } catch(QueryException $e) {
            return $e;
        }
        
         $end_date;
        return $request;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function storeInitial(Request $request, $id)
    {
        $contract = Contract::find($id);
        
        DB::beginTransaction();

        try {
            $period = Period::create([
                'starts_in'     => $request->starts_in,
                'ends_in'       => $request->ends_in,
                'length'        => $request->length,
                'contract_id'   => $id,
                'client_id'     => $contract->client_id,
                'the_order'     => count($contract->periods)+1,
                'the_code'      => $contract->s_number . '-' . count($contract->periods)+1,
                'status'        => 1,
                'created_by'    =>auth()->user()->id, 
                'updated_by'    =>auth()->user()->id, 
            ]);
            
            for ($i=1; $i<=4; $i++) {
                ContractItem::create([
                    'item_id'           =>$i, 
                    'qty'               =>$request->items[$i], 
                    'price'             =>$request->item_price[$i], 
                    'status'            =>1, 
                    'contract_id'       =>$id, 
                    'period_id'         =>$period['id'],
                    'created_by'        =>auth()->user()->id, 
                    'updated_by'        =>auth()->user()->id, 
       
                ]);
            }

            $contract->update([
                'ends_in_greg'      => $request->ends_in,
                'ends_in_hij'       => $request->ends_in_hij,
                'updated_by'        => auth()->user()->id,
                'status'            => 1
            ]);
            
            DB::commit();
            return redirect ()->back()->withSuccess('تمت عملية الإضافة بنجاح');
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect ()->back()->withError('فشل فى الإضافة بسبب: '.$e);
        }
        return $request;
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
     * Reset all active periods to inactive and activate the period with givin id.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function changeStatus ($id)
    {
        //
        $period = Period::find($id);

        $contractPeriods = Period::where('contract_id', $period->contract_id)->get();
        foreach ($contractPeriods as $cp) {
            $cp->update(['status'=>0]);
        }
        if ($period->update(['status'=>1])){
            return redirect ()->back()->withSuccess('تمت عملية التفعيل بنجاح');
        } else {
           
            return redirect ()->back()->withError('فشل فى التفعيل بسبب: ');
        }
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
        $p = Period::find($id);
        if (null==$p) {
            return redirect()->back()->withError('ما تبحث عنه غير موجود');
        }
        try {
            $p->delete();
            return redirect()->back()->withSuccess('تم حذف الفترة بنجاح');
        } catch(QueryException $err) {
            return redirect()->back()->withError('لم يتم حذف الفترة بسبب: '.$err);

        }
    }
}
