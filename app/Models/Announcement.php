<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Announcement extends Model
{
    use SoftDeletes;

    protected $table = 'announcements';

    protected $fillable = [
        'title',
        'content',
    ];

    public function seen_announcements()
    {
        return $this->hasMany('App\Models\UserAnnouncement', 'announcement_id');
    }

    public function getAnnouncementDuration()
    {
        $secondsAgo = $this->created_at->diffInSeconds(now());
        $minutesAgo = $this->created_at->diffInMinutes(now());
        $hoursAgo = $this->created_at->diffInHours(now());
        $daysAgo = $this->created_at->diffInDays(now());
        $duration = $secondsAgo . " seconds ago";
        if($hoursAgo > 24) {
            $duration = $daysAgo . " days ago";
        }elseif($minutesAgo > 60) {
            $duration = $hoursAgo . " hours ago";
        }elseif($secondsAgo > 60) {
            $duration = $minutesAgo . " minutes ago";
        }
        return $duration;
    }
}
