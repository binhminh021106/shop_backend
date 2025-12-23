<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User;

class Comment extends Model
{
    /** @use HasFactory<\Database\Factories\CommentFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'comments';

    protected $fillable = [
        'product_id',
        'user_id',
        'content',
        'parent_id',
        'status',
    ];

    protected $casts = [
        'product_id' => 'integer',
        'user_id' => 'integer',
        'parent_id' => 'integer',
    ];

    /**
     * Quan hệ với Product
     */
    public function Product()
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

    /**
     * Quan hệ với thằng cha 
     */
    public function Parent()
    {
        return $this->belongsTo(Comment::class, 'parent_id');
    }

    /**
     * Quan hệ với thằng con
     */
    public function children()
    {
        return $this->hasMany(Comment::class, 'parent_id');
    }
}
