<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItem extends Model
{
    use HasFactory;


    public $totalInputs;
    public $totalOutputs;
    protected $table = 'store_items';
    public $timestamps = true;
    public $view_link='store.items.view';
    public $operations = [
        'create'=>'قام %s بإضافة صنف ثلاجة جديد',
        'update'=>'قام %s بتحديث بيانات صنف ثلاجة ',
        'delete'=>'قام %s بحذف بيانات صنف ثلاجة',
        'changeImage'=>'قام %s بتغيير صورة صنف ثلاجة',
    ];

    protected $fillable = ['name', 'short', 'parent_id', 'grade_id', 'brief', 'pic', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public static function getItemsNamesArray () {
        $storeItems = self::groupBy('id')->select('id', 'name')->get();
        $sia = [];
        foreach($storeItems as $item) {
            $sia[$item->id] = $item->name;
        }
        return $sia;
    }

    public function parent() {
        return $this->belongsTo(StoreItemCategory::class, 'parent_id');
    }

    public function grade() {
        return $this->belongsTo(StoreItemGrade::class, 'grade_id');
    }
    public function getItemInputs () {
        return ReceiptEntry::where(['item_id'=>$this->id])->sum('tableItemQty');
    }

    public function edit ($arr) {
        foreach ($arr as $prop => $val) {
            $this->$prop = $val;
        }
        return $this;
    }
}
