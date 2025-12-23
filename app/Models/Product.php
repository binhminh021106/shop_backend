<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    /** @use HasFactory<\Database\Factories\ProductFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'products';

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'thumbnail_url',
        'sold_count',
        'favorite_count',
        'review_count',
        'average_rating',
        'description',
        'status'
    ];

    /**
     * Tự động ép kiểu 
     */
    protected $casts = [
        'sold_count' => 'integer',
        'favorite_count' => 'integer',
        'review_count' => 'integer',
        'average_rating' => 'decimal:2',
        'category_id' => 'integer',
        'brand_id' => 'integer',
    ];

    /**
     * Quan hệ với Brand
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id', 'id');
    }

    /**
     * Quan hệ với Category
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id', 'id');
    }
}
