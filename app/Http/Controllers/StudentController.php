<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\GroupStudent;
use App\Models\StudentAnswer;
use App\Models\StudentEnrollment;
use App\Models\StudentTask;
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

    public function timetable()
{
    // Get the authenticated student
    $student = Auth::guard('student')->user(); // Assuming 'student' guard is used

    // Fetch groups the student is enrolled in
    $groups = \App\Models\Group::whereHas('students', function ($query) use ($student) {
        $query->where('student_id', $student->id);
    })->with(['course', 'schedules.lesson', 'schedules.group'])->get();

    // Extract unique courses from the student's groups
    $courses = $groups->pluck('course')->unique();

    return view('student.timetable', compact('student', 'groups', 'courses'));
}

    public function myQuiz(){
        $student = Auth::guard('student')->user();
        return view('student.my-quizz', compact('student'));
    }
    public function myQuizes(){
        $student = Auth::guard('student')->user();
        $tasks = StudentTest::where('student_id', $student->id)->with('test.questions')->get();
        return view('student.tasks', compact('student', 'tasks'));
    }
    public function showCourseLessons($courseId)
{
    $student = Auth::guard('student')->user();

    // Get the group associated with the student for this course
    $groupStudent = GroupStudent::where('student_id', $student->id)
        ->whereHas('group', function ($query) use ($courseId) {
            $query->where('course_id', $courseId);
        })
        ->with(['group.schedules.lesson.resources']) // Ensure the resources are loaded
        ->first();

    if (!$groupStudent) {
        return redirect()->route('student.courses')->with('error', 'You are not enrolled in this course.');
    }

    // Get the student's group
    $group = $groupStudent->group;

    // Map lessons from the group's schedules (sorted by date)
    $lessons = $group->schedules->sortBy('date')->map(function ($schedule) use ($group) {
        return [
            'id'          => $schedule->lesson->id,
        'title'       => $schedule->lesson->title,
        'date'        => \Carbon\Carbon::parse($schedule->date)->format('Y-m-d'),
        'start_time'  => \Carbon\Carbon::parse($schedule->start_time)->format('h:i A'),
        'end_time'    => \Carbon\Carbon::parse($schedule->end_time)->format('h:i A'),
        'video_url'   => $schedule->lesson->video_url, // Include the lesson introduction video URL
        'materials'   => $schedule->lesson->resources ?? collect([]),
        'group_id'    => $group->id,
        'schedule_id' => $schedule->id,
        ];
    });

    return view('student.course-lessons', compact('group', 'lessons', 'student'));
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
    
    
    public function getCourses(Request $request)
{
    $student = Auth::guard('student')->user();

    // Fetch the student's groups and related courses
    $courses = GroupStudent::with([
        'group.course.instructor',
        'group.schedules.lesson'
    ])
    ->where('student_id', $student->id)
    ->get();

    return view('student.enrolled-courses', compact('courses', 'student'));
}

    public function mySummary(){
        $student = Auth::guard('student')->user();
        $courses = StudentEnrollment::where('student_id', $student->id)->count();
        return view('student.dashboard', compact('student','courses'));
    }

    public function getTasks(Request $request, Test $test){
        $student = Auth::guard('student')->user();
        $tasks = StudentTask::where('student_id', $student->id)->get();
        return view('student.my-quizz', compact('student', 'tasks'));
    }

}