<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreBox extends Model
{
    use HasFactory;

    protected $table = 'store_boxes';
    protected $fillable = ['name', 'pic', 'company', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public static function getBoxesNamesArray () {
        $storeBoxes= self::groupBy('id')->select('id', 'name')->get();
        $bsa = [];
        foreach($storeBoxes as $item) {
            $bsa[$item->id] = $item->name;
        }
        return $bsa;
    }
}
