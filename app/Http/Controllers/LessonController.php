<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use Illuminate\Http\Request;
use Log;

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
                
                 $path = $request->file('resource_file')->move(public_path('storage/lesson_resources'), $request->file('resource_file')->getClientOriginalName());
$lesson->resource_file = 'lesson_resources/' . $request->file('resource_file')->getClientOriginalName();
            }

            $lesson->save();

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the lesson.');
        }
    }



    public function storeLesson(Request $request)
{
    $request->validate([
        'title' => 'required|string|max:255',
        'order' => 'required|integer',
        'video_url' => 'nullable|url',
        'course_id' => 'required|exists:courses,id',
        'course_path_id' => 'required|exists:course_paths,id',
        'path_of_path_id' => 'required|exists:path_of_paths,id',
    ]);

    Lesson::create([
        'title' => $request->title,
        'order' => $request->order,
        'video_url' => $request->video_url,
        'course_id' => $request->course_id,
        'course_path_id' => $request->course_path_id,
        'path_of_path_id' => $request->path_of_path_id,
    ]);

    return response()->json(['message' => 'Lesson added successfully!'], 200);
}


    /**
     * Upload material for a lesson.
     */
    public function uploadMaterial(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'material' => 'required|file|mimes:pdf,doc,docx,ppt,pptx,zip,rar|max:10240',
        ]);

        $lesson = Lesson::findOrFail($request->lesson_id);
        $filePath = $request->file('material')->store('lesson_materials', 'public');

        $lesson->update(['resource_file' => $filePath]);

        return response()->json(['message' => 'Material uploaded successfully!'], 200);
    }
}
