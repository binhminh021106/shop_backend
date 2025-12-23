<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Model
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'users';

    protected $fillable = [
        'fullName',
        'email',
        'phone',
        'password',
        'avatar_url',
        'status',
        'remember_token',
        'email_verified_at',
        'birthday',
        'sex',
        'google_id',
        'facebook_id'
    ];
}
