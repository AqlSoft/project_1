<?php

namespace App\Models;

use App\Http\Middleware\Authenticate;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AccountsInfo extends Authenticatable
{
    use HasFactory;
    protected $table = 'accounts_info';
    protected $fillable = ['company', 'address', 'country', 'cr', 'vat', 'email', 'website', 'phone', 'created_at', 'updated_at', 'created_by', 'updated_by'];
}
