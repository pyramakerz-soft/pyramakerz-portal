<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Meeting extends Model
{
    use HasFactory;

    protected $fillable = [
        'zoom_meeting_id',
        'topic',
        'start_time',
        'duration',
        'join_url',
        'status',
        'lesson_id',
        'group_id',
        'group_schedule_id',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class);
    }
}
