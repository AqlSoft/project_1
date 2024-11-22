<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MoneyPassRule extends Model
{
    use HasFactory;
    protected $table = 'money_pass_rules';
    protected $fillable = ['treasury_id', 'push_to', 'pull_from', 'created_by', 'updated_by', 'created_at', 'updated_at', 'company'];
}
