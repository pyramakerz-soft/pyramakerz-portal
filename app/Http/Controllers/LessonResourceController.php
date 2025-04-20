<?php

namespace App\Http\Controllers;

use App\Models\Course;
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
        $resources = LessonResource::paginate(20);
        return view('supervisor.resources.index', compact('resources'));
    }

    /**
     * Remove the specified lesson resource from storage.
     */
    public function destroy($id)
    {
        $resource = LessonResource::findOrFail($id);

        // Delete file from storage if exists
        if ($resource->file_path && File::exists(public_path($resource->file_path))) {
            File::delete(public_path($resource->file_path));
        }

        $resource->delete();

        return response()->json(['message' => 'Resource deleted']);
    }
}
