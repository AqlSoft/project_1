<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use Illuminate\Http\Request;
use App\Models\Admin;
use App\Models\Item;
use App\Models\Receipt;
use App\Models\ReceiptEntry;
use App\Models\MeasuringUnit;
use App\Models\Client;
use App\Models\Contract;
use App\Models\ContractPaymentScheduleEntry;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Table;
use App\Models\ContractItem;
use App\Models\AccountsInfo;
use App\Helper;
class ContractsController extends Controller
{
    //

    public static $scopes = [1=>'فردى', 2=>'مؤسسة', 3=>'شركة', 4=>'مصنع', 5=>'مزرعة', 6=>'تاجر',];
    public static $types = [1=>'عقد أساسى', 2=>'إضافة طبالى', 3=>'تمديد عقد أساسى'];
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

    public function create ($clientId) {
        if (!$clientId) {
            return redirect()->route('clients.home')->withError('من فضلك حدد عميلا لتتمكن من إضافة عقد');
        }
        $client = Client::where(['id' => $clientId])->first();
        $clientContracts = Contract::where(['client'=>$clientId, ])->get();
        $currentUserCompany = auth()->user()->company;
        $company = AccountsInfo::where(['id' => $currentUserCompany])->first();
        $lastContract = Contract::where([])->orderBy('id', 'DESC')->first();
        $lc = $lastContract == null ? str_pad(1, 10, '4510000000', STR_PAD_LEFT) : $lastContract->s_number + 1;
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

        if (!$id) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }

        $contract = Contract::where(['id' => $id])->first();
        $items =Item::all();
        $cis = ContractItem::where(['contract' => $contract->id])->get();
        $cPymtSchEntries = ContractPaymentScheduleEntry::where(['contract'=>$id])->get();
        foreach($cis as $i => $ci) {foreach ($items as $ii => $item) {if ($ci->item == $item->id) {$ci->name = $item->a_name;}}}
        $ct = 0;
        foreach ($cis as $ii => $ci) {$ct += $ci->qty * $ci->unit_price * $contract->start_period*1.15;}
        $cpAmounts = 0;
        foreach($cPymtSchEntries as $cpi => $entry) {$cpAmounts+= $entry->amount;}


        $client = Client::where(['id' => $contract->client])->first();
        $clientContracts = Contract::where(['client'=>$client->id, ])->get();
        $currentUserCompany = auth()->user()->company;
        $company = AccountsInfo::where(['id' => $currentUserCompany])->first();
        
        $vars = [

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
    
    public function store (Request $req, $clientId) {
        
        $client = Client::where(['id' => $clientId])->first();
        
        $contract = new Contract();
        $contract->code             = $req->code;
        
        $contract->brief            = $req->brief;
        $contract->in_day_greg      = $req->in_day_greg_input;
        $contract->in_day_Hij       = $req->in_day_hijri_input;
        $contract->client           = $clientId;
        $contract->starts_in_greg   = $req->starts_in_greg_input;
        $contract->starts_in_hij    = $req->starts_in_hijri_input;
        $contract->ends_in_greg     = $req->ends_in_greg_input;
        $contract->ends_in_hij      = $req->ends_in_hijri_input;
        $contract->start_period     = $req->start_period;
        $contract->renew_period     = $req->renew_period;

        $contract->status           = 0;
        $contract->s_number         = $req->s_number;
        
        $contract->created_by       = auth()->user()->id;
        $contract->created_at       = date('Y-m-d H:i:s');
        
        if ($contract->save()) {
            return redirect()->route('contract.edit', [$contract->id, 2])->withSuccess('تم إنشاء عقد جديد بنجاح، يمكنك الان التعديل على العقد وإضافة التفاصيل');
        }
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
        $ci = ContractItem::where(['id' => $req->itemId])->first();
        $ci->unit_price = intval($req->price);
        $ci->qty = intval($req->qty);

        $ci->updated_by       = auth()->user()->id;
        $ci->updated_at       = date('Y-m-d H:i:s');
        if ($ci->update()) {
            return redirect()->route('contract.edit', [$ci->contract, 2])->withSuccess('تم تحديثة الصنف بنجاح، يمكنك الان إضافة المزيد');
        }
    }
    
    public function update (Request $req) {

        $contract = Contract::where(['id' => $req->id])->first();

        $contract->code             = $req->code;
        $contract->type             = $req->type;
        $contract->brief             = $req->brief;
        //$contract->s_number         = 
        $contract->in_day_greg      = $req->in_day_greg_input;
        $contract->in_day_Hij       = $req->in_day_hijri_input;
        $contract->starts_in_greg   = $req->starts_in_greg_input;
        $contract->starts_in_hij    = $req->starts_in_hijri_input;
        $contract->ends_in_greg     = $req->ends_in_greg_input;
        $contract->ends_in_hij      = $req->ends_in_hijri_input;
        
        $contract->updated_by       = auth()->user()->id;
        $contract->updated_at       = date('Y-m-d H:i:s');

        //return $contract;

        if ($contract->update()) {
            return redirect()->route('contract.edit', [$contract->id, 2])->withSuccess('تم تحديث بيانات العقد  بنجاح');
        }
    }

    public function view ($id, $tab) {
        
        $items                      = Item::all();
        $units                      = MeasuringUnit::all();
        $contract                   = Contract::where(['id' => $id])->first();
        $contract->items            = ContractItem::where('contract', $id)->get();
        $client                     = Client::where(['id' => $contract->client])->first();
        $inputs                     = Receipt::where(['contract_id' => $id, 'type'=>1])->get();
        $contract->inputs           = $inputs;
        $outputs                    = Receipt::where(['contract_id' => $id, 'type'=>2])->get();
        $contract->outputs          = $outputs;
        
        $itemsArr                   = [];
        if ($tab ==1) {
            
        }
        
        elseif ($tab == 3) {
            $itemsInArr = ReceiptEntry::groupBy('item_id')
                            ->select('receipt_entries.item_id', 'store_items.name as item_name', ReceiptEntry::raw('SUM(tableItemQty) as total_qty'))
                            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id' )
                            ->where(['receipt_entries.contract_id'=> $contract->id, 'receipt_entries.type'=>1])
                            ->get();
            $itemsOutArr = ReceiptEntry::groupBy('item_id')
                            ->select('receipt_entries.item_id', 'store_items.name as item_name', ReceiptEntry::raw('SUM(tableItemQty) as total_qty'))
                            ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id' )
                            ->where(['receipt_entries.contract_id'=> $contract->id, 'receipt_entries.type'=>2])
                            ->get();
                        
        } elseif ($tab == 4) {
            $taken = [];
            $ts = ReceiptEntry::select ('receipt_entries.*', 'tables.name as table_name',  'store_items.name as item_name')
                    ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
                    ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id' )
                    ->where (['receipt_entries.contract_id'=> $contract->id, 'receipt_entries.type'=>1])->orderBy('table_name', 'ASC')->get();
            foreach ($ts as $s =>$table) {
                if (!array_key_exists($table->table_id, $taken)) {
                    $table->total_qty = $table->tableItemQty;
                    $taken[$table->table_id]['in'] = $table;
                    $outs = ReceiptEntry::select(ReceiptEntry::raw('SUM(tableItemQty) AS total_qty'))->where(['table_id'=>$table->table_id, 'contract_id'=> $contract->id, 'receipt_entries.type'=>2])->first();

                    $taken[$table->table_id]['out'] = null != $outs ? $outs->total_qty : 0;
                } else {
                    $taken[$table->table_id]['in']->total_qty += $table->tableItemQty;
                }
            }
        }
        $unitsArr                   = [];
        
        foreach ($items as $i => $item) {$itemsArr[$item->id] = $item->a_name;}
        foreach ($units as $i => $unit) {$unitsArr[$unit->id] = $unit->a_name;}
        $contractItems = '';
        // return AccountsInfo::find(1);
        $vars = [
            'inputs'        => $inputs,
            'outputs'       => $outputs,
            'ts'            => isset($ts) ? $ts : [],
            'items'         => $items,
            'itemsArr'      => $itemsArr,
            'itemsInArr'    => isset($itemsInArr) ? $itemsInArr : [],
            'itemsOutArr'   => isset($itemsOutArr) ? $itemsOutArr : [],
            'tablesInArr'   => isset($taken) ? $taken : [],
            'contractItems' => ContractItem::where(['contract'=>$id])->get(),
            
            'units'         => $units,
            'tab'           => $tab,
            'unitsArr'      => $unitsArr,
            'company'       => AccountsInfo::find(1),
            'contractor'    => Admin::where(['id'=>auth()->user()->id])->first(),
            'contract'      => $contract,
            'client'        => $client,
        ];
        return view ('admin.sales.contracts.view', $vars);
    }

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

    public function deleteContractItem ($id) {
        $item = ContractItem::where(['id' => $id])->first();
        if ($item->delete()) {
            return redirect()->back()->withSuccess('تم الحذف بنجاح');
        }
    }

    public function createReceipt ($id, $type) {
        $contract = Contract::where(['id' => $id])->first();
        $client = Client::where(['id' => $contract->client])->first();
        $receipts = ContractReceipt::where(['contract' => $id])->get();


        $vars = [
            'lir'               => count(ContractReceipt::all()), // lir Last Inserted Receipt
            'storeItems'        => StoreItem::all(),
            'receipts'          => $receipts,
            'contract'          => $contract,
            'client'            => $client,
            'type'              => $type,
            'scopes'            => static::$scopes,
            'boxSizes'          => StoreBox::all(),
        ];
        return view('admin.clients.receipts.create', $vars);
    }

    public function storeReceipt (Request $req) {
        
        $rec = new ContractReceipt();
        
        $rec->serial            = $req->serial;
        $rec->contract          = $req->contract;
        $rec->day_in_greg       = $req->in_day_greg_input;
        $rec->day_in_Hijri      = $req->in_day_hijri_input;
        $rec->driver            = $req->driver;
        $rec->iqama             = $req->iqama;
        $rec->shift             = $req->shift;
        $rec->type              = $req->type;
        $rec->client            = $req->client;
        $rec->notes             = $req->notes;
        $rec->status            = 1;
        $rec->company           = auth()->user()->company;
        $rec->created_by        = auth()->user()->id;
        $rec->created_at        = date('Y-m-d H:i:s');

        
        if ($rec->save()) {
            return redirect()->route('clients.view', $rec->client)->withSuccess('تم إنشاء سند الاستلام بنجاح');
        }
    }

    public function receive ($id) {
        $contract                   = Contract::where(['id' => $id])->first();
        $storeItems                 = StoreItem::all();
        $boxSizes                   = StoreBox::all();
        $tables                     = Table::all();
        $vars = [
            'contract'              => $contract,
            'storeItems'            => StoreItem::all(),
            'boxSizes'              => StoreBox::all(),
            'client'                => Client::where(['id' => $contract->client, 'company' => auth()->user()->company])->first(),
            'scopes'                => static::$scopes,
        ];
        return view ('admin.clients.movements.receive', $vars);
    }

    public function print ($id) {
        if (!$id) {
            return redirect()->route('clients.home')->withError('حدث شىء خاطىء، نرجو إعادة المحاولة لاحقا');
        }

        $items                      = Item::all();
        $units                      = MeasuringUnit::all();
        $contract                   = Contract::where(['id' => $id])->first();
        $contract->items            = ContractItem::where('contract', $id)->get();
        $client                     = Client::where(['id' => $contract->client])->first();
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
            'contractItems' => ContractItem::where(['contract'=>$id])->get(),
            
            'units'         => $units,
            'unitsArr'      => $unitsArr,
            'company'       => AccountsInfo::find(1),
            'contractor'    => Admin::where(['id'=>auth()->user()->id])->first(),
            'contract'      => $contract,
            'client'        => $client,
        ];

        
        return view ('admin.sales.contracts.print', $vars);
    }

    
    public function stats($id) {
        
        $contract = Contract::find($id);
        if (null == $contract) {return redirect () -> route('clients.home')-> with (['error' => 'العقد غير موجود']);}
        $contract->the_client = Client::find($contract->client);
        $largePallets = ContractItem::where(['contract'=>$contract->id, 'item' => 2])->first();//2==large
        $contract->largePallets = $largePallets != null ? $largePallets->qty : 0;
        $smallPallets = ContractItem::where(['contract'=>$contract->id, 'item' => 1])->first();//1==small
        $contract->smallPallets = $smallPallets != null ? $smallPallets->qty : 0;
        $contract->inputReceiptsCount           = Receipt::where(['contract_id'=>$id, 'type'=>1])->count();
        $contract->outputReceiptsCount          = Receipt::where(['contract_id'=>$id, 'type'=>2])->count();
        //الطبالى الكبيرة المدخلة على العقد
        $largePallets = ReceiptEntry::select('table_id')->where(['contract_id'=>$id, 'table_size'=>2, 'type' => 1])->distinct()->get();
        //الطبالى الصغيرة المدخلة على العقد
        $smallPallets = ReceiptEntry::select('table_id')->where(['contract_id'=>$id, 'table_size'=>1, 'type' => 1])->distinct()->get();
        $contract->largePalletsUsed             = $largePallets == null ? 0 : count($largePallets);
        $contract->smallPalletsUsed             = $smallPallets == null ? 0 : count($smallPallets);
        //جميع عمليات الادخال
        $inputs = $contract->allUsedTables();
        // ReceiptEntry::select('table_id', 'tableItemQty', 'table_size', 'type', 'tables.name as table_name')
        // ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
        // ->where(['receipt_entries.contract_id'=>$id, 'receipt_entries.type' => 1])->get();
        
        $contract->inputs = Contract::calcItemQtyFor($inputs);
        // جميع عمليات الأخراج
        $outputs                      =  ReceiptEntry::select('table_id', 'tableItemQty', 'table_size', 'type', 'tables.name as table_name')
        ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
        ->where(['receipt_entries.contract_id'=>$id, 'receipt_entries.type' => 2])->get();
        $contract->outputs = Contract::calcItemQtyFor($outputs);



       
       
        $vars['contract'] = $contract;

        return view ('admin.sales.contracts.stats', $vars);
    }

    public function storeContractConditions (Request $req) {
        return $req->name; 
    }

    public function approve (Request $req) {

        $item = Contract::find($req->id);
        $item->status = 1;
        if ($item->update()) {
            return redirect()->back()->withSuccess('هنيئا، لقد أصبح العقد ساريا الأن، بمكنك عمل حركات استقبال واخراج وتفعيل استلام الدفعات النقدية');
        }
    }
}
