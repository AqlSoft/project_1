<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use App\Models\UserRole;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */

    public $permissions = [];
    public $roles;

    protected $fillable = [
        'userName', 'email', 'password', 'company', 'created_at', 'updated_at'
    ];

    public function edit ($req) {
        $this->userName = $req->userName;
        $this->email = $req->email;
        $this->password = $req->password == null ? $this->password : bcrypt($req->password);
        return $this;
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

   // "$2y$10$ytRz7P/Tw4w.vIGy625kTuCFQFkZmwslxfEVxPf4o4YsEHXp8VIwG"
   // "$2y$10$nVqmHD5Xbakc71gFFkpLneLs9MoAgYFHMe4.WA0libQD3UFWD0.F."
    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function hasRole($role_id) {
        return UserRole::where(['user_id'=>$this->id, 'role_id'=>$role_id])->first() == null ? false : true;
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
