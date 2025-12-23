<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon_Usage extends Model
{
    /** @use HasFactory<\Database\Factories\Coupon_UsageFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'coupon_usage';

    protected $fillable = [
        'coupon_id',
        'user_id',
        'order_id',
    ];

    protected $casts = [
        'coupon_id' => 'integer',
        'user_id' => 'integer',
        'order_id' => 'integer'
    ];

    /**
     * Quan hệ với Coupon
     */
    public function Coupon()
    {
        return $this->belongsTo(Coupon::class, 'coupon_id', 'id');
    }

    /**
     * Quan hệ với User
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }

    /**
     * Quan hệ với Order
     */
    public function Order()
    {
        return $this->belongsTo(Order::class, 'order_id', 'id');
    }
}
