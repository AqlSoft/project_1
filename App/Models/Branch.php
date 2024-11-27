<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    use HasFactory;
    public $timestamps = true;

    protected $table = 'branches';
    protected $fillable = [
        'name',
        'address',
        'phone',
        'email',
        'ismain',
        'branch_code',
        'created_by',
        'updated_by'
    ];
}
