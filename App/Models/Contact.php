<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contact extends Authenticatable
{
    use HasFactory;

    protected $table = 'contacts';
    
    protected $fillable = ['name', 'email', 'phone', 'rule', 'status', 'iqama', 'rate', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public static function contactsArray() {
        $cs = self::all();
        $ca = [];
        foreach ($cs as $i => $c) {
            $ca[$c->id] = $c->name;
        }
        return $ca;
    }
}
