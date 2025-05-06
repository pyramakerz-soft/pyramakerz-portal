<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsTemplateExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Group;
use Illuminate\Support\Str;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Models\GroupStudent;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\BinaryFileResponse;

class StudentController extends Controller
{
    public function index(Request $request)
    {
        $query = Student::query();
        if ($request->filled('search')) {
            $query->where(function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->search . '%')
                    ->orWhere('email', 'like', '%' . $request->search . '%')
                    ->orWhere('code', 'like', '%' . $request->search . '%');
            });
        }
        // Filter by Course (Check if student is in a group related to this course)
        if ($request->filled('course_id')) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->whereHas('course', function ($q2) use ($request) {
                    $q2->where('courses.id', $request->course_id); // Explicitly specifying table name
                });
            });
        }

        // Filter by Group (Check if student is in the given group)
        if ($request->filled('group_id')) {
            $query->whereHas('groups', function ($q) use ($request) {
                $q->where('groups.id', $request->group_id); // Explicitly specifying table name
            });
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('gender', $request->gender);
        }

        // Filter by Country
        if ($request->filled('country')) {
            $query->where('country', $request->country);
        }

        // Filter by School (Partial match)
        if ($request->filled('school')) {
            $query->where('school', 'like', '%' . $request->school . '%');
        }

        // Filter by Age Group (Convert bday to age range)
        if ($request->filled('age_group')) {
            $ageGroup = explode('-', $request->age_group);
            $query->whereBetween('bday', [
                now()->subYears($ageGroup[1])->format('Y-m-d'),
                now()->subYears($ageGroup[0])->format('Y-m-d')
            ]);
        }

        // Fetch Students
        $students = $query->paginate(10);

        // Fetch all available courses & groups for filtering
        $courses = Course::all();
        $groups = Group::all();

        return view('supervisor.students.index', compact('students', 'courses', 'groups'));
    }


    public function import(Request $request)
    {
        // dd($request->all());
        // $request->validate([
        //     'students_file' => 'required|file|mimes:xlsx,csv',
        // ]);

        Excel::import(new StudentsImport, $request->file('students_file'));

        return redirect()->route('admin.students.index')->with('success', 'Students imported successfully!');
    }
    public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new StudentsTemplateExport, 'students_template.xlsx');
    }
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:students,email',
            'phone' => 'required|string|max:15',
            'parent_phone' => 'required|string|max:15',
            'country' => 'required|string|max:100',
            'city' => 'required|string|max:100',
            'school' => 'required|string|max:100',
            'gender' => 'required|string|max:10',
            'birthday' => 'required|date',
            'year' => 'required|integer',
            'password' => 'required|string|min:6',
        ]);
        $exists = Student::where('email', $request->email)
            ->orWhere('phone', $request->phone)
            ->exists();
        if ($exists) {
            return redirect()->back()->with('error', 'Student with this email or phone already exists.');
        }
        $student = Student::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $request->phone,
            'parent_phone' => $request->parent_phone,
            'country' => $request->country,
            'city' => $request->city,
            'school' => $request->school,
            'gender' => $request->gender,
            'bday' => $request->birthday,
            'year' => $request->year,
            'password' => Hash::make($request->password),
            'code' => $this->generateStudentCode(),
        ]);
        return redirect()->route('admin.students.index')->with('success', 'Student created successfully!');
    }
    private function generateStudentCode()
    {
        do {
            $code = 'STU-' . strtoupper(Str::random(6));
        } while (Student::where('code', $code)->exists());

        return $code;
    }


    public function assignGroup(Request $request)
    {
        $request->validate([
            'student_id' => 'required|exists:students,id',
            'group_id' => 'required|exists:groups,id',
        ]);

        // Assign student to the group
        GroupStudent::updateOrCreate(
            ['student_id' => $request->student_id],
            ['group_id' => $request->group_id]
        );

        return response()->json(['success' => true, 'message' => 'Student assigned successfully!']);
    }
}
