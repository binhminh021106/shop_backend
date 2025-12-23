<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Variant_Attribute_Value extends Model
{
    /** @use HasFactory<\Database\Factories\Variant_Attribute_ValueFactory> */
    use HasFactory;

    protected $table = 'variant_attribute_values';

    protected $fillable = [
        'variant_id',
        'attribute_value_id'
    ];

    /**
     * Tự động ép kiểu 
     */
    protected $casts = [
        'variant_id' => 'integer',
        'attribute_value_id' => 'integer'
    ];

    /**
     * Quan hệ với Variant 
     */
    public function variant()
    {
        return $this->belongsTo(Variant::class, 'variant_id', 'id');
    }

    /**
     * Quan hệ với Attribute Value
     */
    public function Attribute_value()
    {
        return $this->belongsTo(Attribute_Value::class, 'attribute_value_id', 'id');
    }
    

}
