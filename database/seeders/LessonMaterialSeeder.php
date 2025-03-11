<?php

namespace Database\Seeders;

use App\Models\Group;
use App\Models\Lesson;
use App\Models\LessonMaterial;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class LessonMaterialSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $lesson = Lesson::first(); // Assuming at least one lesson exists
        $instructor = User::where('role', 'teacher')->first(); // Get first instructor
        $group = Group::first(); // Get first group

        if ($lesson) {
            // General material available to all students
            LessonMaterial::create([
                'lesson_id' => $lesson->id,
                'title' => 'General Introductory Video',
                'type' => 'video',
                'url' => 'https://www.youtube.com/embed/vHdclsdkp28',
            ]);

            // Material uploaded by instructor for a specific group
            if ($instructor && $group) {
                LessonMaterial::create([
                    'lesson_id' => $lesson->id,
                    'instructor_id' => $instructor->id,
                    'group_id' => $group->id,
                    'title' => 'Group-Specific Quiz',
                    'type' => 'quiz',
                    'url' => '/quizzes/group1_lesson1',
                ]);

                LessonMaterial::create([
                    'lesson_id' => $lesson->id,
                    'instructor_id' => $instructor->id,
                    'group_id' => $group->id,
                    'title' => 'Group-Specific Assignment',
                    'type' => 'assignment',
                    'url' => '/storage/assignments/group1_lesson1.pdf',
                ]);
            }
        }
    }
}
