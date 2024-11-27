<?php

namespace App\Models;

use App\Models\AdminProfile;
use App\Models\AdminRole;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    protected $table = 'admins';
    protected $permissions;
    public $assignedRoles = [];

    protected $fillable = ['userName', 'email', 'password', 'rule', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public function assignRole($role_id)
    {
        // try {
        //     AdminRole::create([
        //         'admin_id' => $this->id,
        //         'role_id' => $role_id
        //     ]);
        //     return true;
        // } catch (QueryException $err) {
        //     $err;
        //     return false;
        // }
    }
    public function profile()
    {
        return  $this->hasOne(AdminProfile::class, 'user_id', 'id');
    }

    public function roles()
    {
        // return $this->belongsToMany(Role::class);
    }

    public function getRoles()
    {
        // $ars = AdminRole::where(['admin_id' => $this->id])->get();

        // foreach ($ars as $index => $ar) {
        //     $this->assignedRoles[] = Role::where(['id' => $ar->role_id])->with('permissions')->first();
        // }
    }

    public function fullName()
    {
        return  $this->profile->first_name . ' ' . $this->profile->last_name . ' [ ' . $this->userName . ' ]';
    }

    public function hasRole($role)
    {
        return $this->roles->contains('id', $role);
    }

    public function hasPermission($p): bool
    {

        foreach ($this->roles as $role) {
            if ($role->permissions->contains('name', $p)) {
                return true;
            }
        }
        return false;
    }
}
