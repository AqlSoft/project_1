<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Admin\Controller;
use App\Http\Requests\DashboardSettingRequest;

use App\Models\Setting;
use App\Models\Admin;
use App\Models\DashboardSetting;

use Exception;
use Illuminate\Http\UploadedFile;
use Illuminate\Http\Request;

class DashboardSettingController extends Controller
{
    //

    

    public function index () {
        $dashboard = DashboardSetting::where('code', auth()->user()->company)->first();
        // var_dump($dashboard!=null);
        if ($dashboard != null) {
            if($dashboard['created_by'] != null) {
                $dashboard['created_by'] = Admin::where('id', $dashboard['created_by'])->value('name');
            }
            if($dashboard['updated_by'] != null) {
                $dashboard['updated_by'] = Admin::where('id', $dashboard['updated_by'])->value('name');
            }
        }

    
        return view('admin.admindashboard.index', ['data' => $dashboard]);
    }
    //
    public function edit () {
        $dashboard = DashboardSetting::where('code', auth()->user()->company)->first();
        if ($dashboard != null) {
            if($dashboard['created_by'] != null) {
                $dashboard['created_by'] = Admin::where('id', $dashboard['created_by'])->value('name');
            }
            if($dashboard['updated_by'] != null) {
                $dashboard['updated_by'] = Admin::where('id', $dashboard['updated_by'])->value('name');
            }
            return view('admin.admindashboard.edit', ['data' => $dashboard]);
        } 
        return redirect () -> back () -> with (['error'=>'جار العمل على الاعدادات']);

    
    }
    //
    public function setting () {

        $vars['storingPeriods'] = Setting::getStoringPeriods();
        $vars['currentPeriod'] = Setting::getCurrentPeriod();
        
        return view('admin.home.setting', $vars);
       
    }

    public function addStoringPeriod (Request $req) {
        $storingPeriod = new Setting();

        $storingPeriod->name = 'Storing Period';

        $storingPeriod->value=json_encode([
            'save_name' => $req->save_name,
            'starts_in'=>$req->starts_in,
            'ends_in'=>$req->ends_in,
        ]);
        $storingPeriod->created_at=date('Y-m-d H:i:s');
        $storingPeriod->created_by=auth()->user()->id;
        
        try {
            //try adding a new Storing periof
            $storingPeriod->save();
            // $storingPeriod->save();

            // check if client requested to set as current period
            if ($req->current_period == true) {
                // searching for the Current Period record in db table
                $oldPeriod = Setting::where(['name'=>'Storing Period', 'status'=>1])->first();
                // if no records for the current period
                if ($oldPeriod) {
                    $oldPeriod->status=0;
                    $oldPeriod->update();
                } 
                
                $storingPeriod->status = 1;
                $storingPeriod->update();
            }
            
            return redirect () -> back() -> with (['success'=>'تم إضافة فترة تخزينية جديدة']);
        } catch (Exception $e) {
            return redirect () -> back() -> with (['error'=>'لم يتم حفظ الفترة']);
        } 
    }
    public function setPeriodActive ( $id) {
        $oldPeriod = Setting::where(['name'=>'Storing Period', 'status'=>1])->first();
        
        $current = Setting::find($id);
        $current->status=1;
        try {
            $current->update();
            if ($oldPeriod) {
                $oldPeriod->status=0;
                $oldPeriod->update();
            }
            return redirect ()->back()->with(['success'=>'تم ضبط الفترة كـ (فترة نشطة)']);
        } catch (Exception $e) {
            return redirect ()->back()->with(['success'=>'لم يتم تغيير الحالة، حدث خطأ غير معروف']);
        }
    }
    //
    public function update (DashboardSettingRequest $req) {
        $dashboard = DashboardSetting::where('code', auth()->user()->company)->first();
        
        $dashboard->name = $req->name;
        $dashboard->phone = $req->phone;
        $dashboard->address = $req->address;
        $dashboard->updated_by = auth()->user()->id;
        $dashboard->updated_at = date('Y-m-d H:i:s');
    
        if($req->hasFile('icon')) {
            $fileHandler = $req->icon;
            $newName = 'dashboard_logo_' . $dashboard->code . date('_Ymd_Hsi') . '.' . $req->icon->extension();
            $saveName = $fileHandler->storeAs('uploads/logo', $newName);
            $dashboard->icon = $saveName;
        }
        try {
            $dashboard->update();
            return redirect()->route('admin.dashboard.show');
        } catch (Exception $e) {
            return redirect()->route('admin.dashboard.edit')->with('Failed to update due to '.$e->getMessage());
        }

        
        
    }
}
