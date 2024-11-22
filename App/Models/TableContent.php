<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TableContent extends Model
{
    use HasFactory;

    protected $table = 'table_contents';
    protected $fillable = ['table_id', 'store_item_id', 'box_size_id', 'qty', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    
}
