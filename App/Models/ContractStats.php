<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Contact extends Authenticatable
{
    use HasFactory;

    public $smallTablesBooked = 0;
    public $largeTablesBooked = 0;
    public $smallTablesUsed = 0;
    public $largeTablesUsed = 0;

    public static function contactsArray() {
        $cs = self::all();
        $ca = [];
        foreach ($cs as $i => $c) {
            $ca[$c->id] = $c->name;
        }
        return $ca;
    }
}
