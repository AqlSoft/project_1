<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Service extends Model
{
    use HasFactory;

    protected $table = 'services';
    protected $fillable =
        [
//          Basic Properties
            'name',                         //01
            'price',                        //02
            'brief',                        //03
            'price',                        //04
            'unit',                         //05

//          Fixed Properties
            'status',                       //6
            'company',                      //7
            'created_at',                   //8
            'updated_at',                   //9
            'created_by',                   //10
            'updated_by'                    //11
        ];

    //          Temp Properties
    public $serial_numbers;               
    public $cost;                         
    public $price;                        
    public $stock;                        

    public static function createNewInstance($req) {
        $instance = new self();
        $props = ['a_name', 'e_name', 'type', 'parent_cat', 'measuring_unit', 'short_name', 'barcode'];
        $staticProps = ['company' => auth()->user()->company, 'created_at' => date('Y-m-d H:i:s'), 'created_by' => auth()->user()->id, 'status' => 1, 'updated_at' => null,'updated_by' => null,];
        $nullProps = [ 'origin' => 'Not Specified', 'max_qty' => 0, 'model' => 'Not Set', 'partial_measuring_units' => 'Not Set','Min_stock' => 0 ];

        $instance->brief = html_entity_decode($req->brief);
        foreach ($props as $prop) {$instance->$prop = $req->$prop;}
        foreach ($staticProps as $sKey => $sProp) {$instance->$sKey = $staticProps[$sKey];}
        foreach ($nullProps as $nKey => $nProp) {$instance->$nKey = $req->$nKey != '' ? $req->$nKey : $nullProps[$nKey];}
        return $instance;
    }
}
