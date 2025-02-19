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

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'governorate' => $request->governorate,
            'password' => Hash::make($request->password),
            'role' => 'teacher'
        ]);

        return response()->json(['message' => 'Instructor added successfully!']);
    }
}
