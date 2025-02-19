<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Evaluation;
use App\Models\User;

class EvaluationSeeder extends Seeder
{
    public function run()
    {
        $instructors = User::where('role', 'teacher')->get();

        foreach ($instructors as $instructor) {
            Evaluation::create([
                'instructor_id' => $instructor->id,
                'sessions_per_week' => rand(5, 10),
                'students_count' => rand(20, 50),
                'attended' => rand(15, 50),
                'absent' => rand(0, 10),
                'percentage' => 0, // Will be calculated later
                'evaluation' => rand(80, 100),
                'comment' => 'Some sessions were paused or rescheduled.',
            ]);
        }

        // Update percentage after inserting
        foreach (Evaluation::all() as $evaluation) {
            $evaluation->update([
                'percentage' => $evaluation->calculatePercentage(),
            ]);
        }
    }
}
