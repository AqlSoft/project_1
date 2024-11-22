<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'permissions';

    protected $fillable = ['name', 'display_name_ar', 'display_name_en', 'menu_id', 'brief', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'];

    public function menu()
    {
        return  $this->belongsTo(Menu::class, 'menu_id');
    }
}
