<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LessonResource extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id',
        'group_id',
        'group_schedule_id',
        'uploader_id',
        'title',
        'description',
        'file_path',
        'resource_type',
    ];

    /**
     * Get the lesson associated with this resource.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * (Optional) Get the group associated with this resource.
     */
    public function group()
    {
        return $this->belongsTo(Group::class);
    }

    /**
     * (Optional) Get the group schedule (session) associated with this resource.
     */
    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class);
    }

    /**
     * Get the user (instructor or supervisor) who uploaded this resource.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploader_id');
    }
}