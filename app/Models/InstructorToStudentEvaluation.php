<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InstructorToStudentEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'student_id',
        'course_id',
        'course_path_id',
        'path_of_path_id',
        'joined_at',
        'evaluation_period_start',
        'evaluation_period_end',
        'evaluation_details',
        'total_score',
        'evaluation_score',
        'group_schedule_id'
    ];

    protected $casts = [
        'evaluation_details' => 'array', // Automatically cast JSON to an array
    ];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
