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
                $path = $request->file('resource_file')->store('lesson_resources', 'public');
                $lesson->resource_file = $path;
            }

            $lesson->save();

            return redirect()->back()->with('success', 'Lesson created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create lesson: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the lesson.');
        }
    }
}
