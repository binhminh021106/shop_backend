<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category_New extends Model
{
    /** @use HasFactory<\Database\Factories\Category_NewFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'category_news';

    protected $fillable = [
        'name'
    ];
}
