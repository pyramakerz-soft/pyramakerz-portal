<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    protected $guarded = [] ;
    public function coursePaths()
    {
        return $this->hasMany(CoursesPath::class);
    }
    public function groups()
    {
        return $this->hasMany(Group::class);
    }
    public function suggestions()
    {
        return $this->hasMany(StudentSuggesstion::class);
    }
    public function instructor()
    {
        return $this->belongsTo(User::class);
    }
    public function lessons()
    {
        return $this->belongsTo(Lesson::class);
    }
    public function totalLessonsCount()
    {
        return Lesson::whereIn('course_path_id', $this->coursePaths->pluck('id'))
            ->count();
    }
    public function attendanceRecords() {
        return $this->hasMany(Attendance::class);
    }
    
        
}