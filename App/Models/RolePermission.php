<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RolePermission extends Model
{
    use HasFactory;

    protected $table = 'permission_role';
    public $timestamps = true;

    protected $fillable = ['role_id', 'permission_id', 'created_by', 'updated_by'];
}
