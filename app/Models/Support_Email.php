<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;

class Support_Email extends Model
{
    /** @use HasFactory<\Database\Factories\Support_EmailFactory> */
    use HasFactory;
    use SoftDeletes;

    protected $table = 'support_emails';

    protected $fillable = [
        'sender_name',
        'sender_email',
        'to_email',
        'sender_avatar',
        'subject',
        'content',
        'preview',
        'status',
        'is_read',
        'has_attachment',
        'attachment_path',
    ];
}
