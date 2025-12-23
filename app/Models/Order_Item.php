<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Order_Item extends Model
{
    /** @use HasFactory<\Database\Factories\Order_ItemFactory> */
    use HasFactory;

    protected $table = 'order_items';

    protected $fillable = [
        'order_id',
        'variant_id',
        'quantity',
        'price',
    ];

    protected $casts = [
        'order_id' => 'integer',
        'variant_id' => 'integer',
        'quantity' => 'integer',
        'price' => 'integer'
    ];

    /**
     * Quan hệ với Order
     */
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }

    /**
     * Quan hệ với Variant
     */
    public function Variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
}
