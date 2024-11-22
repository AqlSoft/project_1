<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    public $menues = [];
    public $assigned_permissions = [];
    public $timestamps=true;
    protected $table = 'roles';

    protected $fillable = ['name', 'brief', 'display_name_ar', 'display_name_en', 'team_id', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'];

    public function admins()
    {
        return $this->belongsToMany(Admin::class);
    }

    public function permissions()
    {
        return $this->belongsToMany(Permission::class);
    }

    public function addPermission($p)
    {
        $this->assigned_permissions[] = $p;
    }

    public function getPermissions()
    {
        $rps = RolePermission::where(['role_id' => $this->id])->get();
        foreach ($rps as $rp) {
            $p = Permission::find($rp->permission_id);
            $this->addPermission($p);
        }
        return $rp;
    }

    public function hasPermission($id)
    {
        return RolePermission::where(['permission_id' => $id, 'role_id' => $this->id])->first() != null;
    }
}
