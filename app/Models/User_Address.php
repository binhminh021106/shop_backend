<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User_Address extends Model
{
    /** @use HasFactory<\Database\Factories\User_AddressFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'user_addresses';

    protected $fillable = [
        'user_id',
        'customer_name',
        'customer_phone',
        'shipping_address',
        'city',
        'district',
        'ward',
        'is_default'
    ];

    protected $casts = [
        'user_id' => 'integer'
    ];

    /**
     * Quan hệ với User
     */
    public function User()
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
