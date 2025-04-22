<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CoursesPath;
use App\Models\PathOfPath;
use App\Models\Lesson;
use App\Models\LessonResource;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;

class LessonResourceController extends Controller
{
    /**
     * Display a listing of lesson resources with optional filtering.
     */
    public function index(Request $request)
    {
        $resources = LessonResource::with([
            'lesson.pathOfPath',
            'lesson.coursePath.course'
        ])
            ->when($request->course_id, function ($query, $courseId) {
                $query->whereHas('lesson.coursePath.course', function ($q) use ($courseId) {
                    $q->where('id', $courseId);
                });
            })
            ->when($request->course_path_id, function ($query, $pathId) {
                $query->whereHas('lesson.coursePath', function ($q) use ($pathId) {
                    $q->where('id', $pathId);
                });
            })
            ->when($request->path_of_path_id, function ($query, $popId) {
                $query->whereHas('lesson.pathOfPath', function ($q) use ($popId) {
                    $q->where('id', $popId);
                });
            })
            ->when($request->lesson_id, function ($query, $lessonId) {
                $query->where('lesson_id', $lessonId);
            })
            ->latest()
            ->paginate(20);

        $courses = Course::all();
        $coursePaths = CoursesPath::all();
        $pathOfPaths = PathOfPath::all();
        $lessons = Lesson::all();

        return view('supervisor.resources.index', compact('resources', 'courses', 'coursePaths', 'pathOfPaths', 'lessons'));
    }


    /**
     * Remove the specified lesson resource from storage.
     */
    public function destroy($id)
    {
        $resource = LessonResource::findOrFail($id);

        if ($resource->file_path) {
            $fullPath = public_path($resource->file_path);

            if (File::exists($fullPath)) {
                if (File::isDirectory($fullPath)) {
                    // It's a directory (e.g., extracted handout zip), delete all contents
                    File::deleteDirectory($fullPath);
                } else {
                    // It's a single file
                    File::delete($fullPath);
                }
            }
        }

        $resource->delete();

        return response()->json(['message' => 'Resource and associated files deleted']);
    }
}
