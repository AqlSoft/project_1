<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContractPaymentScheduleEntry extends Model
{
    use HasFactory;
    protected $table = 'contract_payment_schedule_entries';
    protected $fillable = [
        'type', 'ratio', 'amount', 'label', 'due_date', 'due_event', 'contract_id',
        'company', 'created_by', 'updated_by', 
        'created_at', 'updated_at'
    ];
}
