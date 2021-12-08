<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserAnnouncement extends Model
{
    use SoftDeletes;

    protected $table = 'user_announcements';

    protected $fillable = [
        'is_seen',
        'user_id',
        'announcement_id',
    ];
}
