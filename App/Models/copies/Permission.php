<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
    use HasFactory;

    protected $table = 'permissions';

    public $selected;

    protected $fillable = ['name', 'display_name_ar', 'display_name_en', 'url', 'type', 'status', 'menu_id', 'created_at', 'created_by', 'updated_at', 'updated_by'];

    public function edit ($req) {
            $this->name              = $req->name;
            $this->menu_id           = $req->menu_id;
            $this->url               = $req->url;
            $this->display_name_ar   = $req->display_name_ar;
            $this->display_name_en   = $req->display_name_en;
            $this->status            = $req->status;
            $this->type              = $req->type;
            $this->updated_by        = auth()->user()->id;
            $this->updated_at        = date('Y-m-d H:i:s');
    }
}
