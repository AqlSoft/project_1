<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Country;
use App\Models\Contract;
use Illuminate\Http\Request;
use App\Http\Controllers\info;
use App\Http\Requests\ClientRequest;
use App\Http\Controllers\Admin\Controller;
define('PAGE', 10);
class VendorsController extends Controller
{

   use info;

    //
    public static $scopes = [1=>'فردى', 2=>'مؤسسة', 3=>'شركة', 4=>'مصنع', 5=>'مزرعة', 6=>'تاجر',];
    public function index () {
        
        $clients = Client::where([])->orderBy('id', 'ASC')->paginate(PAGE);
        $vars = [
            'clients' => $clients,
            'scope'            => static::$scopes,
        ];
        return view('admin.clients.home', $vars);
    }

    public function create () {
        
        $lastClient = Client::where([])->orderBy('id', 'DESC')->first();
        
        // var_dump($countries);

        $vars = [
            'lastClient'    => $lastClient,
            'scope'         => static::$scopes
        ];
        return view('admin.clients.create', $vars);
    }

    public function store (ClientRequest $req) {
        //$admins = Admin::where([])->orderBy('id', 'DESC');
        $client = new Client();
        $client->name           = $req->name;
        $client->scope          = $req->scope;
        $client->s_number       = $req->s_number;
        $client->website        = $req->website;
        $client->email          = $req->email;
        $client->phone          = $req->phone;
        $client->vat            = $req->vat;
        $client->cr             = $req->cr;
        $client->person         = $req->person;
        $client->iqama          = $req->iqama;
        $client->state          = $req->state;
        $client->city           = $req->city;
        $client->street         = $req->street;
       
        $client->created_by     = auth()->user()->id;
        $client->created_at     = date('Y-m-d H:i:s');
        $client->company        = auth()->user()->company;
        
        if($client->save()) {
            return redirect()->route('clients.home')->withSuccess('تم إضافة عميل جديد بنجاح');
        } return redirect()->back()->withInput()->withError('خطأ فى حفظ البيانات');
    }

    public function edit ($id) {
        $client = Client::where(['id' => $id])->first();
        $lastClient = Client::where([])->orderBy('id', 'DESC')->first();
        
        $vars = [
            'lastClient'    => $lastClient,
            'client'        => $client,
            'scopes'            => static::$scopes,
        ];
        return view('admin.clients.edit', $vars);
    }

    public function update (ClientRequest $req) {
        
        $client = Client::where(['id' => $req->id, 'company' => auth()->user()->company])->first();
        $client->name           = $req->name;
        $client->scope          = $req->scope;
        $client->s_number       = $req->s_number;
        $client->website        = $req->website;
        $client->email          = $req->email;
        $client->phone          = $req->phone;
        $client->vat            = $req->vat;
        $client->cr             = $req->cr;
        $client->person         = $req->person;
        $client->iqama          = $req->iqama;
        $client->state          = $req->state;
        $client->city           = $req->city;
        $client->street         = $req->street;
        
        $client->updated_by     = auth()->user()->id;
        $client->updated_at     = date('Y-m-d H:i:s');
 
        
        
        if($client->update()) {
            return redirect()->route('clients.home')->withSuccess('تم تحديث بيانات العميل بنجاح');
        } return redirect()->back()->withInput()->withError('خطأ فى تحديث البيانات');
    }

    public function view ($id) {

        $vars = [
            'contracts'         => Contract::where(['client' => $id, 'company' => auth()->user()->company])->get(),
            'client'            => Client::where(['id' => $id])->first(),
            'scopes'            => static::$scopes,
        ];
        return view('admin.clients.view', $vars);
    }

    public function delete ($id) {
        $client = Client::where(['id' => $id])->first();
        return $client;
        // if($client->delete()) {
        //     return redirect()->back()->withSuccess('تم حذف العميل بنجاح');
        // } return redirect()->back()->withError('خطأ فى حذف البيانات');
    }



}
