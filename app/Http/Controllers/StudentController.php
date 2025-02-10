<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentAnswer;
use App\Models\StudentEnrollment;
use App\Models\StudentTest;
use App\Models\Test;
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
    public function myTasks(){
        $student = Auth::guard('student')->user();
        $tasks = StudentTest::where('student_id', $student->id)->with('test.questions')->get();
        return view('student.tasks', compact('student', 'tasks'));
    }
    public function show($id)
{
    $test = Test::with('questions')->findOrFail($id);
    $studentId = Auth::id();

    // Fetch student answers for this test
    $studentAnswers = StudentAnswer::where('student_id', $studentId)->where('test_id', $id)->get();

    // Check if the student has completed this test
    $testCompleted = $studentAnswers->count() === $test->questions->count();

    return view('student.test', compact('test', 'studentAnswers', 'testCompleted'));
}


public function submitTest(Request $request, $testId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $studentId = Auth::id();

        foreach ($validated['answers'] as $questionId => $selectedChoice) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'test_id' => $testId,
                    'question_id' => $questionId,
                ],
                ['selected_choice' => $selectedChoice]
            );
        }

        return redirect()->route('view-test', $testId)->with('success', 'Test submitted successfully!');
    }

    public function viewResults($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        $studentAnswers = StudentAnswer::where('student_id', Auth::id())->where('test_id', $id)->get();
    
        return view('student.test_results', compact('test', 'studentAnswers'));
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