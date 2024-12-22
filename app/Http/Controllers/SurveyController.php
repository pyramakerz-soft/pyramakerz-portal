<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Language;
use App\Models\Student;
use App\Models\StudentResponseTo;
use App\Models\StudentSuggesstion;
use Illuminate\Http\Request;

class SurveyController extends Controller
{
    public function showSurvey($id)
{
    $student = Student::findOrFail($id);
    $languages = Language::all();

    return view('survey', compact('student', 'languages'));
}
public function submitSurvey(Request $request, $id)
{
    // Validate survey data
    $validatedData = $request->validate([
        'prog' => 'nullable|array',
        'prog.*' => 'exists:courses,id',
        'survey_comment' => 'nullable|string|max:500',
    ]);

    $student = Student::findOrFail($id);

    // Save survey response
    $response = new StudentResponseTo();
    $response->student_id = $student->id;
    $response->respondable_type = 'App\Models\Survey';
    $response->respondable_id = 1; // Adjust as needed
    $response->response = !empty($validatedData['prog']);
    $response->comment = $validatedData['survey_comment'] ?? null;
    $response->responded_at = now();
    $response->save();

    // Handle suggested courses
    if (!empty($validatedData['prog'])) {
        foreach ($validatedData['prog'] as $prog) {
            $suggestedCourse = Course::find($prog);
            if ($suggestedCourse) {
                $suggestion = new StudentSuggesstion();
                $suggestion->student_id = $student->id;
                $suggestion->course_id = $suggestedCourse->id;
                $suggestion->criteria = "Suggested based on survey response";
                $suggestion->accepted = false;
                $suggestion->save();
            }
        }
    }

    return redirect()->route('student.courses');
}

}
