<?php

namespace App\Models;



use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Possitions extends Model
{
    use HasFactory;

    protected $table = 'possitions';

    protected $fillable = ['job_title', 'department', 'is_active'];
}
