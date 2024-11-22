<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\ContractPaymentScheduleEntry;
use App\Models\ContractSetting;
use App\Models\MeasuringUnit;
use App\Models\ClientContact;
use App\Models\AccountsInfo;
use App\Models\ContractItem;
use App\Models\ReceiptEntry;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Contract;
use App\Models\Contact;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Period;
use App\Models\Driver;
use App\Models\Table;
use App\Models\Admin;
use App\Models\Item;

use App\Helper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;

class ContractsController extends Controller
{
    //

    public static $scopes = [1=>'فردى', 2=>'مؤسسة', 3=>'شركة', 4=>'مصنع', 5=>'مزرعة', 6=>'تاجر',];
    public static $types = [1=>'عقد أساسى', 2=>'إضافة طبالى', 3=>'تمديد عقد أساسى'];


    public function home () {  
        $contracts = Contract::where([])->orderBy('id', 'ASC')->paginate(10);
        foreach ($contracts as $in => $contract) {
            $contract->owner = Client::find($contract->client); 
            $contract->contract_type = static::$types[$contract->type];
        }
        //var_dump($contracts);
        $vars = [
            'contracts' => $contracts,
        ];

        return view('admin.sales.contracts.home', $vars);
    }
    public function index () {  
        $contracts = Contract::where([])->orderBy('id', 'ASC')->paginate(10);
        foreach ($contracts as $in => $contract) {
            $contract->owner = Client::find($contract->client); 
            $contract->contract_type = static::$types[$contract->type];
        }
        //var_dump($contracts);
        $vars = [
            'contracts' => $contracts,
        ];

        return view('admin.sales.contracts.index', $vars);
    }

    //'DATEDIFF(ends_in_greg, CURDATE()) < 1'
    public function periodEndStatus () {
        $contracts = Contract::where(['status'=>1])->with('the_client')->get();
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

    public function track_tables ($id) {
        $vars['contract'] = Contract::find($id);
        return view ('admin.sales.contracts.track_tables', $vars);
    }

    public function create ($clientId) {
        $client = Client::find($clientId);
       
        if (!$client) {
            return redirect()->route('clients.home')->withError('من فضلك حدد عميلا لتتمكن من إضافة عقد');
        }

        $client = Client::where(['id' => $clientId])->first();
        $clientContracts = Contract::where(['client_id'=>$clientId, ])->get();
        $currentUserCompany = auth()->user()->company;
        $company = AccountsInfo::where(['id' => $currentUserCompany])->first();
        $lastContract = Contract::where([])->orderBy('id', 'DESC')->first();
        $year = explode('-', date('y-m-d'))[0];
        $month = explode('-', date('y-m-d'))[1];
        $lc = $lastContract === null ? str_pad(1, 10, $year . ($month+2) .'000000', STR_PAD_LEFT) : $lastContract->s_number + 1;
        $lc = str_pad(1, 10, $year . ($month) .'000250', STR_PAD_LEFT); 
        $vars = [

            'client'        => $client,
            'items'         => Item::all(),
            'company'       => $company,
            'parent'        => '',
            'clients'       => [],
            'cCode'         => date('ymd').'-'.$clientId.'-'.(count($clientContracts)+1),
            'lastContract' => $lc,
        ];

        return view('admin.sales.contracts.create', $vars);
    }

    public function edit ($id, $tab) {
        $contract = Contract::find($id);
        if (!$contract) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، العقد الذى تبحث عنه غير موجود، ربما تم حذفه، تأكد من الرقم وأعد المحاولة');
        }
        $ratio = 0.8695652174;

        $contract = Contract::where(['id' => $id])->first();
        $items =Item::all();
        $cis = ContractItem::where(['contract_id' => $contract->id])->get();
        $cPymtSchEntries = ContractPaymentScheduleEntry::where(['contract_id'=>$id])->get();
        if (null!=$cPymtSchEntries){
            foreach($cis as $i => $ci) {foreach ($items as $ii => $item) {if ($ci->item_id == $item->id) {$ci->name = $item->a_name;}}}
        }
        $ct = 0;
        foreach ($cis as $ii => $ci) {$ct += $ci->qty * $ci->unit_price * $contract->start_period*$ratio;}
        $cpAmounts = 0;
        foreach($cPymtSchEntries as $cpi => $entry) {$cpAmounts+= $entry->amount;}

        $periods = Period::where(['contract_id'=>$contract->id])->get();

        $client = Client::where(['id' => $contract->client_id])->first();
        $clientContracts = Contract::where(['client_id'=>$client->id, ])->get();
        $currentUserCompany = auth()->user()->company;
        $company = AccountsInfo::where(['id' => $currentUserCompany])->first();
        
        $vars = [
            'periods'       => $periods,
            'contract'      => $contract,
            'ct'            => $ct,
            'payments'      => $cpAmounts,
            'client'        => $client,
            'items'         => $items,
            'pses'          => $cPymtSchEntries,
            'company'       => $company,
            'parent'        => '',
            'tab'           => $tab,
            'cis'           => $cis,
            'clients'       => [],
            'cCode'         => date('ymd').'-'.$client->id.'-'.(count($clientContracts)+1),
            
        ];

        return view('admin.sales.contracts.edit', $vars);
    }
    

    public function editBasicInfo ($id) {
        $contract = Contract::find($id);

        $vars = [
            'contract'      => $contract,
            'client'        => $contract->client
        ];
        return view('admin.sales.contracts.edit.info', $vars);
;    }

    public function store (Request $req, $clientId) {
        
        $client = Client::where(['id' => $clientId])->first();
        //return var_dump($cs);
        
        DB::beginTransaction();
        //return $req;
        try {
            $contract = Contract::create([
                // Basic Info
                'code'             => $req->code,
                'type'             => $req->type,
                's_number'         => $req->s_number,
                'status'           => 1,
                'brief'            => $req->brief,
                
                // Timing
                'in_day_greg'      => $req->day_in_greg,
                'in_day_hij'       => $req->day_in_hijri,
                'client_id'        => $clientId,
                'starts_in_greg'   => $req->starts_in_greg,
                'starts_in_hij'    => $req->starts_in_hijri,
                'ends_in_greg'     => $req->ends_in_greg,
                'ends_in_hij'      => $req->ends_in_hijri,
                'start_period'     => 3,
                'renew_period'     => 1,
    
                // Management
                'created_by'       => auth()->user()->id,
                'created_at'       => date('Y-m-d H:i:s'),
            ]);
            

            $period = Period::create([
                'starts_in'         => $contract->starts_in_greg,
                'ends_in'           => $contract->ends_in_greg,
                'length'            => 3,
                'contract_id'          => $contract->id,
                'client_id'            => $clientId,
                'the_order'         => 1,
                'the_code'          => $contract->s_number . '-01',
                'status'            => 1,
                'created_at'        => date('Y-m-d H:i:s'),
                'created_by'        => auth()->user()->id
            ]);

            for ($i=1; $i<=4; $i++) {
                ContractItem::create([
                    'item_id'           =>$i, 
                    'qty'               =>$req->items[$i], 
                    'price'             =>$req->item_price[$i], 
                    'status'            =>1, 
                    'contract_id'       =>$contract->id, 
                    'period_id'         =>$period['id'],
                    'created_by'        =>auth()->user()->id, 
                    'updated_by'        =>auth()->user()->id, 
       
                ]);
            }
                
            DB::commit();
        } catch (QueryException $e) {
            DB::rollBack();
            return redirect()->back()->withInput()->withError('لم يتم إنشاء عقد ، هناك خطأ حدث أثناء العملية '.$e);
        }
        
        if ($contract && $period) {
            return redirect()->route('contract.edit', [$contract->id, 2])->withSuccess('تم إنشاء عقد جديد بنجاح، يمكنك الان التعديل على العقد وإضافة التفاصيل');
        }
    }

    public function paymentInfo ($id) {
        $contract = Contract::find($id);
        return $contract;
    }

    /** [This method is created to create a new contract period according to the givin request]
     * @param Request $req
     * 
     * @return [type]
     */
    public function createPeriod ($id) {
        $contract = Contract::where('id', $id)->with('the_client')->with('periods')->first();
        
        $vars = [
            'contract'=> $contract
        ];
        return view('admin.clients.reports.contract_info', $vars);
        
    }

    /** [This method is created to create a new contract period according to the givin request]
     * @param Request $req
     * 
     * @return [type]
     */
    public function storePeriod (Request $req) {
        $contractPeriods = Period::where(['contract'])->get();
        $contractPeriodsCount = count($contractPeriods);
        $period = Period::create([
            'starts_in'         => $req->starts_in_greg,
            'ends_in'           => $req->ends_in_greg,
            'length'            => $req->start_period,
            'contract'          => $req->id,
            'client'            => $req->client,
            'the_order'         => 1,
            'the_code'          => $req->s_number . '-' . ($contractPeriodsCount+1),
            'status'            => 1,
            'created_at'        => date('Y-m-d H:i:s'),
            'created_by'        => auth()->user()->id
        ]);
        
    }

    /** [This method is created to delete a specific contract period according to the givin id]
     *
     * @param mixed $id
     * 
     * @return [bool] true if success, or false upon error
     * 
     */
    public function deleteperiod($id){
        $period = Period::find($id);
        return $period;
    }

    public function storeContractItems (Request $req) {
        $ci = new ContractItem();

        if (ContractItem::where(['item' => $req->item, 'contract'=>$req->contract])->first()) {
            return redirect()->back()->withError('تمت إضافة هذا العنصر بالفعل الى العقد، يمكنك تعديل الكميات أو السعر');
        }

        $ci->item = $req->item;
        $ci->qty = $req->qty;
        $ci->unit = Item::where(['id' => $req->item])->first()->unit;
        $ci->unit_price = $req->price;
        $ci->contract = $req->contract;

        $ci->status           = 0;
        
        $ci->created_by       = auth()->user()->id;
        $ci->created_at       = date('Y-m-d H:i:s');
        
        if ($ci->save()) {
            return redirect()->route('contract.edit', [$req->contract, 2])->withSuccess('تم إضافة صنف جديد بنجاح، يمكنك الان إضافة المزيد');
        }
    }

    public function paymnetSchEntrystore(Request $req) {
        $cpse                   = new ContractPaymentScheduleEntry();
        $cpse->ordering         = $req->ordering;
        $cpse->amount           = $req->amount;
        $cpse->ratio            = $req->ratio;
        $cpse->brief            = $req->brief;
       
        $cpse->created_by       = auth()->user()->id;
        $cpse->created_at       = date('Y-m-d H:i:s');
        $cpse->company          = auth()->user()->company;
        $cpse->contract         = $req->contract;

        if ($cpse->save()) {
            return redirect()->back()->withInput()->withSuccess('تم إضافة شرط دفع جديد بنجاح، يمكنك الان إضافة المزيد');
        }

    }

    public function paymnetSchEntryUpdate(Request $req) {
        $entry                  = ContractPaymentScheduleEntry::where(['id' => $req->id])->first();
        $entry->ordering        = $req->ordering;
        $entry->brief           = $req->brief;
       
        $entry->updated_by      = auth()->user()->id;
        $entry->updated_at      = date('Y-m-d H:i:s');
        
        if ($entry->update()) {
            return redirect()->back()->withSuccess('تم تعديل الشرط بنجاح.');
        }

    }

    public function paymnetSchEntryDelete($id)  {
        $entry = ContractPaymentScheduleEntry::where(['id' => $id])->first();
        if ($entry->delete()) {
            return redirect()->back()->withSuccess('تم حذف الشرط بنجاح، يمكنك الان إضافة المزيد');
        }
    }

    public function updateContractItems(Request $req) {
        // get Item
        $ContractItem = ContractItem::find($req->itemId);
        
        try {
            $ContractItem->update([
                // update Quantity
                'qty'=>$req->qty,
                // update Price
                'price'=>$req->price,
            ]);
            return redirect()->back()->withSuccess('تم تحديثة الصنف بنجاح، يمكنك الان إضافة المزيد');
        } catch (QueryException $err) {
            return redirect()->back()->withInputs()->withSuccess('فشلت عملية التحديث بسبب: '.$err);

        }
       
    }
    
    public function update (Request $req) {

        $contract = Contract::find($req->id);
        if (!$contract) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }
        try {
        $contract->update([
            'brief'             => $req->brief,
            'updated_by'       => auth()->user()->id,
            'updated_at'       => date('Y-m-d H:i:s')
        ]);

            return redirect()->back()->withSuccess('تم تحديث بيانات العقد  بنجاح');
        } catch (QueryException $err) {
            return redirect()->back()->withError('فشل تحديث بيانات العقد');
        }
    }

    
    /** [present all details related to the contract input items]
     * 
     * @param int $id
     * @param int $tab
     * @return [View]
     */
    public function inputs($id, $tab) {
        // Make sure the the contract is exists
        $contract = Contract::find($id);
        if (!$contract) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }
        if (null == $contract) {
            return redirect()
            ->route('contracts.home', [$contract->id, 2])
            ->withError('حدث خطأ، ربما تبحث عن عقد غير موجود، أو ليس لديك صلاحيات كافية.');}
        // 
        $vars ['client']        = Client::where(['id' => $contract->client])->first();;
        $inputs                 = Receipt::where(['contract_id' => $id, 'type'=>1])->get();
        $contract->inputs       = $inputs;
        foreach($inputs as $i => $rec) {
            $rec->totalQty = ReceiptEntry::query()->where(['contract_id' => $id, 'type' => 1, 'receipt_id'=>$rec->id])->sum('tableItemQty');
        }


        $vars['contract'] = $contract;
        // $vars['inputs'] = $contractInputs;
        $vars['tab'] = $tab;
        
        return view ('admin.sales.contracts.inputs', $vars);
    }

    /** [view store operations like reception, deliver, position, stock, and arrange for a contract according the givin primary keyand tab number]
     * 
     * @param int $id the primary key for the contract
     * @param int $tab the section to be displayed
     * @return [View]
     */
    public function view ($id, $tab) {
        $contract = Contract::find($id);
        if (!$contract) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }
        if (null == $contract) {return redirect()->route('contracts.home', [$contract->id, 2])->withError('حدث خطأ، ربما تبحث عن غير موجود أو ليس لديك صلاحيات كافية.');}
        
        $items                      = Item::all();
        $units                      = MeasuringUnit::all();
        $contract->items            = ContractItem::where('contract_id', $id)->get();
        $client                     = Client::where(['id' => $contract->client_id])->first();
        $inputs                     = Receipt::where(['contract_id' => $id, 'type'=>1])->get();
        
        $contract->inputs           = $inputs;
        $contract->inputsQty        = ReceiptEntry::query()->where(['contract_id' => $id, 'type' => 1])->sum('tableItemQty');
        $outputs                    = Receipt::where(['contract_id' => $id, 'type'=>2])->get();
        $contract->outputs          = $outputs;
        $contract->outputsQty       = ReceiptEntry::query()->where(['contract_id' => $id, 'type' => 2])->sum('tableItemQty');
        $itemsArr                   = [];

        $vars = [];

        $vars ['bookedTables']      = $contract->getBookedTablesCount();
        

        $vars ['consumedLarge']     = 0;
        $vars ['consumedSmall']     = 0;
        $vars ['OccupiedLarge']     = 0;
        $vars ['OccupiedSmall']     = 0;
        $vars ['inputs']            = $inputs;
        $vars ['outputs']           = $outputs;
        $vars ['ts']                = isset($ts) ? $ts : [];
        $vars ['items']             = $items;
        $vars ['units']             = $units;
        $vars ['tab']               = $tab;
        $vars ['contractItems']     = ContractItem::where(['contract_id'=>$id])->get();
        $vars ['company']           = AccountsInfo::find(1);
        $vars ['contractor']        = Admin::where(['id'=>auth()->user()->id])->first();
        $vars ['client']            = $client;
        $vars ['contract']          = $contract;
        

        if ($tab ==2) {
            foreach($inputs as $i => $rec) {
                $rec->totalQty = ReceiptEntry::query()->where(['contract_id' => $id, 'type' => 1, 'receipt_id'=>$rec->id])->sum('inputs');
                $rec->driver = Driver::find($rec->driver);
            }
        }
        elseif ($tab == 3) {
            $theItemsArr = ReceiptEntry::groupBy('item_id', 'box_size')
                            ->select('receipt_entries.item_id', 'receipt_entries.box_size', 'store_boxes.name as box_name', 'store_items.name as item_name', ReceiptEntry::raw('SUM(inputs) as total_qty'))
                            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id' )
                            ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size' )
                            ->where(['receipt_entries.contract_id'=> $contract->id, 'receipt_entries.type'=>1])
                            ->orderBy('item_name')
                            ->get();

            foreach ($theItemsArr as $iia => $item) {
                $item->totalInputs = ReceiptEntry::where(['item_id'=>$item->item_id, 'box_size'=>$item->box_size, 'contract_id'=>$contract->id, 'type'=>1])->sum('inputs');
                $item->totalOutputs = ReceiptEntry::where(['item_id'=>$item->item_id, 'box_size'=>$item->box_size, 'contract_id'=>$contract->id, 'type'=>2])->sum('outputs');
            }
        }
        
        elseif ($tab == 4) {
            $taken = [];
            $ts = ReceiptEntry::select ('receipt_entries.*', 'tables.name as table_name',  'store_items.name as item_name')
                    ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
                    ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id' )
                    ->where (['receipt_entries.contract_id'=> $contract->id, 'receipt_entries.type'=>1])->orderBy('table_name', 'ASC')->get();
            foreach ($ts as $s =>$table) {
                if (!array_key_exists($table->table_id, $taken)) {
                    $table->total_qty = $table->inputs;
                    $taken[$table->table_id]['in'] = $table;
                    $outs = ReceiptEntry::select(ReceiptEntry::raw('SUM(outputs) AS total_qty'))->where(['table_id'=>$table->table_id, 'contract_id'=> $contract->id, 'receipt_entries.type'=>2])->first();

                    $taken[$table->table_id]['out'] = null != $outs ? $outs->total_qty : 0;
                } else {
                    $taken[$table->table_id]['in']->total_qty += $table->inputs;
                }
            }
        }

        elseif ($tab ==5) {
            foreach($outputs as $i => $rec) {
                $rec->totalQty = ReceiptEntry::query()->where(['contract_id' => $id, 'type' => 2, 'receipt_id'=>$rec->id])->sum('outputs');
            }
        }

        elseif ($tab == 6) {
            $cTables = ReceiptEntry::where(['receipt_entries.contract_id' => $id, 'receipt_entries.type'=> '1'])
            ->select([
                'table_id',
                'contracts.s_number as contract',
                'clients.a_name as client',
                ReceiptEntry::raw('SUM(inputs) AS totalInputs'),
                ReceiptEntry::raw('SUM(outputs) AS totalOutputs'),
                ReceiptEntry::raw('GROUP_CONCAT(item_id) AS items'),
                'tables.name as tableName',
                'tables.serial as tableSN',

            ])
            ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
            ->join('contracts', 'contracts.id', '=', 'receipt_entries.contract_id')
            ->join('clients', 'clients.id', '=', 'receipt_entries.client_id')
            ->groupBy('table_id', 'receipt_entries.contract_id', 'receipt_entries.client_id')
            ->orderBy('tableSN', 'ASC')
            ->paginate(24);
            // ReceiptEntry::where (['contract_id' => $id, 'type'=> '1'])->select('table_id', )->groupBy('table_id')->get();
            foreach ($cTables as $t) {$t->load = Table::calcTableLoad($t->table_id, $id);}
            $vars ['cTables']      = $cTables;

        }
        
        $unitsArr                   = [];
        
        foreach ($items as $i => $item) {$itemsArr[$item->id] = $item->a_name;}
        foreach ($units as $i => $unit) {$unitsArr[$unit->id] = $unit->a_name;}
        $contractItems = '';
        
        // return AccountsInfo::find(1);
        $vars ['storeItems']    = storeItem::getItemsNamesArray();
        $vars ['itemsArr']      = $contract->items;
        $vars ['itemsInArr']    = isset($theItemsArr) ? $theItemsArr : [];
        $vars ['itemsOutArr']   = isset($itemsOutArr) ? $itemsOutArr : [];
        $vars ['tablesInArr']   = isset($taken) ? $taken : [];
        $vars ['contractItems'] = ContractItem::where(['contract_id'=>$id])->get();
        $vars ['unitsArr'] = $unitsArr;
            
        return view ('admin.sales.contracts.view', $vars);
    }

    /* This method is created to pick a contract and calculate tables stats / creadit for this contract
     * @return [View]
     */
    public function table_credit () {
        return view('admin.clients.reports.table_credit');
    }

    public function search_contracts_by_client (Request $req) {
        $clientName = $req->get('query');
        $clients = Client::where('a_name', 'LIKE', "%{$clientName}%")->orderBy('a_name', 'ASC')->get();
        return json_encode($clients);
    }

    public function get_client_contracts (Request $req) {
        $client = Client::find($req->get('client'));

        
        if (null != $client) {
            $client->contracts;
            return $client;
        }
        return null;
    }

    public function get_contracts_tables_count(Request $req) {
        $contract   = Contract::find($req->contract_id);
        $startDate  = $req->from_date;
        $endDate    = $req->to_date;

        $contract->periods;
        foreach($contract->periods as $cp){
            $cp->items;
        }

        $contract->tablesConsumedBetween($startDate, $endDate);
        $contract->tablesExitedBetween($startDate, $endDate);
           
        return $contract;
    }

    public function get_contract_stats(Request $req) {
        $contract = Contract::find($req->contract);
        return $contract;
    }

    /**
     * This method is created to delete specific contracts by it's primary keys
     * 
     * @param mixed $id
     * 
     * @return [type]
     */
    public function delete ($id) {
        $item = Contract::where(['id' => $id])->first();
        if ($item->delete()) {
            return redirect()->back()->withSuccess('تم الحذف بنجاح');
        }
    }

    public function additem (Request $req) {
        $contract = Contract::find($req->id);
        $item = new ContractItem();
        $item->contract = $req->contract;
        $item->item = $req->item;
        $item->qty = $req->qty;
        $item->unit = $req->unit;
        $item->unit_price = $req->unit_price;
        $item->tax = $req->tax;
        $item->discount = $req->discount;
        $item->total_price = $req->total_price;

        $item->status = 1;
        $item->company = auth()->user()->company;

        $item->created_by = auth()->user()->id;
        $item->created_at = date('Y-m-d h:i:s');
        
        if ($item->save()){
            return redirect()->back()->with(['tabindex'=>2])->withSuccess('تمت الإضافة بنجاح');
        }
    }

    public function itemHistory (Request $req) {

        $items = ReceiptEntry::select('receipt_entries.*', 'receipts.s_number as serialNumber')
        ->join('receipts','receipts.id','=','receipt_entries.receipt_id')
        ->where(['receipt_entries.contract_id' => $req->contract, 'receipt_entries.item_id' => $req->item, 'receipt_entries.box_size' => $req->box])->get();
        
        $vars ['items']= $items;
        $vars ['item'] = StoreItem::find($req->item);
        $vars ['box'] = StoreBox::find($req->box);
        

        return view ('admin.sales.contracts.itemslook', $vars);
    }

    /** This method is created to delete from contracts items according to its primarykes values0000000000000000000000000000000
     * @param mixed $id
     * 
     * @return [type]
    */
    public function deleteContractItem ($id) {
        $item = ContractItem::where(['id' => $id])->first();
        if ($item->delete()) {
            return redirect()->back()->withSuccess('تم الحذف بنجاح');
        }
    }

    /** This conract is created to 
     * @param Request $request
     * 
     * @return [type]
     */
    public function setting (Request $request) {
        $contract = Contract::find($request->contract_id);

    }

    public function print ($id) {
        $contract = Contract::find($id);
        if (!$contract) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }

        $items                      = Item::all();
        $units                      = MeasuringUnit::all();
        $contract                   = Contract::where(['id' => $id])->first();
        $contract->items            = ContractItem::where('contract_id', $id)->get();
        $client                     = Client::where(['id' => $contract->client_id])->first();
        $alter                      = ClientContact::where(['client'=>$client->id, 'role'=>3])->first();
        $client->alter              = $alter ? Contact::find($alter->client) : null;
        $contract->receipts         = Receipt::where(['contract_id' => $id])->get();
        $itemsArr                   = [];
        $unitsArr                   = [];

        foreach ($items as $i => $item) {$itemsArr[$item->id] = $item->a_name;}
        foreach ($units as $i => $unit) {$unitsArr[$unit->id] = $unit->a_name;}
        $contractItems = '';
        // return AccountsInfo::find(1);
        $vars = [
            'items'         => $items,
            'itemsArr'      => $itemsArr,
            'contractItems' => ContractItem::where(['contract_id'=>$id])->get(),
            
            'units'         => $units,
            'unitsArr'      => $unitsArr,
            'company'       => AccountsInfo::find(1),
            'contractor'    => Admin::where(['id'=>auth()->user()->id])->first(),
            'contract'      => $contract,
            'client'        => $client,
        ];

        
        return view ('admin.sales.contracts.print', $vars);
    }

    public function storeContractConditions (Request $req) {
        return $req->name; 
    }

    /** This method is created to change contract status to approved according to givin id
     * @param Request $req
     * 
     * @return [type]
     */
    public function approve (Request $req) {
        $item = Contract::find($req->id);
        $item->status = 1;
        if ($item->update()) {
            return redirect()->back()->withSuccess('هنيئا، لقد أصبح العقد ساريا الأن، بمكنك عمل حركات استقبال واخراج وتفعيل استلام الدفعات النقدية');
        }
    }

    /** [Description for invent]
     *
     * @return [type]
     * 
     */
    public function invent() {
        $contracts = Contract::select('contracts.*', 'clients.a_name as clientName')
        ->join('clients', 'clients.id', '=', 'contracts.client')->get();

        foreach ($contracts as $i => $c) {
            $contracts->total_inputs = Contract::getContractQty($c->id);
        }
        $vars = [
            'contracts' => $contracts
        ];
        return view ('admin.sales.contracts.reports.invent', $vars);
    }

    /** This method is created to change contract status to parked according to givin id
     * @param mixed $id
     * 
     * @return [type]
     */
    public function park ( $id) {
        $item = Contract::edit($id, [
            'status'=>2
        ]);
        if ($item->update()) {
            return redirect()->back()->withSuccess('تم ايقاف العقد، يمكنك الان اجراء التعديلات، لن يتم اجراء أى عمليات على العقد حتى يتم تفعيله مرة أخرى');
        }
    }

    public function extend ( Request $req) {
        
        return view('admin.sales.contracts.extend', ['contract'=>Contract::find($req->id)]);
    }

    public function extendAndUpdate ( Request $req) {
        
        $item = Contract::edit($req->id, [
            'ends_in_greg'=>$req->ends_in_greg,
            'ends_in_hij'=>$req->ends_in_hij
        ]);
        if ($item->update()) {
            return redirect()->back()->withSuccess('تم ايقاف العقد، يمكنك الان اجراء التعديلات، لن يتم اجراء أى عمليات على العقد حتى يتم تفعيله مرة أخرى');
        }
    }

}
