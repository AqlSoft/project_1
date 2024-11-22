<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Area extends Model
{
    use HasFactory;

    protected $table = 'Areas';
    protected $fillable = ['name', 'size', 'capacity', 'serial', 'repo', 'company', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'];
}