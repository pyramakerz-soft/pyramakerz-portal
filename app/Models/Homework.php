<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Homework extends Model
{
    use HasFactory;

    protected $fillable = [
        'student_id',
        'lesson_id',
        'group_schedule_id',
        'file_path',
        'grade',
        'instructor_id',
        'feedback',
    ];

    /**
     * Get the student who submitted this homework.
     */
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * Get the lesson this homework is associated with.
     */
    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    /**
     * (Optional) Get the group schedule (session) this homework is tied to.
     */
    public function groupSchedule()
    {
        return $this->belongsTo(GroupSchedule::class);
    }
}
