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

    public function suggestions()
    {
        return $this->hasMany(StudentSuggesstion::class);
    }
    public function totalLessonsCount()
    {
        return Lesson::whereIn('course_path_id', $this->coursePaths->pluck('id'))
            ->count();
    }
}