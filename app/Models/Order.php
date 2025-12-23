<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    /** @use HasFactory<\Database\Factories\OrderFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'orders';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'customer_email',
        'shipping_address',
        'status',
        'subtotal_amount', // Tổng phụ
        'shipping_fee',
        'discount_amount', // Tổng giảm giá 
        'total_amount', // Tổng tiền
        'payment_method', // Phương thức thanh toán
        'payment_status',
        'coupon_id',
    ];

    protected $casts = [
        'user_id' => 'integer',
        'subtotal_amount' => 'integer',
        'shipping_fee' => 'integer',
        'discount_amount' => 'integer',
        'total_amount' => 'integer',
        'coupon_id' => 'integer'
    ];

    /**
     * Quan hệ với User
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Quan hệ với Coupon
     */
    public function Coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }
}
