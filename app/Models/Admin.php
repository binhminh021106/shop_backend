<?php

namespace App\Models;

use App\Models\Role;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Admin extends Model
{
    /** @use HasFactory<\Database\Factories\AdminFactory> */
    use HasFactory;
    use SoftDeletes;

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

    /**
     * Tự động ép kiểu 
     */
    protected $casts = [
        'role_id' => 'integer',
        'phone' => 'integer',
    ];

    /**
     * Quan hệ với Role
     */
    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }
}
