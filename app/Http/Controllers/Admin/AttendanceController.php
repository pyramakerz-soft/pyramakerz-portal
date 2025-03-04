<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Attendance;
use App\Models\User;
use App\Models\Course;
use App\Models\CoursesPath;

class AttendanceController extends Controller {
    public function index(Request $request) {
        $instructors = User::where('role', 'teacher')->get();
        $courses = Course::all();
        $sessions = ['Session 1', 'Session 2', 'Session 3', 'Session 4'];
    
        // Retrieve lessons that are linked to course paths but do not have sub-paths
        $lessons = Lesson::whereHas('coursePath') // Ensure lessons are linked to course paths
                         ->with('coursePath')
                         ->get();
    
        $query = Attendance::query();
    
        if ($request->filled('day')) {
            $query->where('day', $request->day);
        }
        if ($request->filled('instructor_id')) {
            $query->where('user_id', $request->instructor_id);
        }
        if ($request->filled('course_id')) {
            $query->where('course_id', $request->course_id);
        }
    
        $attendanceRecords = $query
            ->with([
                'student',
                'course.coursePaths.paths', // Load all paths and sub-paths
                'user'
            ])
            ->get()
            ->groupBy(function ($record) {
                return implode('|', [
                    optional($record->user)->name ?? 'Instructor',
                    $record->day,
                    $record->time,
                    $record->status,
                    optional($record->course)->name ?? 'Unknown Course',
                ]);
            });
    
        return view('supervisor.attendance', compact('attendanceRecords', 'sessions', 'instructors', 'courses', 'lessons'));
    }
    
    public function studentDetails($id){
        $student = User::findOrFail($id);
        $courses = Course::all();
        // $sessions = ['Session 1', 'Session 2', 'Session 3', 'Session 4'];
        $attendanceRecords = Attendance::where('student_id', $id)->get();
        // return route('admin.student-details', compact('attendanceRecords', 'student', 'courses'));
        //compact 3 variables to student-details while passing id aswell as parameter
        return view('supervisor.student-details', compact('attendanceRecords', 'student', 'courses'));


        // return route('admin.student-details', $id)-> with('attendanceRecords', 'student', 'courses'));
    }
    
    
}


