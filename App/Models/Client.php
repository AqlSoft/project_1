<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    use HasFactory;

    protected $table = 'clients';
    protected $fillable = [
        'a_name', 
        'e_name', 
        'industry', 
        's_number',
        'website', 
        'phone', 
        'mobile', 
        'brand', 
        'email', 
        'address',  
        'vat', 
        'cr', 
        'files', 
        'created_by', 
        'updated_by', 
        'created_at', 
        'updated_at', 
        'status'
    ];

    public $contract;

    public static $ContactsRoles = [
        1=>'المدير العام',
        2=>'مسؤول التوقيع',
        3=>'مندوب',
        4=>'مسؤول مالى',
    ];

    public function contracts ()  {
        return $this->hasMany(Contract::class, 'client_id', 'id');
    }

    public function getContracts ()  {
        $this->contracts = Contract::where(['client_id'=>$this->id])->get();
    }

    public static function active () {
        $clients = Contract::groupBy('client_id', 'status')
        ->select('client_id')
        ->where('contracts.status', 1)
        ->get();
        return $clients->count();
    }

    public static function nonActive () {
        $clients = Contract::groupBy('client_id', 'status')
        ->select('client_id')
        ->where('contracts.status', '!=', 1)
        ->get();
        return $clients->count();
    }
   
    public static function edit($id, $props) {
        $client = self::find($id);
        foreach($props as $prop => $value) {
            $client->$prop = $value;
        }
        return $client;
    }

    public static function hasContract () {
        $clients = Contract::groupBy('client_id')
        ->select('client_id')
        ->get();
        return $clients->count();
    }

    public static function getClientsNamesArray () {
        $names= self::groupBy('id')->select('id', 'a_name', 'e_name')->get();
        $cna = [];
        foreach($names as $item) {
            $cna[$item->id] = $item->a_name;
        }
        return $cna;
    }

    public static function selectArrayOf ($key) {
        $key = self::select($key)->get();
        $ka= [];
        foreach($key as $in => $item) {
            array_push($ka, $item->$key);
        }
        return $ka;
    }
    
    public static function getClientTotalItems($id, $item, $box) {
        $inputs = ReceiptEntry::where(['item_id' => $item, 'client_id' => $id, 'box_size' => $box])->sum('inputs');
        $outputs = ReceiptEntry::where(['item_id' => $item, 'client_id' => $id, 'box_size' => $box])->sum('outputs');
        
        return $remaining = $inputs - $outputs;
    }

}
