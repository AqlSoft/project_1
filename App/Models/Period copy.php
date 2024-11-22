<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Period extends Model
{
    use HasFactory;
    protected $table = 'periods';

    public $timestamps = true;

    protected $fillable = [
        // Basic Properties
        'starts_in',
        'ends_in',
        'length',
        'contract_id',
        'client_id',
        'the_code',
        'status',
        'the_order',
        'created_at',                   
        'created_by',                   

        // Null Properties
        
        'updated_at',                   
        'updated_by',                   
    ];

    public function items () {
        return $this->hasMany(ContractItem::class, 'period_id', 'id');
    }

}
