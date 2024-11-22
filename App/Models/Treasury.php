<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Treasury extends Model
{
    use HasFactory;

    protected $table = 'treasuries';
    
    protected $fillable = ['name', 'parent', 'type', 'last_money_in', 'last_money_out', 'status', 'created_by', 'updated_by', 'created_at', 'updated_at', 'company', 'cashier'];
    
    public $children = [];

    public static function buildTree () {
        $master = static::where(['type'=> 1])->get()->first();
        
        $allChildren = static::where(['parent'=> $master->id])->get(); $children = [];
        foreach($allChildren as $i => $child){
            $master->children[$child->id] = $child->name;
        }

        foreach($master->children as $index => $masterChild){
            $master->children[$index][] = $child->name;
        }
        //$master->children = $children;
        
        return $master->children;
    }

    public static function getChildren($id) {
        $allChildren = static::where(['parent'=>$id])->get();
        $children = [];
        if (!empty($allChildren)) {
            foreach($allChildren as $i => $child){
                $children[$child->id] = $child;
            }
        }
        return $children;
    }
}