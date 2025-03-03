<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\CoursesPath;
use App\Models\PathOfPath;
use App\Models\StudentEnrollment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

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
        Log::info('🟢 store() function is called');
        Log::info('🔍 Incoming Request Data:', $request->all());
    
        try {
            $validatedData = $request->validate([
                'name' => 'required|string|max:255',
                'slug' => 'required|string|max:255',
                'course_path' => 'nullable|string|max:255',
                'skill_level' => 'nullable|string|max:255',
                'language' => 'required|string|max:255',
                'age_group_id' => 'required|integer|min:1',
                'price' => 'required|numeric|min:0',
                'prereq' => 'nullable|array',
                'prereq.*' => 'string|max:255',
                'course_tags' => 'nullable|string',
                'description' => 'nullable|string',
                'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    
                // ✅ Course Paths Validation
                'course_paths' => 'required|array|min:1',
                'course_paths.*.name' => 'required|string|max:255',
                'course_paths.*.duration' => 'required|string|max:255',
                'course_paths.*.price' => 'nullable|numeric|min:0',
                'course_paths.*.description' => 'nullable|string',
    
                // ✅ Path of Paths Validation
                'path_of_paths' => 'nullable|array',
                'path_of_paths.*' => 'nullable|array',
                'path_of_paths.*.*.name' => 'required|string|max:255',
                'path_of_paths.*.*.duration' => 'nullable|string|max:255',
            ]);
    
            Log::info('✅ Validated Data:', ['validatedData' => $validatedData]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            Log::error('❌ Validation Failed:', ['errors' => $e->errors()]);
            return redirect()->back()->withErrors($e->errors())->withInput();
        }
     
         try {
             DB::beginTransaction();
             Log::info('🟢 Begin transaction');
     
             // ✅ Save Course
             $course = new Course();
             $course->name = $validatedData['name'];
             $course->slug = $validatedData['slug'];
             $course->course_path = $validatedData['course_path'] ?? null;
             $course->skill_level = $validatedData['skill_level'] ?? null;
             $course->language = $validatedData['language'];
             $course->duration = "12";
             $course->price = $validatedData['price'];
             $course->age_group_id = (int) $validatedData['age_group_id'];
             $course->prereq = isset($validatedData['prereq']) ? json_encode($validatedData['prereq']) : null;
             $course->course_tags = isset($validatedData['course_tags']) ? json_encode(explode(',', $validatedData['course_tags'])) : null;
             $course->description = $validatedData['description'];
     
             if ($request->hasFile('image')) {
                 $courseImagePath = $request->file('image')->store('course_images', 'public');
                 $course->image = $courseImagePath;
             }
     
             $course->save();
             Log::info('✅ Course Created: ID ' . $course->id);
             $t_duration = 0;
             // ✅ Save Course Paths
             foreach ($validatedData['course_paths'] as $pathIndex => $pathData) {
                 $coursePath = new CoursesPath();
                 $coursePath->course_id = $course->id;
                 $coursePath->name = $pathData['name'];
                 $coursePath->description = $pathData['description'] ?? null;
                 $coursePath->duration = $pathData['duration'];
                 $coursePath->price = $pathData['price'] ?? null;
                 $t_duration += $pathData['duration'];
                 if ($request->hasFile("course_paths.$pathIndex.image")) {
                     $coursePath->image = $request->file("course_paths.$pathIndex.image")->store('path_images', 'public');
                 } else {
                     $coursePath->image = 'default.png';
                 }
     
                 $coursePath->save();
                 Log::info('✅ Course Path Created: ID ' . $coursePath->id);
     
                 // ✅ Save Path of Paths (Sub-paths)
                 if (!empty($validatedData['path_of_paths'][$pathIndex]) && is_array($validatedData['path_of_paths'][$pathIndex])) {
                     foreach ($validatedData['path_of_paths'][$pathIndex] as $subPathData) {
                         $subPath = new PathOfPath();
                         $subPath->course_path_id = $coursePath->id;
                         $subPath->parent_id = null; // Ensure correct parent linkage
                         $subPath->name = $subPathData['name'];
                         $subPath->duration = $subPathData['duration'] ?? null;
                         $subPath->is_active = 1;
                         $subPath->save();
                        $t_duration += $subPathData['duration'];
                         Log::info("✅ Sub Path Created under Path ID {$coursePath->id}: " . $subPath->name);
                     }
                 } else {
                     Log::warning('⚠ No sub-paths found for path index: ' . $pathIndex);
                 }
             }
     
             DB::commit();
             Log::info('🟢 Transaction committed successfully!');
     
             return redirect()->back()->with('success', 'Course and paths saved successfully!');
         } catch (\Exception $e) {
             DB::rollBack();
             Log::error('❌ Failed to save data: ' . $e->getMessage());
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
public function enrollNow($id){
    //Validate that this student didnt enroll in the same course or any course before
    $enrollment = StudentEnrollment::where('student_id',Auth::guard('student')->user()->id)->where('course_id',$id)->first();
    if($enrollment){
        return redirect()->back()->with('error','You already enrolled in this course');
    }
    // or any other course
    $enrollment = StudentEnrollment::where('student_id',Auth::guard('student')->user()->id)->first();
    if($enrollment){
        return redirect()->back()->with('error','You already enrolled in a course');
    }
    $course = Course::findOrFail($id);
    $enrollment = new StudentEnrollment();
    $enrollment->student_id = Auth::guard('student')->user()->id;
    $enrollment->course_id = $course->id;
    $enrollment->save();
    return redirect()->route('courses.show', $course->id)
    ->with('success', 'Enrollment request sent, waiting for approval');
}
public function studentJoinNow(){
$user = Auth::guard('student')->user();
$course = Course::where('year',$user->year)->where('favor',1)->first();
return view('student.course-details',compact('course'));

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
