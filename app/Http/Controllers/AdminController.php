<?php

namespace App\Http\Controllers;

use App\Models\Course;
use Illuminate\Http\Request;

class AdminController extends Controller
{
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
                'prereq' => 'nullable|array', // Expecting an array for multiple select
                'course_tags' => 'nullable', // Expecting an array for tags
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
    

}
