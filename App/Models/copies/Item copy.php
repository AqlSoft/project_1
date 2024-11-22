<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $table = 'items';
    protected $fillable =
        [
//          Basic Properties
            'a_name',                       //01
            'e_name',                       //02
            'type',                         //03
            'parent_cat',                   //04
            'brief',                        //05
            'measuring_unit',               //06
            'short_name',                   //07
            'barcode',                      //08

//          Null Properties
            'image',                        //11
            'origin',                       //12
            'model',                        //13
            'max_qty',                      //14
            'Min_stock',                    //15
            'partial_measuring_units',      //16

//          Fixed Properties
            'status',                       //17
            'company',                      //18
            'created_at',                   //19
            'updated_at',                   //20
            'created_by',                   //21
            'updated_by'                    //22
        ];

    //          Temp Properties
    public $serial_numbers;               //21
    public $cost;                         //22
    public $price;                        //23
    public $stock;                        //24

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
