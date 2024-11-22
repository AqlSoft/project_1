<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AppSetting extends Model
{
    use HasFactory;
    protected $table = 'app_settings';

    protected $fillable = [
        // Basic Properties
        
        
        'model_name',
        'value',
        'status',

        'created_at',                   
        'created_by',                   

        // Null Properties
        
        'updated_at',                   
        'updated_by',                   
    ];




}
