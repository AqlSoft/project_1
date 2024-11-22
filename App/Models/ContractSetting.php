<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractSetting extends Model
{
    use HasFactory;
    protected $table = 'contract_settings';

    // public $show_representative = true;
    protected $fillable = [
        // Basic Properties
        
        'show_representative',
        'contract_signature_representative',
        'status',

        'created_at',                   
        'created_by',                   

        // Null Properties
        
        'updated_at',                   
        'updated_by',                   
    ];

}
