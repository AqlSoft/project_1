<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Controllers\info;
use App\Models\SalesCategory;
use App\Models\ContractItem;
use App\Models\ReceiptEntry;
use App\Models\StorePoint;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\Contract;
use App\Models\Receipt;
use App\Models\Client;
use App\Models\Admin;
use App\Models\Table;
use App\Models\Room;
use App\Models\Area;
use App\Models\Log;


class StoresController extends Controller
{
    use info;
    private static $branches = [1=>'القصيم - البصر - طريق الملك فهد'];

    public function home () {
        $vars['smallTables'] = Table::where(['size'=>1])->get()->count();
        $vars['largeTables'] = Table::where(['size'=>2])->get()->count();

        $vars['largeOccupiedTables'] = ContractItem::where(['item'=>2])->sum('qty');
        $vars['smallOccupiedTables'] = ContractItem::where(['item'=>1])->sum('qty');

        return view('admin.store.home', $vars);
    }

    public function settings () {
        $cats = SalesCategory::where([])->orderBy('id', 'ASC')->paginate(10);
        $allAdmins = Admin::all();$admins = [];
        foreach($allAdmins as $i => $admin){$admins[$admin->id] = $admin->name;}
        return view('admin.store.settings', ['cats'=>$cats, 'admins'=>$admins]);
    }

    public function tables () {
        $tables     = Table::where([])->orderBy('id', 'ASC')->paginate(25);
        $tableSizes = ['', 'صغيرة', 'كبيرة', 'متوسطة'];
        $tableStatus = ['فارغة', 'مرتبطة بعقد ممتلئة', 'مرتبطة بعقد غير ممتلئة', 'محررة'];
        $vars=[
            'tableStatus' => $tableStatus,
            'tableSizes' => $tableSizes,
            'tables' => $tables,
        ];
        return view('admin.store.tables.home', $vars);
    }

    public function table_position ($id) {

        $entries = ReceiptEntry::select('receipt_entries.*', 'tables.name as table_name', 'store_items.name as item_name')
        ->join('tables', 'tables.id', '=', 'receipt_entries.table_id')
        ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
        ->where(['receipt_entries.receipt_id'=>$id])->get();
        
        foreach ($entries as $entry) {
            $entry->storingRecord=StorePoint::where(['table_id'=>$entry->table_id])->first();
        }

        $receipt = Receipt::find($id);
        $client = Client::find($receipt->client_id);
        $contract = Contract::find($receipt->contract_id);
        
        $vars = [
            'rooms'         => Room::all(),
            'contract'      => $contract,
            'receipt'       => $receipt,
            'client'        => $client,
            'entries'       => $entries,
        ];
        // resources\views\admin\operating\input\receipts\table_position.blade.php
        return view('admin.operating.input.receipts.table_position', $vars);
    }
    public function save_table_position (Request $req) {
        $room=Room::find($req->room);
        $code = $room->code.$req->partition.$req->position.$req->rack;
        $point = str_pad($req->position, 2, "0", STR_PAD_LEFT) ;

        $record = [
            'table_id'          =>$req->table_id, 
            'receipt_id'        =>$req->receipt_id,
            'section'           =>$room->section,
            'room'              =>$req->room, 
            'partition'         =>$req->partition, 
            'position'          =>$req->position, 
            'rack'              =>$req->rack, 
            'code'              =>$code,
            'created_by'        =>auth()->user()->id,
        ];
        // return var_dump($record);
        $foundRecord = StorePoint::where(['table_id'=>$req->table_id])->first();
        if ($foundRecord == null) {
            try {
                StorePoint::create($record)->save();
                ReceiptEntry::edit($req->entry_id, ['store_point'=>$code])->update();
                return redirect ()->back()->with(['success'=>'تم تسكين الطبلية بنجاح فى النقطة: '. $code]);
            } catch (QueryException $e) {
                return redirect ()->back()->with(['error'=>'حدث الخطأ التالى: '.$e]);
            }
        } else {
            try {
                StorePoint::edit($foundRecord->id, $record)->update();
                $foundRecord->update();
                ReceiptEntry::edit($req->entry_id, ['store_point'=>$code])->update();
                return redirect ()->back()->with(['success'=>'تم تحديث بيانات نقطة التخزين '. $code]);
            }catch (QueryException $e) {
                return redirect ()->back()->with(['error'=>'حدث الخطأ التالى: '.$e]);
            }
        }
    }

    public function tablesCreate () {

        $vars=[
            
        ];
        return view('admin.store.tables.create', $vars);
    }

    public function storeArray () {

        $vars=[
            
        ];
        return view('admin.store.array.home', $vars);
    }

    public function tablesStore (Request $req) {

        $table              = new Table();
        $table->name        = $req->name;
        $table->serial      = $req->serial;
        $table->size        = $req->size;
        $table->capacity     = $req->capacity;
        $table->created_by  = auth()->user()->id;
        $table->company     = auth()->user()->company;
        $table->created_at  = date('Y-m-d H:i:s');

        if($table->save()) {
            $l = ['action'=>'إضافة','subject'=>'طبلية جديدة','item_id'=>$table->id,'link'=>'table.view','created_by'=>$table->created_by,'created_at'=>$table->created_at];
            Log::addRecord($l);
            return redirect()->back()->withSuccess('تمت إضافة طبلية جدية للمخازن بنجاح');
        }
        
    }

    public function storeItems () {
        $items = StoreItem::where([])->orderBy('id', 'ASC')->paginate(16);
        $vars = [
            'items'         => $items,
        ];
        return view ('admin.store.items.home', $vars);
    }

    public function storeBoxes () {
        $boxes = StoreBox::where([])->orderBy('id', 'ASC')->paginate(16);
        $vars = [
            'boxes'         => $boxes,
        ];
        return view ('admin.store.items.home', $vars);
    }

    public function addStoreItem (Request $req) {
        
        $item = new StoreItem();
        $item->name = $req->name;
        $item->short = $req->short;
        $item->pic = 'none';

        $item->created_at = date('Ymd H:i:s');
        $item->created_by = auth()->user()->id;
        

        if ($item->save()) {
            return redirect()->back()->withSuccess('تم إضافة صنف جديد بنجاح');
        } return redirect()->back()->withError('فشلت عملية إضافة صنف جديد ');
        
    }

    public function removeStoreItem ($id) {
        $item = StoreItem::where(['id' => $id])->first();
        if ($item->delete()) {
            return redirect()->back()->withSuccess('تم حذف الصنف بنجاح');
        } return redirect()->back()->withError('فشلت عملية الحذف ');
    }
    
    public function addBoxSize (Request $req) {
        
        $item = new StoreBox();
        $item->name = $req->name;
        $item->short = $req->short;
        $item->pic = 'none';

        $item->created_at = date('Ymd H:i:s');
        $item->created_by = auth()->user()->id;
        $item->company = auth()->user()->company;

        if ($item->save()) {
            return redirect()->back()->withSuccess('تم إضافة صنف حجم جديد بنجاح');
        } return redirect()->back()->withError('فشلت عملية إضافة حجم جديد ');
        
    }


 

    public function show ($id) {
       return 'show view ';
    }

    public function removeBoxSize ($id) {
        $item = StoreBox::where(['id' => $id])->first();
        if ($item->delete()) {
            return redirect()->back()->withSuccess('تم حذف الحجم بنجاح');
        } return redirect()->back()->withError('فشلت عملية الحذف ');
    }

}
