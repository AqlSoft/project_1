<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    public static $branches = [1=>'القصيم - البصر - طريق الملك فهد'];

    use HasFactory;


    static $types = ['Raw_Material','Seme_Products', 'Complete_Production'];
    protected $table = 'stores';
    protected $fillable = ['a_name', 'e_name', 'brief', 'type', 'phone', 'code', 'Admin', 'display_in_list', '', 'address', 'company', 'created_by', 'updated_by', 'created_at', 'updated_at', 'status'];
}
