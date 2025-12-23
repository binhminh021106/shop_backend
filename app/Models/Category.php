<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
     /** @use HasFactory<\Database\Factories\CategoryFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'categories';

    protected $fillable = [
        'name',
        'description',
        'order_number',
        'status',
        'icon',
        'parent_id',
    ];

    /**
     * Quan hệ với thằng con
     */
    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    /**
     * Quan hệ với thằng cha
     */
    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

}
