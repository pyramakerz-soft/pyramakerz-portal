<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentEnrollment;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{

    public function profile()
    {
        $student = Auth::guard('student')->user();
        return view('student.profile', compact('student'));
    }
    public function myQuiz(){
        $student = Auth::guard('student')->user();
        return view('student.my-quizz', compact('student'));
    }
    public function getCourses(Request $request, Course $course){
        $student = Auth::guard('student')->user();
        $courses = StudentEnrollment::with([
            'course' => function ($query) {
                $query->with(['coursePaths.lessons']);
            }
        ])->where('student_id', $student->id)->get();
        
        return view('student.enrolled-courses', compact('courses', 'student'));
    }
    

}