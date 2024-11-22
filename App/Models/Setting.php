<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;
    protected $table = 'settings';
    protected $fillable = ['name', 'value', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public static function getStoringPeriods () {
        $sp = self::where('name', 'Storing Period')->get();
        foreach ($sp as $in => $p) {
            $value = json_decode($p->value);
            $p->data = $value;
        }
        return $sp;
    }

    public static function getCurrentPeriod () {
        //what is current period record?
        $cp = self::where(['name'=>'Storing Period', 'status'=>1])->first();
        if (null != $cp) {
            $val=json_decode($cp->value);
            $cp->save_name = $val->save_name;
            $cp->starts_in = $val->starts_in;
            $cp->ends_in = $val->ends_in;
            return $cp;
        }
        return false;
    }

}
