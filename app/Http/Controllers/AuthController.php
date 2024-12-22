<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;

class AuthController extends Controller
{
    public function register(Request $request)
{
    // Validate and save student data
    $student = Student::create($request->all());

    // Redirect to the survey page
    return redirect()->route('show_survey', ['id' => $student->id]);
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
        return view('auth.login');  
    }

    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (Auth::guard('student')->attempt($request->only('email', 'password'))) {
            return redirect()->route('student.courses');
        }

        return back()->withErrors(['email' => 'Invalid credentials'])->withInput();
    }

    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        return redirect()->route('login');
    }
}