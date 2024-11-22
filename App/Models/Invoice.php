<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $table = 'invoices';
    protected $fillable = [
        'serial_number', 
        'client_id', 
        'contract_id', 
        'period_id', 
        'account_id', 
        'claiming_at', 
        'payment_status', 
        'type', 
        'created_at', 
        'created_by', 
        'Updated_at', 
        'updated_by'
    ];
}
