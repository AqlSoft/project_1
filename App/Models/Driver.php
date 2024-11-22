<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Driver extends Model
{
    use HasFactory;

    protected $table = 'drivers';
    protected $fillable = [
        //          Basic Properties
        'a_name',                       //01
        'e_name',                       //02
        'car_type',                     //03
        'nationality',                  //04
        'iqama',                        //05
        'phone_number',                 //06
        'car_panel',                    //07
        'car_model',                    //08
        'files',                        //09

        //          Fixed Properties
        'status',                       //10
        'created_at',                   //11
        'updated_at',                   //12
        'created_by',                   //13
        'updated_by'                    //14
    ];

    public static function edit ($id, $arr) {
        $d = self::find($id);
        foreach ($arr as $key => $val) {
            $d->$key = $val;
        }
        return $d;
    }

}
