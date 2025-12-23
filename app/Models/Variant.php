<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Variant extends Model
{
    /** @use HasFactory<\Database\Factories\VariantFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'variants';

    protected $fillable = [
        'product_id',
        'price',
        'original_price', // giá gốc
        'stock',
        'image',
    ];

    protected $casts = [
        'price' => 'integer',
        'original_price' => 'integer',
        'stock' => 'integer',
        'product_id' => 'integer'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
