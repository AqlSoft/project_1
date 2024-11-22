<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccountsCategory extends Model
{
    use HasFactory;
    protected $table = 'accounts_categories';
    protected $fillable = ['a_name', 'e_name', 'brief', 'company', 'created_by', 'updated_by', 'created_at', 'updated_at'];

}
