<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Section extends Authenticatable
{
    use HasFactory;

    protected $table = 'sections';
    
    protected $fillable = ['a_name', 'e_name', 'branch', 'area', 'status', 'capacity', 'keeper', 'code', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public static function contactsArray() {
        $cs = self::all();
        $ca = [];
        foreach ($cs as $i => $c) {
            $ca[$c->id] = $c->name;
        }
        return $ca;
    }
}
