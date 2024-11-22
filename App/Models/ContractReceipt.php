<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractReceipt extends Model
{
    use HasFactory;

    protected $table = 'contract_receipts';
    protected $fillable = [
        'serial', 'day_in_greg', 'day_in_hijri', 'client', 'shift',
        'contract', 'type', 'driver', 'iqama', 'notes', 'status', 
        'company', 'created_by', 'updated_by', 
        'created_at', 'updated_at'
    ];

}