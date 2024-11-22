<?php

namespace App\Models;
use App\Helpers\Extra;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Receipt extends Model
{
    use HasFactory;


    protected $table = 'receipts';
    protected $fillable = ['type', 'greg_date', 'hij_date', 'contract_id', 'client_id', 'farm', 'driver', 'reason', 'contact', 'notes', 'confirmation', 's_number', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public $view_link = 'receipt.edit';
    public $operations = [
        'add'=>'قام %s بإضافة سند جديد',
        'update'=>'قام %s بتحديث بيانات سند ',
        'delete'=>'قام %s بحذف بيانات سجل'
        
    ];

    public static function edit ($id, $props) {
        $d = self::find($id);
        foreach($props as $key => $prop) {
            $d->$key = $prop;
        }
        return $d;
    }

    public function contract () {
        return $this->belongsTo(Contract::class, 'contract_id', 'id');
    }
    public function client () {
        return $this->belongsTo(Client::class, 'client_id', 'id');
    }
}
