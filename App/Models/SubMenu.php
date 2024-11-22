<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SubMenu extends Model
{
    use HasFactory;

    protected $table = 'sub_menues';

    protected $fillable = ['name', 'menu_link', 'main_menu', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'];
}
