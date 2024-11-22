<?php

namespace App\Models;

use App\Models\AdminRolePermission;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
    
    public $permissions = [];
    public $roles;
    protected $fillable = ['userName', 'email', 'password', 'role', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public function hasRole($role_id) {
        $roles = $this->roles;
        foreach ($roles as $role) {
            if ($role->role_id == $role_id) {
                return true;
            }
        }
        return false;
    }

    public function getRoles () {
        return  $this->roles = AdminRole::where(['user_id'=>$this->id])->get();
    }

    public function getPermissions () {
        $roles = $this->getRoles();
        
        foreach ( $roles as $ar) {
            $this->permissions[] =AdminRolePermission::select('permission_id')->where(['role_id'=>$ar->role_id])->get();
        }
    }
}
