<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseStudent;
use Illuminate\Http\Request;
use App\Models\Enrollment; // Make sure this model exists
use App\Models\Student;
use App\Models\Course;
use App\Models\StudentEnrollment;

class EnrollmentController extends Controller
{
    public function index()
    {
        $enrollments = StudentEnrollment::with(['student', 'course'])->where('status', 'pending')->get();

        return view('supervisor.enrollment_requests', compact('enrollments'));
    }

    public function approve($id)
    {
        $enrollment = StudentEnrollment::findOrFail($id);
        $enrollment->update(['status' => 'enrolled']);
        $course_student = new CourseStudent();
        $course_student->course_id = $enrollment->course_id;
        $course_student->student_id = $enrollment->student_id;
        $course_student->status = 'enrolled';
        $course_student->enrolled_at = now();
        $course_student->save();

        return response()->json(['success' => true, 'message' => 'Enrollment approved successfully.']);
    }

    public function reject($id)
    {
        $enrollment = StudentEnrollment::findOrFail($id);
        $enrollment->update(['status' => 'rejected']);

        return response()->json(['success' => true, 'message' => 'Enrollment rejected successfully.']);
    }
}
