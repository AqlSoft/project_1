<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    use HasFactory;

    public $permissions;
    public $timestamps = true;
    
    protected $table = 'menues';

    protected $fillable = ['label', 'display_name_ar', 'display_name_en',  'url_name', 'parent', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'];

    public function getRelatedPermissions () {
        $this->permissions =  Permission::where(['menu_id'=>$this->id])->get();
    }

    public function edit ($req) {
        $this->label             =  $req->label;
        $this->url_name          =  $req->url_name;
        $this->display_name_ar   =  $req->display_name_ar;
        $this->display_name_en   =  $req->display_name_en;
        $this->parent            =  $req->parent;
        $this->status            =  $req->status;
        $this->updated_by        =  auth()-> user() -> id;
    }
}
