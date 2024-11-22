<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StoreItemCategory extends Model
{
    use HasFactory;

    public $timestamps = true;

    protected $table = 'store_items_categories';
    protected $fillable = ['name', 'parent_id', 'brief', 'image', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public function children () {
        return $this->hasMany(StoreItemCategory::class, 'parent_id', 'id');
    }

    public function parent() {
        return $this->belongsTo(StoreItemCategory::class, 'parent_id');
    }

    public static function parents() {
        return self::where('parent_id', '!=', null);
    }
}
