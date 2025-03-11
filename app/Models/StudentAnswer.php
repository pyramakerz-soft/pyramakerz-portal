<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StudentAnswer extends Model
{
    use HasFactory;

    protected $fillable = ['student_id', 'test_id', 'question_id', 'selected_choice'];

    public function student()
    {
        return $this->belongsTo(Student::class);
    }

    public function test()
    {
        return $this->belongsTo(Test::class);
    }

    public function question()
    {
        return $this->belongsTo(TestQuestion::class);
    }
}
