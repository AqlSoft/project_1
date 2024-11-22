<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminRolePermission;

class AdminRole extends Model
{
    use HasFactory;

    public $permissions;

    protected $table = 'admins_roles';

    protected $fillable = ['user_id', 'role_id', 'created_at', 'created_by', 'updated_at'];

    public function getPermissions () {
        $this->permissions = AdminRolePermission::where(['role_id'=>$this->role_id])->get();
        
    }
}
