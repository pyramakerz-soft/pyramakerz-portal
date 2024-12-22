<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use Illuminate\Support\Facades\Auth;

class StudentController extends Controller
{
    public function getCourses(Request $request)
    {
        $student = Auth::guard('student')->user();

        $courses = $student->suggestions()
            ->with([
                'course.paths' => function ($query) {
                    $query->orderBy('order');
                },
                'progress'
            ])
            ->get();

        return view('student.courses', compact('courses', 'student'));
    }

}