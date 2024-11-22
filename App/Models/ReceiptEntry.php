<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReceiptEntry extends Model
{
    use HasFactory;
    protected $fillable = [
        'type', 'table_id', 'tableItemQty', 'inputs', 'outputs', 'table_size', 
        'store_point', 'hij_date', 'greg_date', 'box_size', 
        'client_id', 'contract_id', 'receipt_id', 'item_id', 
        'created_by', 'updated_by', 'created_at', 'updated_at'
    ];

    public $itemLoad = [];
    public $itemsArray;
    public $itemsBoxes;


    public function contract() {
        return $this->belongsTo(Contract::class, 'contract_id');
    }

    /**
     * يقوم بعمل التعديلات اللازمة حسب مصفوفة البيانات المرسلة
     *
     * @return \int filles in large pallets 
     */
    public static function edit ($id, $arr) {
        $d = self::find($id);
        foreach ($arr as $key => $val) {
            $d->$key = $val;
        }
        return $d;
    }
    
    /**
     * يقوم بجلب بيانات الصنف المخزني المرتبط بالسجل
     *
     * @return \int filles in large pallets 
     */
    public function storeItem () {
        return $this->belongsTo(StoreItem::class, 'item_id');
    }
    
    /**
     * يقوم بجلب بيانات الشخص الذى أنشأ أو أضاف هذا السجل
     *
     * @return \int filles in large pallets 
     */
    public function creator () {
        return $this->belongsTo(Admin::class, 'created_by');
    }
    
    /**
     * يقوم بجلب بيانات الشخص الذي قام بتعديل ابيانات لهذا السجل
     *
     * @return \int filles in large pallets 
     */
    public function editor () {
        return $this->belongsTo(Admin::class, 'updated_by');
    }

    /**
     * يقوم بجلب بيانات حجم الكرتون المرتبط بالسجل
     *
     * @return \int filles in large pallets 
    */
    public function storeBox () {
        return $this->belongsTo(StoreBox::class, 'box_size');
    }
    
    /**
     * يقوم بجلب بيانات الطبلية المرتبطة بالسجل
     *
     * @return \int filles in large pallets 
    */
    public function table () {
        return $this->belongsTo(Table::class);
    }
        
    /**
     * يقوم بجلب بيانات الطبلية المرتبطة بالسجل
     *
     * @return \int filles in large pallets 
    */
    public function client () {
        return $this->belongsTo(Client::class);
    }

    /**
     * Searching for filled in large pallets and still inside the fredge.
     *
     * @return \int filles in large pallets 
    */
    public static function getLargeFilledFor($contract) {
        $count = 0;
        $lt_in = self::groupBy('table_id')->select('table_id', self::raw('SUM(inputs) as total_in'))->where(['contract_id'=>$contract, 'table_size'=>2])->distinct()->get();
        foreach ($lt_in as $table) {
           $m = self::select(self::raw('SUM(outputs) as total_out'))->where(['contract_id'=>$contract, 'table_id'=>$table->table_id])->first();
            $out = $m->total_out == null ? 0 : $m->total_out;
            if ($table->total_in - $out > 0) {
                $count++;
            }
        }
        return $count;
    }

    public static function getTotalInputsFor($table, $contract, $item, $box) {
        return ReceiptEntry::select(ReceiptEntry::raw('SUM(inputs) AS inputs'))->where(['table_id'=> $table, 'contract_id' => $contract, 'item_id'=> $item, 'box_size'=>$box])->first()->inputs;
    }
    
    public static function getTotalOutputsFor($table, $contract, $item, $box) {
        return ReceiptEntry::select(ReceiptEntry::raw('SUM(outputs) AS inputs'))->where(['table_id'=> $table, 'contract_id' => $contract, 'item_id'=> $item, 'box_size'=>$box])->first()->outputs;
        
    }

       /**
     * Searching for filled in large pallets and still inside the fredge.
     *
     * @return \int filles in large pallets 
     */
    public static function getSmallFilledFor($contract) {
        $count = 0;
        $lt_in = self::groupBy('table_id')->select('table_id', self::raw('SUM(tableItemQty) as total_in'))->where(['contract_id'=>$contract, 'table_size'=>1, 'type' => 1])->distinct()->get();
        foreach ($lt_in as $table) {
           $m = self::select(self::raw('SUM(tableItemQty) as total_out'))->where(['contract_id'=>$contract, 'table_id'=>$table->table_id, 'type' => 2])->first();
            $out = $m->total_out == null ? 0 : $m->total_out;
            if ($table->total_in - $out > 0) {
                $count++;
            }
        }
        return $count;
    }

    private static function getOutsFor($item) {
        return self::where(['contract_id'=>$item->contract_id, 'item_id'=>$item->item_id, 'box_size'=>$item->box_size, 'type'=>2])->sum('tableItemQty');
    }

    public static function calculateOuts($collection) {
        foreach ($collection as $in => $record) {
            $record->totalOutputs = static::getOutsFor($record);
        }
    }
}
