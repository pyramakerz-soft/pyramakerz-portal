<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseProgress extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'instructor_id', 'branch', 'age_group', 'start_time', 'end_time',
        'status', 'total_sessions', 'completed_sessions', 'delayed_sessions', 'canceled_sessions',
        'progress', 'materials'
    ];

    protected $casts = [
        'progress' => 'array',
        'materials' => 'array'
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function instructor()
    {
        return $this->belongsTo(User::class);
    }
}
