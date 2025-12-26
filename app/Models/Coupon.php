<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Coupon extends Model
{
    /** @use HasFactory<\Database\Factories\CouponFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'coupons';

    protected $fillable = [
        'name',
        'code', // Mã giảm giá 
        'min_spend', // Chi tiêu tối thiểu
        'type', // Kiểu mã giảm giá (%,...)
        'value', // Giảm bao nhiêu
        'usage_limit', // Giới hạn sử dụng
        'usage_count', // Số lượt đã sử dụng
        'usage_limit_per_user', // Số lượng sử dụng cho từng user
        'expires_at', // Ngày hết hạn
    ];

    protected $casts = [
        'min_spend' => 'integer',
        'value' => 'integer',
        'usage_limit' => 'integer',
        'usage_count' => 'integer',
        'usage_limit_per_user' => 'integer',
    ];
}
