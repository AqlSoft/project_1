<?php

namespace App\Models;

// use App\Models\ReceiptEntry;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Support extends Model
{
    use HasFactory;

    protected $table = 'support';
    protected $fillable = ['name', 'brief', 'type', 'serial', 'cat_id', 'file_name', 'file_path', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'];
}
