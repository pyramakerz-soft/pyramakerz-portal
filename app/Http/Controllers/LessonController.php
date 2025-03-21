<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use ZipArchive;

class LessonController extends Controller
{
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'course_path_id' => 'nullable|exists:course_paths,id', // Validate if the course_path_id exists
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'resource_file' => 'nullable|file',
            'order' => 'nullable|integer|min:0',
            'is_active' => 'required|boolean',
        ]);

        try {
            $lesson = new Lesson();
            $lesson->course_path_id = $validatedData['course_path_id'] ?? null;
            $lesson->title = $validatedData['title'];
            $lesson->description = $validatedData['description'] ?? null;
            $lesson->video_url = $validatedData['video_url'] ?? null;
            $lesson->order = $validatedData['order'] ?? 0;
            $lesson->is_active = $validatedData['is_active'];

            if ($request->hasFile('resource_file')) {
                // $path = $request->file('resource_file')->store('lesson_resources', 'storage/lesson_resources');
                // $lesson->resource_file = $path;
                
                 $path = $request->file('resource_file')->move(public_path('lesson_resources'), $request->file('resource_file')->getClientOriginalName());
$lesson->resource_file = 'lesson_resources/' . $request->file('resource_file')->getClientOriginalName();
            }

            $lesson->save();

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the lesson.');
        }
    }


    public function scheduleLesson(Request $request)
{
    $request->validate([
        'lesson_id' => 'required|exists:lessons,id',
        'date' => 'required|date',
        'time' => 'required'
    ]);

    $lesson = Lesson::findOrFail($request->lesson_id);

    // ✅ Check if another lesson in the same `course_path_id` has this date
    $existsInCoursePath = Lesson::where('course_path_id', $lesson->course_path_id)
                                ->where('lesson_date', $request->date)
                                ->where('id', '!=', $lesson->id) // Exclude current lesson
                                ->exists();

    // ✅ Check if another lesson in the same `path_of_path_id` has this date
    $existsInPathOfPath = Lesson::where('path_of_path_id', $lesson->path_of_path_id)
                                ->where('lesson_date', $request->date)
                                ->where('id', '!=', $lesson->id) // Exclude current lesson
                                ->exists();

    if ($existsInCoursePath || $existsInPathOfPath) {
        return response()->json(['message' => 'A lesson is already scheduled on this date!'], 422);
    }

    // ✅ Save lesson date and time
    $lesson->update([
        'lesson_date' => $request->date,
        'lesson_time' => $request->time
    ]);

    return response()->json(['message' => 'Lesson date saved successfully!'], 200);
}


    
public function storeLesson(Request $request)
{
    $request->validate([
        'title'            => 'required|string|max:255',
        'order'            => 'required|integer',
        'video_url'        => 'nullable|url',
        'course_id'        => 'required|exists:courses,id',
        'course_path_id'   => 'required|exists:course_paths,id',
        'path_of_path_id'  => 'required|exists:path_of_paths,id',
    ]);

    // Create the new lesson.
    $lesson = Lesson::create([
        'title'           => $request->title,
        'order'           => $request->order,
        'video_url'       => $request->video_url,
        'course_id'       => $request->course_id,
        'course_path_id'  => $request->course_path_id,
        'path_of_path_id' => $request->path_of_path_id,
    ]);

    // Define default scheduling parameters.
    // These could come from the course/group settings; here we use example defaults.
    $defaultParameters = [
        'start_date'      => now()->format('Y-m-d'),
        'weekly_sessions' => 1,                 // Example: one session per week
        'course_duration' => 4,                 // Example: course lasts 4 weeks
        'start_time'      => '07:00:00',
        'end_time'        => '08:00:00',
        'session_days'    => ['Monday'],        // Example: sessions are on Monday
    ];

    // Create a new Request instance using these defaults.
    // $fakeRequest = new \Illuminate\Http\Request($defaultParameters);

    // Call the InstructorController's scheduling method.
    // (Alternatively, you might extract the scheduling logic to a service so it can be reused.)
    // $instructorController = app(\App\Http\Controllers\InstructorController::class);
    // $instructorController->rescheduleGroupsForCourse($fakeRequest, $lesson->course_id);

    return response()->json(['message' => 'Lesson added and group schedules updated successfully!'], 200);
}

public function uploadResource(Request $request)
{
    $request->validate([
        'lesson_id'  => 'required|exists:lessons,id',
        'type'       => 'required|in:session,teaching_guide,project,quiz,assignment,handout',
        'file'       => 'nullable|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240',
        'link'       => 'nullable|url|max:500',
        'title'      => 'nullable|string|max:255',
        'description'=> 'nullable|string',
    ]);

    $filePath = null;
    $extractedPath = null;

    if ($request->hasFile('file')) {
        $file = $request->file('file');
        $originalExtension = $file->getClientOriginalExtension();
        $originalName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

        $timestamp = time();

        // If it's a handout and a zip file, extract it
        if ($request->type === 'handout' && $originalExtension === 'zip') {
            $lessonId = $request->lesson_id;
            $destinationPath = public_path("lesson_materials/handouts/{$lessonId}/{$timestamp}/");

            // Create directory if not exists
            if (!File::exists($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true);
            }

            // Move the uploaded file temporarily
            $zipPath = $destinationPath . $file->getClientOriginalName();
            $file->move($destinationPath, $file->getClientOriginalName());

            // Extract the zip file
            $zip = new ZipArchive;
            if ($zip->open($zipPath) === true) {
                $zip->extractTo($destinationPath);
                $zip->close();

                // Delete the original zip file after extraction
                File::delete($zipPath);

                // Store the extracted folder path
                $filePath = "lesson_materials/handouts/{$lessonId}/{$timestamp}/{$originalName}/";
            } else {
                return response()->json(['message' => 'Failed to extract zip file'], 500);
            }
        } else {
            // Handle normal file upload
            $imageName = $timestamp . '.' . $originalExtension;
            $file->move(public_path('lesson_materials'), $imageName);
            $filePath = 'lesson_materials/' . $imageName;
        }
    }

    // Assign visibility based on type
    $visibility = match ($request->type) {
        'session', 'teaching_guide', 'project' => 'instructor',
        'quiz', 'assignment'                   => 'both',
        'handout'                               => 'student',
        default                                 => 'both',
    };

    \App\Models\LessonResource::create([
        'lesson_id'  => $request->lesson_id,
        'uploader_id'=> Auth::guard('admin')->user()->id,
        'title'      => $request->type ?? 'Resource',
        'description'=> $request->input('description'),
        'file_path'  => $filePath, // Folder path if extracted, otherwise file path
        'resource_link' => $request->link,
        'resource_type'=> $request->type,
        'visible_to' => $visibility,
    ]);

    return response()->json([
        'message' => 'Resource uploaded successfully!',
    ], 200);
}

    

}
