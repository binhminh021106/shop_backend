<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Review extends Model
{
    /** @use HasFactory<\Database\Factories\ReviewFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'reviews';
    
    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'content',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'rating' => 'integer'
    ];

    /**
     * Quan hệ với Product
     */
    public function product() 
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }

    /**
     * Quan hệ với User
     */
    public function User() 
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
