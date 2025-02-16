<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CoursesPath;
use Illuminate\Http\Request;
use Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $courses = Course::with(['coursePaths', 'coursePaths.lessons'])->paginate(10);
        $categories = Category::with('courses')->get();
        return view('student.all-courses', compact('courses','categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $coursePaths = CoursesPath::all();
        return view("dashboard.create-course", compact("coursePaths"));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'nullable|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
            'course_path' => 'nullable|string|max:255',
            'skill_level' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'prereq' => 'nullable|array',
            'prereq.*' => 'string|max:255',
            'course_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'course_paths' => 'nullable|array',
            'course_paths.*.name' => 'required_with:course_paths|string|max:255',
            'course_paths.*.duration' => 'nullable|string|max:255',
            'course_paths.*.price' => 'nullable|numeric|min:0',
            'course_paths.*.description' => 'nullable|string',
            'course_paths.*.image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $course = null;
            if (!empty($validatedData['name']) || !empty($validatedData['slug'])) {
                $course = new Course();
                $course->name = $validatedData['name'];
                $course->slug = $validatedData['slug'] ?? null;
                $course->course_path = $validatedData['course_path'] ?? null;
                $course->skill_level = $validatedData['skill_level'] ?? null;
                $course->language = $validatedData['language'] ?? null;
                $course->prereq = isset($validatedData['prereq']) ? json_encode($validatedData['prereq']) : null;
                $course->course_tags = isset($validatedData['course_tags']) ? json_encode(explode(',', $validatedData['course_tags'])) : null;
                $course->description = $validatedData['description'] ?? null;

                if ($request->hasFile('image')) {
                    $courseImagePath = $request->file('image')->move(public_path('storage/course_images'), $request->file('image')->getClientOriginalName());
                    $course->image = 'course_images/' . $request->file('image')->getClientOriginalName();

                }

                $course->save();
            }

            if (!empty($validatedData['course_paths'])) {
                foreach ($validatedData['course_paths'] as $pathIndex => $path) {
                    $pathImagePath = null;
                    if (isset($path['image']) && $request->hasFile("course_paths.$pathIndex.image")) {
                        $pathImagePath = $request->file("course_paths.$pathIndex.image")->store('path_images', 'public');
                    }

                    CoursesPath::create([
                        'course_id' => $course ? $course->id : null,
                        'name' => $path['name'],
                        'description' => $path['description'] ?? null,
                        'duration' => $path['duration'] ?? null,
                        'price' => $path['price'] ?? null,
                        'image' => $pathImagePath,
                    ]);
                }
            }

            return redirect()->back()->with('success', 'Data saved successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to save data: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while saving data.');
        }
    }

    public function assignTeacher(Request $request)
    {
        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'teacher_id' => 'required|exists:users,id',
        ]);

        $course = Course::findOrFail($request->course_id);
        $course->instructor_id = $request->teacher_id;
        $course->save();

        return response()->json(['message' => 'Teacher assigned successfully!'], 200);
    }
    /**
     * Display the specified resource.
     */
    public function show(string $id)
{
    $course = Course::with([
        'coursePaths.paths.lessons' // Load course paths, their sub-paths, and lessons
    ])->findOrFail($id);

    return view('student.course-details', compact('course'));
}


    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
