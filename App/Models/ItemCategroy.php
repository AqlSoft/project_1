<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ItemCategroy extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'items_categories';
    protected $fillable = ['name', 'parent', 'brief', 'status', 'created_at', 'updated_at', 'created_by', 'updated_by'];

    public static function roots()
    {
        return self::where('parent', 1)->get();
    }

    public function parent()
    {
        return $this->belongsTo(ItemCategroy::class, 'parent');
    }
    public function children()
    {
        return $this->hasMany(ItemCategroy::class, 'parent');
    }
}
