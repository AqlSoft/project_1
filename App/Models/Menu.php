<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $timestamps=true;

    protected $table = 'menues';
    protected $fillable = ['label', 'brief', 'display_name_ar', 'display_name_en', 'parent', 'status', 'icon', 'url_name', 'created_by', 'updated_by', 'created_at', 'updated_at'];

    public static function roots()
    {
        return self::where(['parent' => 0 ])->where('status','!=',0);
    }

    public function subMenues()
    {
        return $this->hasMany(Menu::class, 'parent');
    }

    public static function nonRoots () {
        return self::where('parent', '>', 0)->get();
    }

    public function parent_menu()
    {
        return $this->belongsTo(Menu::class, 'parent');
    }
}
