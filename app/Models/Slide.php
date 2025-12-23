<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Slide extends Model
{
    /** @use HasFactory<\Database\Factories\SlideFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'slides';

    protected $fillable = [
        'title',
        'image_url',
        'link_url',
        'order_number',
        'status',
        'description'
    ];

    protected $casts = [
        'order_number' => 'integer'
    ];
}
