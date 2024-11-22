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
            'parent_cat',                   //03
            'brief',                        //04
            'measuring_unit',               //05
            'barcode',                      //06

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

}
