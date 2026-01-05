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
        'category_id',
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

    protected $casts = [
        'category_id' => 'integer'
    ];

    /**
     * Quan hệ với Category New
     */
    public function CategoryNew() {
        return $this->belongsTo(Category_New::class, 'category_id', 'id');
    }
}
