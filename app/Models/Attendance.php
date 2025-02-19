<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model {
    protected $fillable = ['user_id', 'student_id', 'course_id', 'day', 'time', 'status', 'course_path_id', 'path_of_path_id', 'sessions'];
    
    protected $casts = [
        'sessions' => 'array',
    ];

    public function instructor() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function student() {
        return $this->belongsTo(Student::class, 'student_id');
    }
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function course() {
        return $this->belongsTo(Course::class);
    }

    public function coursePath() {
        return $this->belongsTo(CoursesPath::class);
    }

    public function pathOfPath() {
        return $this->belongsTo(PathOfPath::class);
    }
}

