<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MeasuringUnit extends Model
{
    use HasFactory;

    protected $table = 'measuring_units';
    protected $fillable = ['a_name', 'e_name', 'is_master ', 'company', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
