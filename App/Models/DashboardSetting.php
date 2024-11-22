<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class DashboardSetting extends Model
{
    use HasFactory;
    protected $table = 'dashboard_settings';
    protected $fillable = ['name', 'icon', 'code', 'status', 'general_alert', 'address', 'phone', 'created_by', 'updated_by', 'created_at', 'updated_at'];
}
