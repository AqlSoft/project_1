<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Http\Controllers\info;
use App\Models\Table;
use App\Models\Area;
use App\Models\Admin;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\ReceiptEntry;
use App\Models\StoreBox;
use App\Models\StoreItem;
use App\Models\Log;


!defined('PAGES') ? define ('PAGES', 10): null;

class StoreBoxesController extends Controller
{
    use info;

    public function home () {
        $boxes = StoreBox::where([])->orderBy('id', 'ASC')->paginate(20);
        $vars = [
            'boxes'         => $boxes,
        ];
        return view ('admin.store.boxes.home', $vars);
    }

    public function stats () {
        $items = StoreBox::where([])->orderBy('id', 'ASC')->get();
        $vars = [
            'items'         => $items,
        ];
        return view ('admin.store.boxes.stats', $vars);
    }

    public function store (Request $req) {
        
        $item = new StoreBox();
        $item->name = $req->name;
        $item->short = $req->short;
        $item->pic = null;


        if($req->hasFile('pic')) {
            $fileHandler = $req->pic;

            $fileName = 'store_box_'. time() . '.' . strtolower($fileHandler->getClientOriginalExtension());
            $fileHandler->storeAs('admin/uploads/images', $fileName);
            $item->pic = $fileName;

        } 
        $item->created_at = date('Ymd H:i:s');
        $item->created_by = auth()->user()->id;
        
        if ($item->save()) {
            
            return redirect()->back()->withSuccess('تم إضافة صنف جديد بنجاح');
        } return redirect()->back()->withError('فشلت عملية إضافة صنف جديد ');
        
    }

    public function update (Request $req) {
        
        $item = StoreItem::find($req->id);
        if (!$item) {
            return redirect () -> back () -> withError('الصنف الذى تود تعديله غير موجود');
        }
        $item->edit(
            [
                'name'=>$req->name,
                'short'=>$req->short,
                'updated_by' => auth()->user()->id,
                'updated_at' => date('Ymd H:i:s'),
            ]
        );
        
       
        
        if ($item->update()) {
            Log::addRecord('create', $item);
            return redirect()->back()->withSuccess('تم إضافة صنف جديد بنجاح');
        } return redirect()->back()->withError('فشلت عملية إضافة صنف جديد ');
        
    }

    public function change_image (Request $req) {
        
        $item = StoreItem::find($req->id);
        //return var_dump($req->id);
        if ($item) {

            $file_to_be_deleted = $item->pic;
            if($req->hasFile('pic')) {
                $uploaded = $req->pic;

                $fileName = 'store_item_'. time() . '.' . strtolower($uploaded->getClientOriginalExtension());
                $uploaded->storeAs('admin/uploads/images', $fileName);
                $item->pic = $fileName;
                $item->updated_at = date('Ymd H:i:s');
                $item->updated_by = auth()->user()->id;
                
                if ($item->save()) {
                    if(File::exists($file_to_be_deleted)) {
                        File::delete($file_to_be_deleted);
                    }
                    Log::addRecord('changeImage', $item);
                    return redirect()->back()->withSuccess('تم تغيير صورة الصنف');
                } 
            }             
        } return redirect()->back()->withError('هذا الصنف غير موجود ربما تم حذفه أو حجبه من قبل الإدارة');
        
    }

    public function edit ($id) {
        $item =StoreItem::find($id);
        if ($item) {
            $vars ['item']= $item;
            return view ('admin.store.items.edit', $vars);
        } else {
            return redirect()->route('store.items.home')->withSuccess('الصنف الذى تبحث عنه غير موجود، ربما تم حذفه أو حجبه من قبل الإدارة');
        }
        
    }

    public function view ($id) {
        $item =StoreItem::find($id);
        if ($item) {
            $vars ['item']= $item;
            return view ('admin.store.items.view', $vars);
        } else {
            return redirect()->route('store.items.home')->withSuccess('الصنف الذى تبحث عنه غير موجود، ربما تم حذفه أو حجبه من قبل الإدارة');
        }
        
    }

    public function destroy ($id) {
        $item = StoreBox::find($id);
        $es = ReceiptEntry::where('box_size', $item->id)->get();
        if(count($es)>0) {
            return redirect()->back()->withError('لا يمكنك الحذف، هذا الحجم مرتبط بسجلات أخرى');
        }
        
        $fileHandler = public_path('../storage/app/admin/uploads/images/' . $item->pic);
        
        if ($item->delete()) {
            if(File::exists($fileHandler)) {
                File::delete($fileHandler);
            }
            // Log::addRecord('delete', $item);
            return redirect()->route('box.size.home')->withSuccess('تم حذف الصنف بنجاح');
        } return redirect()->back()->withError('فشلت عملية الحذف ');
    }
}
