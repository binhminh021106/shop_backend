<?php

namespace App\Models;

use App\Models\Cart;
use App\Models\Variant;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Cart_Item extends Model
{
    /** @use HasFactory<\Database\Factories\Cart_ItemFactory> */
    use HasFactory;

    protected $table = 'cart_items';
    
    protected $fillable = [
        'cart_id',
        'variant_id',
        'quantity',
    ];

    protected $casts = [
        'cart_id' => 'integer',
        'variant_id' => 'integer',
        'quantity' => 'integer'
    ];

    /**
     * Quan hệ với Cart
     */
    public function Cart()
    {
        return $this->belongsTo(Cart::class, 'cart_id', 'id');
    }

    /**
     * Quan hệ với Variant 
     */
    public function Variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }
}
