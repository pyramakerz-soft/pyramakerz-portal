<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\GroupStudent;
use App\Models\InstructorToStudentEvaluation;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminController extends Controller
{
    public function index()
{
    $teacherId = Auth::guard('admin')->user()->id;
    if(Auth::guard('admin')->user()->role == 'admin') {
        $courses = Course::with(['coursePaths.paths', 'coursePaths.lessons'])->paginate(10);
    } else {
        $courses = Course::whereHas('groups', function ($query) use ($teacherId) {
            $query->where('instructor_id', $teacherId);
        })->with(['coursePaths.paths', 'coursePaths.lessons'])->paginate(10);
    }
    // Fetch only courses where the teacher is assigned via a group
    

    // Fetch categories & teachers for filtering (if needed)
    $categories = Category::with('courses')->get();
    $teachers = User::where('role', 'teacher')->get();

    return view('dashboard.admin-courses', compact('courses', 'categories', 'teachers'));
}

public function sessionDetails($session_id)
{
    // Get the schedule details
    $schedule = GroupSchedule::with(['group.course', 'group.instructor', 'lesson'])->findOrFail($session_id);
    $group = $schedule->group;

    // Get all students in the group (students enrolled in this specific group)
    $students = GroupStudent::with('student')
        ->where('group_id', $group->id)
        ->get();

    // Get all evaluations for students in this specific session
    $evaluations = InstructorToStudentEvaluation::whereIn('student_id', $students->pluck('student_id'))
        ->where('course_id', $group->course_id)
        ->where('course_path_id', $schedule->lesson->course_path_id ?? null)
        ->where('path_of_path_id', $schedule->lesson->path_of_path_id ?? null)
        ->where('group_schedule_id', $session_id) // Ensuring evaluations belong to this session
        ->get()
        ->keyBy('student_id'); // Store evaluations by student_id for easy lookup

    return view('general.session-details', compact('group', 'schedule', 'students', 'evaluations'));
}





    public function createCourse(Request $request)
    {
        try {
            // Validate the request data
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255|unique:courses,slug',
                'price' => 'required|numeric|min:0',
                'discounted_price' => 'nullable|numeric|min:0',
                'course_path' => 'required|string|max:255',
                'age_group' => 'required|string|max:50',
                'skill_level' => 'required|string|max:50',
                'language' => 'required|string|max:50',
                'prereq' => 'nullable|array',
                'course_tags' => 'nullable',
                'description' => 'required|string',
            ]);
    
            // Create a new course instance and save
            Course::create([
                'name' => $validatedData['name'],
                'slug' => $validatedData['slug'],
                'price' => $validatedData['price'],
                'discounted_price' => $validatedData['discounted_price'] ?? null,
                'course_path' => $validatedData['course_path'],
                'age_group_id' => $validatedData['age_group'],
                'skill_level' => $validatedData['skill_level'],
                'language' => $validatedData['language'],
                'prereq' => json_encode($validatedData['prereq'] ?? []),
                'course_tags' => json_encode($validatedData['course_tags'] ?? []),
                'description' => $validatedData['description'],
            ]);
    
            // Redirect back with success message
            return redirect()->back()->with('message', 'Course created successfully');
        } catch (\Illuminate\Validation\ValidationException $e) {
            // Handle validation errors
            return redirect()->back()->withErrors($e->validator)->withInput();
        }
    }
    public function courseDetail(string $id)
{
    $course = Course::with([
        'coursePaths.paths.lessons' // Load course paths, their sub-paths, and lessons
    ])->findOrFail($id);
    $teachers = User::where('role', 'teacher')->get();

    // Debugging: Check if data exists
    \Log::info('Loaded Course Data:', ['course' => $course->toArray()]);
    \Log::info('Loaded Teachers:', ['teachers' => $teachers->toArray()]);

    return view('dashboard.course-details', compact('course', 'teachers'));
}


}
