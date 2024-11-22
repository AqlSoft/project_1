<?php

namespace App\Models;

use App\Models\ContractItem;
use App\Models\Table;
use App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Contract extends Model
{
    use HasFactory;

    public $timestamps=true;
    protected $table = 'contracts';
    public $remainingDays;
    protected $fillable = [
        'code', 'brief', 'start_period', 'renew_period', 'in_day_greg', 
        'in_day_hij', 'client_id',  'starts_in_greg', 'starts_in_hij', 
        'ends_in_greg', 'ends_in_hij', 'type', 's_number', 'status', 
        'company', 'created_by', 'updated_by', 
        'created_at', 'updated_at'];

    public $bookedTables = ['small'=>0, 'large'=>0];
    public $consumedTables = ['small'=>0, 'large'=>0];
    public $occupiedTables = ['small'=>0, 'large'=>0];

    public const default_starting_period = 3;

    public static function edit ($id, $arr) {
        $d = self::find($id);
        foreach ($arr as $key => $val) {
            $d->$key = $val;
        }
        return $d;
    }

    public function client() {
        return $this -> belongsTo(Client::class, 'client_id');
    }

    public function periods() {
        return $this -> hasMany(Period::class, 'contract_id', 'id');
    }

    public static function tablesCount () {
        $contracts = self::where(['status' => 1])->get();
        foreach ($contracts as $i => $contract) {
            $contract->small = 1;
        }
        return $contracts;
    }

    public function items () {
        return $this->hasMany(ContractItem::class, 'contract_id', 'id');
    }

    public function getBookedTablesCount () {
        $contractItems = ContractItem::where(['contract_id'=>$this->id])->get();
        foreach ($contractItems as $item) {
            if ($item->item_id == 1) {
                $this->bookedTables['small'] = $item->qty;
            } elseif ($item->item_id == 2) {
                $this->bookedTables['large'] = $item->qty;
            } elseif ($item->item_id == 3) {
                $this->bookedTables['small'] += 220;
            } elseif ($item->item_id == 4) { 
                $this->bookedTables['small'] += 90;
            }
        }

    }

    public function getConsumedTablesCount () {
        $this->consumedTables =  [
            'small'=>count(ReceiptEntry::groupBy('table_id')->select('table_id')->where(['contract_id'=>$this->id, 'table_size'=>1])->get()),
            'large'=>count(ReceiptEntry::groupBy('table_id')->select('table_id')->where(['contract_id'=>$this->id, 'table_size'=>2])->get()),
        ];
    }

    public function tablesConsumedBetween ($start, $end) {

        $this->tablesUsed =  [
            'small'=>count(ReceiptEntry::groupBy('table_id')->select('table_id')->where(['contract_id'=>$this->id, 'table_size'=>1])->whereBetween('created_at',[$start, $end])->get()),
            'large'=>count(ReceiptEntry::groupBy('table_id')->select('table_id')->where(['contract_id'=>$this->id, 'table_size'=>2])->whereBetween('created_at',[$start, $end])->get()),
        ];
    }

    public function tablesExitedBetween ($start, $end) {
        $small = ReceiptEntry::groupBy('table_id')
        ->select('table_id')
        ->where(['contract_id'=>$this->id, 'table_size'=>1])
        ->whereBetween('created_at',[$start, $end])
        ->havingRaw('SUM(inputs) - SUM(outputs) <= 0')
        ->get();
        $large = ReceiptEntry::groupBy('table_id')
        ->select('table_id')
        ->where(['contract_id'=>$this->id, 'table_size'=>2])
        ->whereBetween('created_at',[$start, $end])
        ->havingRaw('SUM(inputs) - SUM(outputs) <= 0')
        ->get();
        $this->exitedTables =  [
            'small'=>count($small),
            'large'=>count($large),
        ];
    }

    public function getOccupiedTablesCount () {
        $this->occupiedTables = ['small'=>0,'large'=>0];
        
        $contractTables = ReceiptEntry::where('contract_id', $this->id)
        ->groupBy('table_id', 'table_size')
        ->select('table_id', 'table_size', ReceiptEntry::raw('sum(inputs) as total_inputs'), ReceiptEntry::raw('sum(outputs) as total_outputs'))
        ->get();

        foreach ($contractTables as $item) {
            if ($item->total_inputs - $item->total_outputs > 0) {
                if($item->table_size == 1) {
                    $this->occupiedTables['small'] += 1;
                } elseif ($item->table_size == 2) {
                    $this->occupiedTables['large'] += 1;
                }   
            }
        }
    }

    public static function getContractItems($contracts) {
        foreach($contracts as $i => $contract) {
            $contract -> items = [1,2,3];
        }
    }

    public static function getContractQty($id) {
        return ReceiptEntry::select()->where('inputs', '>', 0)->where(['contract_id'=>$id])->sum('inputs');
    }

    public function checkLargeTablesCredit () {
        $credit = ContractItem::where(['contract_id' => $this->id, 'item_id' => 1])->first();
        $this->largeTablesCredit = $credit->qty;
        $consumed = Table::where(['contract_id'=> $this->id, 'size' => 2])->get();
        $this->largeTablesConsumed = count($consumed);
        return $this->largeTablesConsumed;
        //-$this->largeTablesConsumed > 0;
    }

    public function getLargeTablesCredit() {
        $credit = ContractItem::where(['contract_id' => $this->id, 'item_id' => 1])->first();
        return null != $credit ?  $credit->qty : 0;
    }

    public function isActive(){
        return strtotime($this->ends_in_greg) > time() && strtotime($this->starts_in_greg) <= time() ? true : false;
    }

    public function remaining () {
        $this->remainingDays = ceil((strtotime($this->ends_in_greg) - time())/60/60/24);
    }

}
