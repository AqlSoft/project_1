<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminRolePermission extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'admins_roles_permissions';

    protected $fillable = ['role_id', 'permission_id', 'updated_by', 'created_by'];

    public static function edit () {

    }
}
