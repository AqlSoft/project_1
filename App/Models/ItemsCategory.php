<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemsCategory extends Model
{
    use HasFactory;

    protected $table = 'items_cats';
    protected $fillable = ['a_name', 'e_name', 'parent_cat', 'code', 'status', 'brief', 'company', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
