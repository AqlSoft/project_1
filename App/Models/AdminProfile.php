<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminProfile extends Model
{
    use HasFactory;
    protected $table = 'admins_profiles';
    protected $fillable = [
        'first_name',
        'last_name',
        'possition',
        'gender',
        'dob',
        'natId',
        'image',
        'user_id',
        'updated_at',
        'phone',
        'address'
    ];

    public static function newProfile($req)
    {
        $p = new self();
        $p->first_name  = $req->first_name;
        $p->last_name   = $req->last_name;
        $p->possition  = $req->possition;
        return $p;
    }
}
