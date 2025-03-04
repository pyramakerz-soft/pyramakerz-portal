<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Auth\Events\Registered;
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
            'role' => 'student'
        ]);

        return redirect()->route('student-courses');
    }

    public function registerStudent(Request $request){
        //Validate all requests
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:255',
            'parent_phone' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'bday' => 'required|string|max:255',
        ]);
        $user = new Student();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->country = $request->country;
        $user->city = $request->city;
        $user->bday = $request->bday;
        $user->parent_phone = $request->parent_phone;
        $user->password = Hash::make($request->password);
        if($request->confirm_password != $request->password){
            return back()->withErrors(['password' => 'Passwords do not match'])->withInput();
        }
        $user->save();
    $student = Student::where('email', $request->email)->first();

        event(new Registered($user));
        Auth::guard('student')->login($student);

        // Regenerate session to avoid session fixation attacks
        $request->session()->regenerate();

        return redirect()->route('my-progress');
        // return
        // redirect($this->redirectPath());
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
    
        $student = Student::where('email', $request->email)->first();
    
        if ($student && Hash::check($request->password, $student->password)) {
            Auth::guard('student')->login($student);
    
            // Regenerate session to avoid session fixation attacks
            $request->session()->regenerate();
    
            return redirect()->route('my-progress');
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

        return redirect()->route('my-progress');
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
        if(Auth::guard('admin')->user()->roles[0]->name == "instructor"){
            return redirect()->route('admin-courses');
        }
        if(Auth::guard('admin')->user()->roles[0]->name == "admin"){
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