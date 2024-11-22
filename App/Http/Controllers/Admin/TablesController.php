<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Models\Item;
use App\Models\ItemsCategory;
use App\Models\ContractItem;
use App\Models\storeItem;
use App\Models\Table;
use App\Models\Contract;
use App\Models\Client;
use App\Models\Log;
use App\Models\MeasuringUnit;
use App\Models\TableContent;
use App\Models\ReceiptEntry;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Http\Requests\ItemRequest;
!defined('PAGES') ? define('PAGES', 10) : null;
class TablesController extends Controller
{
    //

    public static $tableSizes = ['', 'صغيرة', 'كبيرة', 'متوسطة'];
    public static $tableStatus = ['فارغة', 'مرتبطة بعقد ممتلئة', 'متوقفة للصيانة', 'محررة'];
    public function home () {
               
        $filter = [];
        if (isset($_GET['size'])) $filter['size'] = $_GET['size'];
        $vars=[
            'tableStatus'   => static::$tableStatus,
            'tableSizes'    => static::$tableSizes,
            'tables'        => Table::where($filter)->orderBy('serial', 'ASC')->paginate(PAGES),
            'json'          => Table::all()
        ];
        return view('admin.items.tables.home', $vars);
    }
    public function stats () {
               
        $vars=[
            'smallBook'     => ContractItem::select('qty')->where('item', 1)->get()->count(),
            'largeBook'     => ContractItem::select('qty')->where('item', 2)->get()->count(),
            'smallOccu'     => Table::where('the_load', '>', 0)->where('size', 1)->get()->count(),
            'largeOccu'     => Table::where('the_load', '<=', 0)->where('size', 2)->get()->count(),
            'large'         => Table::where(['size' => 2])->get()->count(),
            'small'         => Table::where(['size' => 1])->get()->count(),
        ];
        return view('admin.items.tables.stats', $vars);
    }

    public function create () {

        $vars=[
            
        ];
        return view('admin.items.tables.create', $vars);
    }

    
    public function report () {
        $cTables = ReceiptEntry::where(['receipt_entries.type'=> '1'])
            ->select([
                'table_id',
                'contracts.s_number as contract',
                'clients.a_name as client',
                ReceiptEntry::raw('SUM(tableItemQty) AS totalQty'),
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
            foreach ($cTables as $t) {$t->load = Table::calcTableLoad($t->table_id, 2);}
            $vars ['cTables']      = $cTables;
            $vars ['storeItems']    = storeItem::getItemsNamesArray();
        return view('admin.store.reports.tables', $vars);
    }
    public function edit ($id) {
       
        $vars=[
            't' => Table::where(['id' => $id])->first(),
        ];
        return view('admin.items.tables.edit', $vars);
    }

    public function store (Request $req) {
        $this->validate($req, [
            'name' => 'required|unique:tables', 
            'serial' => 'required|unique:tables'
        ]);

        $table              = new Table();
        $table->name        = $req->name;
        $table->serial      = $req->serial;
        $table->size        = $req->size;
        $table->capacity    = $req->size == 1 ? 221:286;
        $table->created_by  = auth()->user()->id;
        $table->created_at  = date('Y-m-d H:i:s');
        
        if($table->save()) {
            Log::addRecord('add', $table);
            return redirect()->back()->withSuccess('تم تسجيل الطبلية الجديدة بنجاح');
        }
        
    }

    public function search (Request $req) {
        if (!isset($req->size)) {
            $search = Table::where('name', 'like', "%{$req->search}%")->orderBy('serial', 'ASC')->paginate(PAGES);
        } else {
            if ($req->size >= 1) {
                $search = Table::where(['size'=> $req->size])->orderBy('serial', 'ASC')->paginate(PAGES);
            } else {
                $search = Table::where([])->orderBy('serial', 'ASC')->paginate(PAGES);
            }
        }
        $vars = [
            'tableStatus'   => static::$tableStatus,
            'tableSizes'    => static::$tableSizes,
            
            'tables'=> $search,
        ];
    
        return view ('admin.items.tables.search_by_number', $vars);
        
    }

    public function update (Request $req) {

        $table              = Table::where(['id' => $req->id])->first();
        $table->name        = $req->name;
        $table->serial      = $req->serial;
        $table->size        = $req->size;
        $table->capacity     = $req->capacity;
        $table->created_by  = auth()->user()->id;
        
        $table->created_at  = date('Y-m-d H:i:s');

        if($table->update()) {
            Log::addRecord('update', $table);
            return redirect()->route('tables.home')->withSuccess('تم تحديث بيانات الطبلية بنجاح');
        }
        
    }

    public function view ($id) {
        $table = Table::find($id);
        if ( $table->status>0 ) {
            $table->contract = Contract::find($table->contract_id);
            $table->client = Client::find($table->contract->client);
        }
        
        $registry = ReceiptEntry::select(
            'receipt_entries.*', 
            'admins.userName as creator', 
            'store_items.name as itemName', 
            'store_boxes.name as boxName', 
            'receipts.s_number as receipt_sn',
            'clients.a_name as clientName'
            )
        ->join('admins', 'admins.id', '=', 'receipt_entries.created_by')
        ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
        ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
        ->join('receipts', 'receipts.id', '=', 'receipt_entries.receipt_id')
        ->join('clients', 'clients.id', '=', 'receipt_entries.client_id')

        ->where(['receipt_entries.table_id'=>$id])->orderBy('created_at', 'ASC')->get();

        $vars = [
            'table' => $table,

            'registry' => $registry,
        ];

        return view('admin.items.tables.view', $vars);
    }

    public function getInfo (Request $req) {
        $table = Table::where(['name'=>$req->table_id])->first();
        $entries = $table-> getEntriesFor($req->contract);
        
        return view ('admin.store.tables.tableinfo', ['table'=>$table, 'entries'=>$entries, 'id'=>$req->table_id]);
    //    return $req;
        
    }

    public function delete ($id) {

        $table              = Table::where(['id' => $id])->first();
        
        try {
            $table->delete() ;
            return redirect()->back()->withSuccess('تم إزالة الطبلية بنجاح');
        } catch (queryException $e) {
            $message ='';
            if ($e->getCode()==='23000') {$message = 'لا يمكن حذف سجل مرتبط بسجلات أخرى';}
            return redirect()->back()->withError(" لم تتم عملية الحذف، \r".$message);
        }
        
    }

}
