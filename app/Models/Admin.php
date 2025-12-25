<?php

namespace App\Models;

use App\Models\Role;
use Laravel\Sanctum\HasApiTokens;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasApiTokens, HasFactory, Notifiable, SoftDeletes;

    protected $table = 'admins';

    protected $fillable = [
        'fullname',
        'email',
        'password',
        'role_id',
        'phone',
        'avatar_url',
        'status',
        'email_verified_at',
        'address'
    ];

    protected $hidden = [
        'password'
    ];

    /**
     * Tự động ép kiểu 
     */
    protected $casts = [
        'role_id' => 'integer',
        'email_verified_at' => 'datetime'
    ];

    /**
     * Quan hệ với Role
     */
    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
