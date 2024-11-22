<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

use App\Models\AdminRolePermission;

class Role extends Model
{
    use HasFactory;

    protected $table = 'roles';
    protected $fillable = ['name', 'display_name_ar', 'display_name_en', 'brief', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'];
    
    
    public function getPermissions () {
        $this->permissions = AdminRolePermission::where(['role_id'=>$this->id])->get();
    }
    public function hasPermission ($permission_id) {

        foreach($this->permissions as $permission) {
            if ($permission->permission_id == $permission_id) {
                return true;
            }
        }
        return false;
    }
    public function getPermissionsArray () {
        $arr = [];
        foreach($this->permissions as $permission) {
                $arr[] = $permission->permission_id;
        }
        return $arr;
    }

}
