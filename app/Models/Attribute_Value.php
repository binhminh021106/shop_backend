<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Attribute_Value extends Model
{
    /** @use HasFactory<\Database\Factories\Attribute_ValueFactory> */
    use HasFactory;

    protected $table = 'attribute_values';

    protected $fillable = [
        'value',
        'attribute_id'
    ];

    protected $casts = [
        'attribute' => 'integer'
    ];

    public function Attribute()
    {
        return $this->belongsTo(Attribute::class, 'attribute_id', 'id');
    }
}
