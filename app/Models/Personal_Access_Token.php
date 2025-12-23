<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Personal_Access_Token extends Model
{
    /** @use HasFactory<\Database\Factories\Personal_Access_TokenFactory> */
    use HasFactory;

    protected $table = 'personal_access_tokens';

    protected $fillable = [
        'tokenable_type',
        'tokenable_id',
        'name',
        'token',
        'abilities',
        'last_used_at',
        'expires_at'
    ];

    /**
     * Tự động ép kiểu dữ liệu
     */
    protected $casts = [
        'abilities' => 'json',
        'last_used_at' => 'datetime',
        'expires_at' => 'datetime',
    ];

    /**
     * Quan hệ đa hình: Lấy model chủ sở hữu của token (User, Admin, v.v.)
     */
    public function tokenable()
    {
        return $this->morphTo();
    }
}
