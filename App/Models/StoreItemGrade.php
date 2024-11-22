<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItemGrade extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'store_items_grades';
    protected $fillable = ['name', 'short', 'created_by', 'updated_by', 'created_at', 'updated_at'];

}
