<?php

namespace App\Models;

use App\Models\ReceiptEntry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Table extends Model
{
    use HasFactory;
    public $view_link = 'table.view';
    public $total_inputs;
    public $total_outputs;
    public $load;
    public $max_load;
    // رسائل المراقبة التى تظهر فى سجل العمليات 
    public $operations = [
        'add'=>'قام %s بإضافة طبلية جديدة',
        'update'=>'قام %s بتحديث بيانات طبلية ',
        'delete'=>'قام %s بحذف بيانات طبلية'
    ];
    

    protected $table = 'tables';
    protected $fillable = ['name', 'size', 'capacity', 'serial', 'contract_id', 'client_id', 'store_point_id', 'the_load', 'created_by', 'updated_by', 'created_at', 'updated_at', 'table_status'];
 
    public static function calcEmptySmall() {
        $tables = self::select('id', 'size', 'the_load')->get();
        $smallCounter = 0;
        $largeCounter = 0;
        foreach ($tables as $table) {
            $table->the_load = self::getTableLoad($table->id);
            
            if ($table->the_load > 0 ) {
                if ($table->size ==1) $smallCounter++;
                if ($table->size ==2) $largeCounter++;
            }
        }
        return [$smallCounter, $largeCounter];
    }

    public function getEntriesFor($id) {
        $entries = ReceiptEntry::select('receipt_entries.*', 'store_items.name as itemName', 'store_boxes.short as boxName', 'receipts.s_number as receipt_sn', 'admins.userName as admin')
        ->join('store_items', 'store_items.id', '=', 'receipt_entries.item_id')
        ->join('store_boxes', 'store_boxes.id', '=', 'receipt_entries.box_size')
        ->join('receipts', 'receipts.id', '=', 'receipt_entries.receipt_id')
        ->join('admins', 'admins.id', '=', 'receipt_entries.created_by')
        ->where(['receipt_entries.table_id' => $this->id, 'receipt_entries.contract_id'=>$id])->get();
        $this->max_load = self::$maximum_load[$this->size];
        $this->the_load = $this->getTableInputsFor($id) - $this->getTableOutputsFor($id);
        return $entries;
    }

    public function getTableLocation () {
        return 'service not working right now';
    }

    public function getTablesLocations () {
        return 'service not working right now';
    }

    public static function calcTableLoad ($table_id, $contract_id = []) {
        $table= self::find($table_id);
        $info = [
            'inputs'    =>$table->getTableInputsFor($contract_id), 
            'outputs'   =>$table->getTableOutputsFor($contract_id), 
            'total'     =>$table->getTableInputsFor($contract_id) - $table->getTableOutputsFor($contract_id)
        ];
        return $info;
    }

    public function load ($contract_id) {
        
        $inputs = ReceiptEntry::select('inputs')->where(['contract_id'=>$contract_id])->sum('inputs');
        $outputs = ReceiptEntry::select('outputs')->where(['contract_id'=>$contract_id])->sum('outputs');
        
        return $inputs - $outputs;
        
    }

    public static function calcTableItemQty ($table_id, $item_id, $contract_id) {
        $info = [];
        $inputs    = static::getTableItemInputs ($table_id, $item_id, $contract_id);
        $outputs   = static::getTableItemOutputs ($table_id, $item_id, $contract_id);

        $info = $inputs - $outputs;
        return $info;
    }

    protected static function getTableItemInputs ($table_id, $item_id, $contract_id) {
        return  ReceiptEntry::where(['table_id'=>$table_id, 'contract_id'=>$contract_id, 'item_id' => $item_id, 'type'=>1])->sum('tableItemQty');
    }
    
    protected static function getTableItemOutputs ($table_id, $item_id, $contract_id) {
        return  ReceiptEntry::where(['table_id'=>$table_id, 'contract_id'=>$contract_id, 'item_id' => $item_id, 'type'=>2])->sum('tableItemQty');
    }

    public function getTableInputsFor ($id) {
        return $this->totalInputs = ReceiptEntry::where(['table_id'=>$this->id, 'contract_id'=>$id, 'type'=>1])->sum('tableItemQty');
    }

    public function getTableOutputsFor ($id) {
        return $this->totalOutputs = ReceiptEntry::where(['table_id'=>$this->id, 'contract_id'=>$id, 'type'=>2])->sum('tableItemQty');
    }
    protected static function getTableLoad($id) {
        $inputs = ReceiptEntry::select('tableItemQty')->where(['table_id'=>$id, 'type'=>1])->sum('tableItemQty');
        $outputs = ReceiptEntry::select('tableItemQty')->where(['table_id'=>$id, 'type'=>2])->sum('tableItemQty');
        return $inputs - $outputs;
    }

    public function content ($id) {
        $entries = ReceiptEntry::select([
            'item_id',
            'box_size',
            ReceiptEntry::raw('sum(inputs) as total_inputs'),
            ReceiptEntry::raw('sum(outputs) as total_outputs')
        ])
        ->groupBy('item_id', 'box_size')
        ->join('store_items','store_items.id','=','receipt_entries.item_id')
        ->join('store_boxes','store_boxes.id','=','receipt_entries.box_size')
        ->where(['receipt_entries.table_id'=> $this->id, 'receipt_entries.contract_id'=>$id])
        ->get();
        return $entries;
    }

    
    
    
    
    private static $maximum_load = 
    [
        1 => [
            [1, 600, 'كرتون 1 كيلو', '600 كرتون'],
            [3, 221, 'كرتون 3 كيلو', '221 كرتون'],
            [4, 128, 'كرتون 4 كيلو', '128 كرتون'],
            [5, 100, 'كرتون 5 كيلو', '100 كرتون'],
            [8, 108, 'كرتون 8 كيلو', '104 كرتون'],
            [20, 34, 'كرتون موز [20ك]', '34 كرتون']
        ],
        2 => [
            [3, 286, 'كرتون 3 كيلو', '286 كرتون'],
            [4, 172, 'كرتون 4 كيلو', '172 كرتون'],
            [5, 140, 'كرتون 5 كيلو', '140 كرتون'],
            [8, 144, 'كرتون 8 كيلو', '144 كرتون'],
            [20, 47, 'كرتون موز [20ك]' , '47 كرتون']
        ]

    ];

}
