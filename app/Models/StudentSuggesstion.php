<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class StudentSuggesstion extends Model
{

    protected $table = 'student_suggestions';
    protected $guarded = [];
    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
    public function progress()
    {
        return $this->hasMany(StudentProgress::class, 'course_path_id', 'id');
    }

}