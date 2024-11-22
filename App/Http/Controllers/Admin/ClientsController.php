<?php

namespace App\Http\Controllers\Admin;

use App\Models\Admin;
use App\Models\Client;
use App\Models\Country;
use App\Models\Contact;
use App\Models\Contract;
use App\Models\ContractItem;
use App\Models\StoreItem;
use App\Models\StoreBox;
use App\Models\ReceiptEntry;
use App\Models\ClientContact;


use Illuminate\Http\Request;

use App\Http\Controllers\Admin\Controller;
use App\Http\Controllers\info;

use App\Http\Requests\ClientRequest;
use App\Http\Requests\UpdateClientRequest;
use Illuminate\Database\QueryException;

class ClientsController extends Controller
{
   use info;
    //

    public static $pages = 10;
    public static $industry = [1=>'فردى', 2=>'مؤسسة', 3=>'شركة', 4=>'مصنع', 5=>'مزرعة', 6=>'تاجر',];


    public function index () {
        $clients2 = Client::with('contracts')->where([])
        ->orderBy('id', 'ASC')
        ->paginate(10);


       
        $vars = [
            'clients2'              => $clients2,
            'contacts'              => Contact::contactsArray(),
            'scope'                 => self::$industry,
            'activeClients'         => Client::active(),
            'nonActiveClients'      => Client::nonActive(),
            'allClients'            => Client::all()->count(),
            'hasContract'           => Client::hasContract(),
            'hasMultiContract'      => Client::withCount('contracts')->count(),
        ];
        return view('admin.clients.home', $vars);
    }

    public function create () {
        
        $lastClient = Client::where([])->orderBy('id', 'DESC')->first();
        $lc = $lastClient == null ? str_pad(1, 9, '450600000', STR_PAD_LEFT) : $lastClient->s_number + 1;
        // var_dump($countries);

        $vars = [
            'lastClient'    => $lc,
            'scopes'         => self::$industry
        ];
        return view('admin.clients.create', $vars);
    }

    public function store (Request $req) {
        //$admins = Admin::where([])->orderBy('id', 'DESC');
        try {
            $client = Client::create([
                'a_name'            => $req->name,
                'industry'          => $req->scope,
                's_number'          => $req->s_number,
                'website'           => $req->website,
                'email'             => $req->email,
                'phone'             => $req->phone,
                'vat'               => $req->vat,
                'cr'                => $req->cr,

                'created_by'        => auth()->user()->id,
                
            ]);

            if ($client) {
                return redirect()->route('clients.view', [$client->id])->withSuccess('تم إضافة عميل جديد بنجاح');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withError('خطأ فى حفظ البيانات:'.$e);
        }
    }

    public function edit ($id) {
        $client = Client::where(['id' => $id])->first();
        $lastClient = Client::where([])->orderBy('id', 'DESC')->first();
        $lc = $lastClient == null ? str_pad(1, 9, '450000000', STR_PAD_LEFT) : $lastClient->s_number + 1;
        $countries = Country::all();
        $contacts = Contact::all();
        $clientContacts = ClientContact::where(['clients_contacts.client'=>$client->id])->get();
        
        foreach($clientContacts as $contact) {
            $contact->person = Contact::find($contact->contact);
        }

        $roles = Client::$ContactsRoles;
        
        $vars = [
            'location'          => 'im here',
            'lastClient'        => $lc,
            'client'            => $client,
            'countries'         => $countries,
            'contacts'          => $contacts,
            'scopes'            => self::$industry,
            'clientContacts'    => $clientContacts,
            'roles'            => $roles
        ];
        return view('admin.clients.edit', $vars);
    }
 
    public function settings () {
        $client = Client::where(['id' => 3])->first();
        
        
        $vars = [
            'lastClient'    => '$lastClient',
            'client'        => $client,
            'scopes'        => self::$industry,
        ];
        return view('admin.clients.edit', $vars);
    }

    public function update (UpdateClientRequest $req) {
        
      try {
            Client::edit($req->id, [

                'a_name'           => $req->a_name,
                'e_name'           => $req->e_name,
                'industry'          => $req->scope,
                's_number'       => $req->s_number,
                'website'        => $req->website,
                'email'          => $req->email,
                'phone'          => $req->phone,
                'vat'            => $req->vat,
                'cr'             => $req->cr,
                'updated_by'     => auth()->user()->id
                
            ])->update();
            return redirect()->back()->withSuccess('تم تحديث بيانات العميل بنجاح');
        } catch (QueryException $e) {
            return redirect()->back()->withInput()->withError('خطأ فى تحديث البيانات: '.$e);
        }
    }

    public function view ($id) {

        $client = Client::find($id);
        
        // $country = null != $client->country ? Country::find($client->country)->a_name : '';
        

        $vars = [ 
            // 'country'           => $country,
            'client'            => $client,
            'scopes'            => self::$industry,
        ];
        return view('admin.clients.view', $vars);
    }

    public function delete ($id) {
        $client = Client::where(['id' => $id])->first();
        //return $client;
        try {
            $client->delete();
            return redirect()->back()->withSuccess('تم حذف العميل بنجاح');
        } catch (QueryException $e) {
            return redirect()->back()->withError('خطأ، لا يمكنك حذف بيانات عميل مرتبط بسجلات أخرى.');
        }
    }

    public function storeItemQuantityForClients() {
        $contract_ids = Contract::select('id')->get();
        $clients_ids = Client::select('id')->get()->toArray();//Client::selectArrayOf ('id');
        $contracts = ReceiptEntry::whereIn('contract_id', $contract_ids)
        ->groupBy('contract_id', 'item_id', 'box_size', 'client_id')
        ->select('contract_id', 'item_id', 'box_size', 'client_id', ReceiptEntry::raw('SUM(inputs) AS totalInputs'))
        ->where(['type'=> 1])
        ->get();

        ReceiptEntry::calculateOuts($contracts);
        //var_dump($clients_ids);
        $items = buildIndexedArray($contracts);
        $vars ['clients'] = $items;
        $vars ['storeItems']    = StoreItem::getItemsNamesArray();
        $vars ['clientsNames']  = Client::getClientsNamesArray();
        $vars ['storeBoxes']    = StoreBox::getBoxesNamesArray();
        return view('admin.clients.reports.storeitems', $vars);
    }

    public function clients_with_active_contracts() {
        
    }
    
    public function stats () {
        return 'Hello World!';
    }

    public function itemsQuantitiesForClients (Request $req) {

        if (null != $req->searchQuery) {
            $items = $req->searchQuery;
           
            $itemsCollection = ReceiptEntry::whereIn('receipt_entries.item_id', $items)
                ->select ('item_id', 'store_items.name as itemName', 'client_id', 'clients.a_name as clientAName', 'clients.e_name as clientEName', 'box_size', 'store_boxes.name as boxName')
                ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
                ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
                ->join('clients', 'clients.id', '=', 'receipt_entries.client_id')
                ->groupBy('item_id', 'client_id', 'box_size')
                ->get();

            foreach ($itemsCollection as $in => $record) {
                $record->remaining = Client::getClientTotalItems($record->client_id, $record->item_id, $record->box_size);
               
            }
            $vars ['storeItems']    = StoreItem::getItemsNamesArray();
            $vars ['query']         = $req->searchQuery;
            $vars ['collection']    = $itemsCollection;
        } else {
            $vars ['storeItems']    = StoreItem::getItemsNamesArray();
            $vars ['query']         = $req->searchQuery;
            $vars ['collection']    = null;
        }
        return view('admin.clients.reports.itemsStats', $vars);
    }

    // Control Contacts

    public function addContact (Request $req) {
        
        try {

            $client_contact = ClientContact::create([
                'client'=>$req->client,
                'contact'=>$req->contact,
                'role'=>$req->role,
                'status'=>1,
                'created_by'=>auth()->user()->id,
                
            ]);
            if ($client_contact) {
                return redirect()->back()->withSuccess('تم تعيين جهة الاتصال بنجاح');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withError('حدث خطأ غير متوقع، يرجى المحاولة لاحقا');
        }
        return $req;

    }
    

    public function editContact (Request $req) {
        
        try {

            $client_contact = ClientContact::create([
                'client'=>$req->client,
                'contact'=>$req->contact,
                'role'=>$req->role,
                'status'=>1,
                'created_by'=>auth()->user()->id,
                
            ]);
            if ($client_contact) {
                return redirect()->back()->withSuccess('تم تعيين جهة الاتصال بنجاح');
            }
        } catch (QueryException $e) {
            return redirect()->back()->withError('حدث خطأ غير متوقع، يرجى المحاولة لاحقا');
        }
        return $req;

    }

    public function searchStoreItemsReport(Request $req) {
        if ($req->storeItem == 'الكـــــــــــل') {
            $searchArray = ['type'=> 1];
        } else {
            $searchArray = ['type'=> 1, 'item_id'=>$req->storeItem];
        }
        
        $contract_ids = Contract::select('id')->get();
        $clients_ids = Client::select('id')->get()->toArray();//Client::selectArrayOf ('id');
        $contracts = ReceiptEntry::whereIn('contract_id', $contract_ids)
        ->groupBy('contract_id', 'item_id', 'box_size', 'client_id')
        ->select('contract_id', 'item_id', 'box_size', 'client_id', ReceiptEntry::raw('SUM(inputs) AS totalInputs'))
        ->where($searchArray)
        ->get();

        ReceiptEntry::calculateOuts($contracts);
        //var_dump($clients_ids);
        $items = buildIndexedArray($contracts);
        $vars['clients'] = $items;
        $vars ['storeItems']    = StoreItem::getItemsNamesArray();
        $vars ['clientsNames']  = Client::getClientsNamesArray();
        $vars ['storeBoxes']    = StoreBox::getBoxesNamesArray();
        return view('admin.clients.reports.searchitems', $vars);
    }

    public function reports () {
        
        
        return view('admin.clients.reports.home', []);
    }

    public function contracts () {

        $allContracts = Contract::where(['status'=>1])->get();
        foreach ($allContracts as $item) {
            $client = Client::find($item->client_id);
            $item->clientName = $client ? $client->a_name : 'No Name';
            $item->getBookedTablesCount();
            $item->getConsumedTablesCount();
            
            $item->getOccupiedTablesCount();
        }

        // $clients = Client::where([])->orderBy('s_number', 'ASC')->paginate(self::$pages);
        // foreach($clients as $c => $client) {
        //     $contracts = Contract::where(['client' => $client->id])->get();
        //     foreach ($contracts as $cc => $item) {
        //         $item->largePallets = ContractItem::getLargePalletsFor($item->id);
        //         $item->smallPallets = ContractItem::getSmallPalletsFor($item->id);
        //         $item->largeFilled  = ReceiptEntry::getLargeFilledFor($item->id);
        //         $item->smallFilled  = ReceiptEntry::getSmallFilledFor($item->id); 
        //     }
            
        //     $client->contracts=$contracts;
        // }
        //$vars['tables']=$contractTables;
        $vars['contracts'] = $allContracts;
        //$vars['clients'] = $clients;
        $vars['scopes'] = self::$industry;
        return view('admin.clients.reports.contracts', $vars);
    }
    
    public function contracts_search (Request $req) {
        $ajax_search_query = $req->search;
        $clients = Client::where('name', 'LIKE', "%{$ajax_search_query}%")->orderBy('s_number', 'ASC')->paginate(self::$pages);
        foreach($clients as $c => $client) {
            $contracts = Contract::where(['client' => $client->id])->get();
            $client->the_type = self::$industry[$client->scope];
            foreach ($contracts as $cc => $item) {
                $item->largePallets = ContractItem::getLargePalletsFor($item->id);
                $item->smallPallets = ContractItem::getSmallPalletsFor($item->id);
                $item->largeFilled  = ReceiptEntry::getLargeFilledFor($item->id);
                $item->smallFilled  = ReceiptEntry::getSmallFilledFor($item->id);
            }
            $client->contracts=$contracts;
        }
        $vars['clients'] = $clients;
        return view('admin.clients.reports.contracts_search', $vars);
    }

    public function ajax_search (Request $req) {
        if ($req->ajax()) {
            $ajax_search_query = $req->search;
            $data = Client::where('a_name', 'LIKE', "%{$ajax_search_query}%")->orderBy('id', 'DESC')->paginate(self::$pages);
        }
        return view('admin.clients.ajsearch', ['clients2' => $data, 'scopes' => self::$industry,]);
    }
}
