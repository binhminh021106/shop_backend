<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class News extends Model
{
    /** @use HasFactory<\Database\Factories\NewsFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'news';

    protected $fillable = [
        'title',
        'category',
        'excerpt', // Đoạn trích
        'content',
        'image_url',
        'slug',
        'status',
        'views',
        'author_name',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];
}
