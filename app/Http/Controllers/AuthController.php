<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
class AuthController extends Controller
{
    //     public function register(Request $request)
// {
//     // Validate and save student data
//     $student = Student::create($request->all());

    //     // Redirect to the survey page
//     return redirect()->route('show_survey', ['id' => $student->id]);
// }
    public function register(Request $request)
    {
        // dd($request);
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'password' => 'required|string|min:8',
        ]);

        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->route('home');
    }
    public function showSurvey($id)
    {
        $student = Student::findOrFail($id);
        $languages = Language::all();

        return view('survey', compact('student', 'languages'));
    }

    public function submitSurvey(Request $request, $id)
    {
        $student = Student::findOrFail($id);

        // Save survey responses
        $student->survey()->create($request->all());

        return redirect()->route('thank_you'); // Redirect to a thank-you page
    }


    public function showLoginForm()
    {
        return view('auth.student-login');
    }
    public function showStudentLoginForm()
    {
        return view('auth.student-login');
    }
    public function showAdminLoginForm()
    {
        return view('auth.admin-login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('admin')->attempt($request->only('email', 'password'))) {
            return redirect()->route('instructor.courses');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function studentLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $student = Student::where('email', $request->email)->first();

    if ($student && Hash::check($request->password, $student->password)) {
        Auth::guard('student')->login($student);

        // Regenerate session to avoid session fixation attacks
        $request->session()->regenerate();

        return redirect()->route('student-profile');
    }

    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}
    public function adminLogin(Request $request)
{
    $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    $admin = User::where('email', $request->email)->first();

    if ($admin && Hash::check($request->password, $admin->password)) {
        Auth::guard('admin')->login($admin);
        $request->session()->regenerate();
        if(Auth::guard('admin')->user()->roles[0]->name == "Full Instructor"){
            return redirect()->route('instructor.courses');
        }
        if(Auth::guard('admin')->user()->roles[0]->name == "Admin"){
            return redirect()->route('admin.instructors.index');
        }


        // Regenerate session to avoid session fixation attacks

        return redirect()->route('admin-courses');
    }

    return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
}



    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        return redirect()->route('student-login');
    }
}