<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Support\Facades\File;
use Illuminate\Http\Request;

use App\Http\Controllers\info;


use App\Models\StoreItem;
use App\Models\Log;
use App\Models\StoreItemCategory;
use App\Models\StoreItemGrade;
use Exception;
use Illuminate\Database\QueryException;

!defined('PAGES') ? define ('PAGES', 10): null;
class StoreItemsController extends Controller
{
    use info;
    
    public function home () {
        $categories = StoreItemCategory::parents()->with('children')->get();
        $grades = StoreItemGrade::all();
        

        $items = StoreItem::where([])->orderBy('id', 'ASC')->paginate(PAGES);

        forEach ($items as $item) {$item->parent();}

        $vars = [
            'items'         => $items,
            'categories'=>$categories,
            'grades'=>$grades
        ];
        return view ('admin.store.items.home', $vars);
    }

    public function stats () {
        $items = StoreItem::where([])->orderBy('id', 'ASC')->get();
        $vars = [
            'items'         => $items,
        ];
        return view ('admin.store.items.stats', $vars);
    }

    public function store (Request $req) {
        try {
            $item = StoreItem::create([
                'name'          => $req->name,
                'short'         => $req->short,
                'parent_id'     => $req->parent,
                'grade_id'      => $req->grade,
                'brief'         => $req->brief,
                'pic'           => null,
                'updated_by'    => auth()->user()->id,
                'created_by'    => auth()->user()->id,
            ]);
            if($req->hasFile('pic')) {
                $fileHandler = $req->pic;
                
                $fileName = 'store_item_'. time() . '.' . strtolower($fileHandler->getClientOriginalExtension());
                if ($fileHandler->storeAs('uploads/images', $fileName)) {
                    $item->pic = $fileName;
                    $item->update();
                }
            } 
            return redirect()->back()->withSuccess('تم إضافة صنف جديد بنجاح');

        } catch (QueryException $err)  {
            return redirect()->back()->withError('فشلت عملية إضافة صنف جديد بسبب: '.$err);
        }

    }

    public function update (Request $req) {
        
        $item = StoreItem::find($req->item_id);
        if (!$item) {
            return redirect () -> back () -> withError('الصنف الذى تود تعديله غير موجود');
        }
        try {
            $item->update([
                'name'          => $req->name,
                'short'         => $req->short,
                'parent_id'     => $req->parent,
                'grade_id'      => $req->grade,
                'brief'         => $req->brief,
                'updated_by'    => auth()->user()->id,
            ]);
           
            return redirect()->back()->withSuccess('تم تحديث البيانات بنجاح');

        } catch (QueryException $err)  {
            return redirect()->back()->withError('فشلت عملية التحديث بسبب: '.$err);
        }
        
        //Log::addRecord('create', $item);
           
        
    }

    public function change_image (Request $req) {
        
        $item = StoreItem::find($req->id);
        $req->validate([
            'pic' => 'required|image|max:2048'
        ]);
        if ($item != null) {
            if($req->hasFile('pic')) {
                $fileHandler = $req->pic;
                
                $fileName = 'store_item_'. time() . '.' . strtolower($fileHandler->getClientOriginalExtension());
                
               if ($fileHandler->storeAs('uploads/images', $fileName)) {

                   $item->pic = $fileName;
                   $item->updated_by=auth()->user()->id;

                    $item->update();
                    return redirect()->back()->withSuccess('تم تحديث صورة المنتج بنجاح');
               } else {
                    return redirect()->back()->withSuccess('حدث خطأ أثناء رفع الملف');
               }
            }            
        } return redirect()->back()->withError('هذا الصنف غير موجود ربما تم حذفه أو حجبه من قبل الإدارة');
        
    }

    public function edit ($id) {
        $categories = StoreItemCategory::parents()->with('children')->get();
        $grades = StoreItemGrade::all();
        $item =StoreItem::find($id);
        if ($item) {
            $vars ['item']= $item;
            $vars ['categories']= $categories;
            $vars ['grades']= $grades;
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

    public function delete ($id) {
        $item = StoreItem::where(['id' => $id])->first();
        $fileHandler = env('APP_URL') . '/assets/admin/uploads/images/' . $item->pic;
        if ($item->delete()) {
            if(File::exists($fileHandler)) {
                File::delete($fileHandler);
            }
            Log::addRecord('delete', $item);
            return redirect()->route('store.items.home')->withSuccess('تم حذف الصنف بنجاح');
        } return redirect()->back()->withError('فشلت عملية الحذف ');
    }

}
