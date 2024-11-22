<?php

namespace App\Models;

use App\Models\Contract;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Log extends Model
{
    use HasFactory;

    protected $table = 'log';
    protected $fillable = ['action', 'subject', 'link', 'item_id','created_by', 'created_at'];
   
    public static function addRecord($action, $item){
        $registry = new self();
            $registry-> action          = $item->operations[$action];
            $registry-> item_id         = $item->id;
            $registry-> link            = $item->view_link;
            $registry-> created_by      = $item->created_by;
            $registry-> created_at      = $item->created_at;
            $registry->save();
    }
}
