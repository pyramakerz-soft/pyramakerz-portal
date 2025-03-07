<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class InstructorController extends Controller
{
    public function index()
    {
        $instructors = User::where('role', 'teacher')->with('courses')->get();
        return view('supervisor.instructors.index', compact('instructors'));

        
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|string|max:20',
            'governorate' => 'nullable|string|max:255',
            'password' => 'required|string|min:6',
        ]);

        $instructor = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'governorate' => $request->governorate,
            'password' => Hash::make($request->password),
            'role' => 'teacher'
        ]);
        $instructor->assignRole('instructor');
        return response()->json(['message' => 'Instructor added successfully!']);
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
