<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserProfile extends Model
{
    public $timestamps = true;
    use HasFactory;
    protected $table = 'users_profiles';
    protected $fillable = [
        'firstName', 'lastName', 'title', 'gender', 'dob', 'natId', 'profileImage', 'userId', 'type', 'created_by', 'updated_by', 'phone', 'profession'
    ];

    public static function initiateNewProfile($req) {
        $p = new self();
        $p->firstName       = $req->firstName;
        $p->lastName        = $req->lastName;
        $p->natId           = $req->natId;
        $p->type            = $req->type;
        $p->dob             = $req->dob;
        $p->profession      = $req->profession;

        $p->title = $req->title != null ?  $req->title : '';
        $p->gender = $req->gender != null ?  $req->gender : '';
        $p->phone = $req->phone != null ?  $req->phone : '';
        return $p;
    }
    public function editProfile($req) {
        
        $this->firstName    = $req->firstName;
        $this->lastName     = $req->lastName;
        $this->natId        = $req->natId;
        $this->type         = $req->type;
        $this->dob          = $req->dob;
        $this->profession   = $req->profession;

        $this->title    = $req->title   != null ?   $req->title     : '';
        $this->gender   = $req->gender  != null ?   $req->gender    : '';
        $this->phone    = $req->phone   != null ?   $req->phone     : '';
    }
}
