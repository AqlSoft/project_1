<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'stores';
    protected $fillable = [
        'name',
        'address',
        'brief',
        'code',
        'store_id',
        'phone',
        'email',
        'admin',
        'branch_id',
        'status',
        'created_by',
        'created_at',
        'updated_by',
        'updated_at'
    ];
}
