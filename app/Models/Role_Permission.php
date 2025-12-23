<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Role_Permission extends Model
{
    /** @use HasFactory<\Database\Factories\Role_PermissionFactory> */
    use HasFactory;

    protected $table = 'role_permissions';

    protected $fillable = [
        'role_id',
        'permission_id'
    ];

    /**
     * Tự động ép kiểu 
     */
    protected $casts = [
        'role_id' => 'integer',
        'permission_id' => 'integer',
    ];

    /** 
     * Quan hệ với Role
     */
    public function Role()
    {
        return $this->belongsTo(Role::class, 'role_id', 'id');
    }

    /**
     * Quan hệ với Permission
     */
    public function Permission()
    {
        return $this->belongsTo(Permission::class, 'permission_id', 'id');
    }
}
