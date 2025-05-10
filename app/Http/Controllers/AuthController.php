<?php

namespace App\Http\Controllers;

use App\Models\Language;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Student;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\ValidationException;
use Illuminate\Support\Str;

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
            'role' => 'student',
            'code' => $this->generateStudentCode(),
        ]);

        return redirect()->route('student-courses');
    }
    private function generateStudentCode()
    {
        do {
            $code = 'STU-' . strtoupper(Str::random(6));
        } while (Student::where('code', $code)->exists());

        return $code;
    }

    public function registerStudent(Request $request)
    {
        //Validate all requests
        $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                'regex:/^[a-zA-Z\s\-]+$/'
            ],
            'email' => [
                'required',
                'email:rfc,dns',
                'unique:students,email'
            ],
            'phone' => ['required', 'regex:/^[0-9]{6,15}$/', 'max:15'],
            'parent_phone' => 'required|string|max:255',
            'password' => 'required|string|min:6',
            'country' => 'required|string|max:255',
            'city' => 'required|string|max:255',
            'bday' => 'required|date',
            'gender' => 'required|in:male,female,other',
            'age_group' => 'required|in:under 6,6-8,9-12,13-17,above 17',
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
        $user->gender = $request->gender;
        $user->age_group = $request->age_group;
        $user->code = $this->generateStudentCode();
        if ($request->confirm_password != $request->password) {
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
        Auth::guard('student')->logout();
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
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

            return redirect()->route('my-progress')->with('success', 'Logged In successfully.');
        }

        return redirect()->back()->with('error', 'Wrong email or password.');
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
            if (Auth::guard('admin')->user()->roles[0]->name == "instructor") {
                return redirect()->route('admin-courses');
            }
            if (Auth::guard('admin')->user()->roles[0]->name == "admin") {
                return redirect()->route('admin.instructors.index');
            }


            // Regenerate session to avoid session fixation attacks

            return redirect()->route('admin-courses');
        }

        return redirect()->back()->with('error', 'Wrong email or password.');
    }



    public function logout(Request $request)
    {
        Auth::guard('student')->logout();
        Auth::guard('web')->logout();
        Auth::guard('admin')->logout();
        return redirect()->route('student-login')->with('success', 'Logged out successfully.');
    }
    public function logoutAdmin()
    {

        Auth::guard('admin')->logout();
        return redirect()->route('admin-login')->with('success', 'Logged out successfully.');
    }
    public function settings($id)
    {
        $user = Student::find($id);
        return view("student.settings", compact("user"));
    }

    public function updateData(Request $request)
    {
        // Get authenticated user
        $user = Auth::guard('student')->user();

        // Update only if a new value is provided
        if (!is_null($request->name)) {
            $user->name = $request->name;
        }
        if (!is_null($request->phone)) {
            $user->phone = $request->phone;
        }
        if (!is_null($request->email)) {
            $user->email = $request->email;
        }

        // Handle profile picture upload
        if ($request->hasFile('image')) {
            // Delete old photo if it exists
            if ($user->photo && file_exists(public_path($user->photo))) {
                unlink(public_path($user->photo));
            }

            // Store new image
            $imageName = time() . '.' . $request->image->getClientOriginalExtension();
            $request->image->move(public_path('student_photos'), $imageName);

            // Update user photo path
            $user->photo = 'student_photos/' . $imageName;
        }

        // Save updates only if any field was updated
        if ($user->isDirty()) {
            $user->save();
            return redirect()->back()->with('success', 'Profile updated successfully!');
        }

        return redirect()->back()->with('info', 'No changes were made.');
    }



    public function changePassword(Request $request)
    {
        // Validate input (Laravel's `confirmed` ensures new_password matches new_password_confirmation)
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
        ]);

        // Get the authenticated student user
        $user = Auth::guard('student')->user();

        // Check if the current password is correct
        if (!Hash::check($request->current_password, $user->password)) {
            return redirect()->back()->with('error', 'The current password is incorrect!');
        }

        // Ensure the new password is different from the current one
        if (Hash::check($request->new_password, $user->password)) {
            return redirect()->back()->with('error', 'The new password must be different from the current password!');
        }
        if ($request->new_password != $request->new_password_confirmation) {
            return redirect()->back()->with('error', 'Password confirmation incorrect!');
        }

        // Update password
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully!');
    }
}
