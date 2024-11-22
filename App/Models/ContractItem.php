<?php

namespace App\Models;

use App\Models\Item;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractItem extends Model
{
    use HasFactory;

    public $timestamps = true;
    
    protected $table = 'contract_items';
    protected $fillable = [
        'item_id', 'qty', 'price', 'status', 'contract_id', 'period_id',
        'created_by', 'updated_by', 
        'created_at', 'updated_at'];

    public static function getLargePalletsFor($contractId) {
        $ls = self::where(['contract_id'=>$contractId, 'item_id'=>2])->first();
        return $ls == null ? 0 : $ls->qty;
    }
    public static function getSmallPalletsFor($contractId) {
        $ls = self::where(['contract_id'=>$contractId, 'item_id'=>1])->first();
        return $ls == null ? 0 : $ls->qty;
    }


    public function item () {
        return $this->belongsTo(Item::class, 'item_id');
        //return Item::find($this->item);
    }
}
