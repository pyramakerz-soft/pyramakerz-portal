<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;
use Log;

class CourseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view("dashboard.create-course");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255|unique:courses,slug',
            'price' => 'required|numeric|min:0',
            'course_path' => 'nullable|string|max:255',
            'skill_level' => 'nullable|string|max:255',
            'language' => 'nullable|string|max:255',
            'prereq' => 'nullable|array',
            'prereq.*' => 'string|max:255',
            'course_tags' => 'nullable|string',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        try {
            $course = new Course();
            $course->name = $validatedData['name'];
            $course->slug = $validatedData['slug'] ?? null;
            $course->price = $validatedData['price'];
            $course->course_path = $validatedData['course_path'] ?? null;
            $course->skill_level = $validatedData['skill_level'] ?? null;
            $course->language = $validatedData['language'] ?? null;
            $course->prereq = isset($validatedData['prereq']) ? json_encode($validatedData['prereq']) : null;
            $course->course_tags = isset($validatedData['course_tags']) ? json_encode(explode(',', $validatedData['course_tags'])) : null;
            $course->description = $validatedData['description'] ?? null;

            // if ($request->hasFile('image')) {
            //     $path = $request->file('image')->store('course_images', 'public');
            //     $course->image = $path;
            // }

            if ($request->hasFile('image')) {
                $file = $request->file('image');
                Log::info('Uploaded file details:', [
                    'name' => $file->getClientOriginalName(),
                    'type' => $file->getMimeType(),
                    'extension' => $file->getClientOriginalExtension(),
                ]);
            }

            $course->save();

            return redirect()->back()->with('success', 'Course created successfully!');
        } catch (\Exception $e) {
            Log::error('Failed to create course: ' . $e->getMessage());
            return redirect()->back()->with('error', 'An error occurred while creating the course.');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
