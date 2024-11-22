<?php

namespace App\Models;

use App\Models\MeasuringUnit;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InvoiceItem extends Model
{
    use HasFactory;

    public $timestamps = true;
    protected $table = 'invoice_items';
    protected $fillable = [
        // Basic Properties
        'invoice_id',
        'item_id',
        'item_price',
        'item_qty',
        'unit_id',
        'item_discount',


        // Fixed Properties
        'created_at',
        'updated_at',
        'created_by',
        'updated_by'
    ];

    // Temp Properties
    public $serial_numbers;
    public $cost;
    public $price;
    public $stock;


    public function unit () {
        return MeasuringUnit::find($this->unit_id);
    }
}
