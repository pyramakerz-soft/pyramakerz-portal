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
use Illuminate\Support\Str;

class PortalController extends Controller
{
    use backendTraits;
    use HelpersTrait;

    public function homePage()
    {
        $languages = Language::all();
        $courses = Course::with(['coursePaths', 'coursePaths.lessons'])->paginate(10);

        return view('student.home', compact('languages', 'courses'));
    }
    public function registerStudent(Request $request)
    {
        // Validate the registration data
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required',
            'password' => 'required|min:6',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'school' => 'nullable|string|max:255',
            'gender' => 'required|in:male,female,other',
            'bday' => 'required|date',
            'photo' => 'nullable|image|max:2048',
        ]);

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
        $student->code = $this->generateStudentCode();
        $student->save();

        // Redirect to survey page
        return redirect()->route('show_survey', parameters: ['id' => $student->id]);
    }
    private function generateStudentCode()
    {
        do {
            $code = 'STU-' . strtoupper(Str::random(6));
        } while (Student::where('code', $code)->exists());

        return $code;
    }
}
