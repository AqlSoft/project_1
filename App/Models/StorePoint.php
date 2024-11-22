<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StorePoint extends Model
{
    use HasFactory;

    protected $table = 'store_points';
    protected $fillable = ['table_id', 'section', 'positioning_receipt_id', 'receipt_id', 'room', 'partition', 'position', 'rack', 'code', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public static function edit ($id, $props) {
        $d = self::find($id);
        foreach($props as $key => $prop) {
            $d->$key = $prop;
        }
        return $d;
    }

}
