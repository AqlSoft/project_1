<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'contracts_parts';
    protected $fillable = ['number', 'content', 'order', 'contract_id',  'created_by', 'updated_by', 'created_at', 'updated_at', 'status'];
}
