<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\Language;
use App\Models\Student;
use App\Models\StudentResponseTo;
use App\Models\StudentSuggesstion;
use Illuminate\Http\Request;
use App\Traits\backendTraits;
use App\Traits\HelpersTrait;
class PortalController extends Controller
{
    use backendTraits;
    use HelpersTrait;

    public function homePage()
    {
        $languages = Language::all();

        return view('home', compact('languages'));
    }
    public function registerStudent(Request $request)
    {
        // Create a new student
        $student = new Student();
        $student->name = $request->name;
        $student->email = $request->email;
        $student->phone = $request->phone;
        $student->password = bcrypt($request->password);
        $student->country = $request->country;
        $student->city = $request->city;
        $student->school = $request->school;
        $student->gender = $request->gender;
        $student->bday = $request->bday;
        $student->photo = $this->upploadImage($request->photo, 'student_photos');
        $student->save();

        // Handle the survey response
        if ($request->has('prog')) {
            $surveyResponse = true;

            // Save the survey response in student_responses
            $response = new StudentResponseTo();
            $response->student_id = $student->id;
            $response->respondable_type = 'App\Models\Survey';
            $response->respondable_id = 1;
            $response->response = $surveyResponse;
            $response->comment = $request->survey_comment ?? null;
            $response->responded_at = now();
            $response->save();

            // If the survey response is "Yes" (true), handle program suggestions
            if ($surveyResponse && $request->has('prog')) {
                foreach ($request->prog as $prog) {
                    // Add suggestions for selected programs
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
        }
        dd($surveyResponse, $request->all());
    }

}