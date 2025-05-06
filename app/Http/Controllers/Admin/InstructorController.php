<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\InstructorsImport;

class InstructorController extends Controller
{
    public function index(Request $request)
    {
        $query = User::where('role', 'teacher')->with('courses');
        if ($request->has('search')) {
            $query->where('users.name', 'like', '%' . $request->search . '%');
        }
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('salary_type')) {
            $query->where('salary_type', $request->salary_type);
        }

        if ($request->filled('course')) {
            $query->whereHas('groups.course', function ($q) use ($request) {
                $q->where('name', $request->course);
            });
        }
        $instructors = $query->get();
        $courses = Course::all();
        return view('supervisor.instructors.index', compact('instructors', 'courses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'email' => 'required|email|unique:users,email',
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'max:20'],
            'governorate' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
            'level'        => 'nullable|string|max:255',
            'salary_type'  => 'nullable|in:Full-Time,Part-Time,Per-Session',
            'salary'       => 'nullable|numeric|min:0',
        ]);

        $instructor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'governorate' => $request->governorate,
            'password' => Hash::make($request->password),
            'role' => 'teacher',
            'level'        => $request->level,
            'salary_type'  => $request->salary_type,
            'salary'       => $request->salary,
        ]);
        $instructor->assignRole('instructor');
        return response()->json(['message' => 'Instructor added successfully!']);
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xlsx,xls,csv|max:2048',
        ]);

        Excel::import(new InstructorsImport, $request->file('file'));

        // $users = User::where('role', 'teacher')->whereDoesntHave('roles')->get();
        // foreach ($users as $user) {
        //     $user->assignRole('instructor');
        // }

        return response()->json(['message' => 'Instructors imported successfully!']);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'regex:/^[a-zA-Z\s]+$/', 'max:255'],
            'email' => 'required|email|unique:users,email,' . $id,
            'phone' => ['nullable', 'regex:/^[0-9]+$/', 'max:20'],
            'governorate' => 'nullable|string|max:255',
            'password' => 'sometimes|string|min:6',
            'level'        => 'nullable|string|max:255',
            'salary_type'  => 'nullable|in:Full-Time,Part-Time,Per-Session',
            'salary'       => 'nullable|numeric|min:0',
        ]);

        $instructor = User::findOrFail($id);

        $instructor->name = $request->name;
        $instructor->email = $request->email;
        $instructor->phone = $request->phone;
        $instructor->governorate = $request->governorate;

        if ($request->filled('password')) {
            $instructor->password = Hash::make($request->password);
        }
        if ($request->filled('level')) {
            $instructor->level = $request->level;
        }
        if ($request->filled('salary_type')) {
            $instructor->salary_type = $request->salary_type;
        }
        if ($request->filled('salary')) {
            $instructor->salary = $request->salary;
        }

        $instructor->save();

        return response()->json([
            'message' => 'Instructor updated successfully.',
            'instructor' => $instructor
        ]);
    }


    public function deleteInstructor($id)
    {
        // Validate that the ID is numeric and positive
        if (!is_numeric($id) || $id <= 0) {
            return back()->with('error', 'Invalid instructor ID');
        }

        // Attempt to find the instructor
        $instructor = User::find($id);

        // Check if instructor exists
        if (!$instructor) {
            return back()->with('error', 'Instructor not found');
        }

        try {
            $instructor->delete(); // Perform delete action
            return back()->with('success', 'Instructor deleted successfully');
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to delete instructor. Please try again.');
        }
    }
}
