<?php

namespace App\Http\Controllers\Admin;

use App\Exports\StudentsTemplateExport;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\Group;
use Maatwebsite\Excel\Facades\Excel;
use App\Imports\StudentsImport;
use App\Models\GroupStudent;
use Symfony\Component\HttpFoundation\BinaryFileResponse;
class StudentController extends Controller
{
    public function index(Request $request)
{
    $query = Student::query();

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
    $request->validate([
        'students_file' => 'required|file|mimes:xlsx,csv',
    ]);

    Excel::import(new StudentsImport, $request->file('students_file'));

    return redirect()->route('admin.students.index')->with('success', 'Students imported successfully!');
}
public function downloadTemplate(): BinaryFileResponse
    {
        return Excel::download(new StudentsTemplateExport, 'students_template.xlsx');
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
