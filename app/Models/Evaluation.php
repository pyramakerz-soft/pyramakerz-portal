<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Evaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'instructor_id',
        'sessions_per_week',
        'students_count',
        'attended',
        'absent',
        'percentage',
        'evaluation',
        'comment',
    ];

    public function instructor()
    {
        return $this->belongsTo(User::class, 'instructor_id');
    }

    public function calculatePercentage()
    {
        return $this->students_count > 0 ? ($this->attended / $this->students_count) * 100 : 0;
    }
}
