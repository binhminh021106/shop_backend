<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Image_Product extends Model
{
    /** @use HasFactory<\Database\Factories\Image_ProductFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'image_product';

    protected $fillable = [
        'product_id',
        'image_product'
    ];

    protected $casts = [
        'product_id' => 'integer',
    ];

    /**
     * Quan hệ với Product
     */
    public function Product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
