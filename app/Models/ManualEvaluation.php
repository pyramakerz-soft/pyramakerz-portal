<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ManualEvaluation extends Model
{
    use HasFactory;

    protected $fillable = [
        'trainer_id',
        'date',
        'program',
        'rank',
        'setup',
        'preparation',
        'objectives',
        'delivery_capacity',
        'controlling_session',
        'communication_students',
        'attendance_evaluation_sheets',
        'personal_impact',
        'training_techniques',
        'evaluation_percentage',
        'supervisor_id',
        'comments'
    ];

    // Relationship with Trainer
    public function trainer()
    {
        return $this->belongsTo(User::class, 'trainer_id'); // Assuming instructors are in the `users` table
    }

    // Relationship with Supervisor (Admin)
    public function supervisor()
    {
        return $this->belongsTo(User::class, 'supervisor_id'); // Assuming supervisors are also in the `users` table
    }
}
