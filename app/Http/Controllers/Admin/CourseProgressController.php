<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseProgress;
use App\Models\User;
use App\Models\Course;
use Carbon\Carbon;

class CourseProgressController extends Controller
{
    public function index(Request $request)
{
    $instructors = User::where('role', 'teacher')->get();
    $courses = Course::all();
    $query = CourseProgress::query();

    // Filters
    if ($request->branch) {
        $query->where('branch', $request->branch);
    }

    if ($request->instructor_id) {
        $query->where('instructor_id', $request->instructor_id);
    }

    if ($request->course_id) {
        $query->where('course_id', $request->course_id);
    }

    if ($request->status) {
        $query->where('status', $request->status);
    }

    if ($request->date_filter) {
        $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
        $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
        $startOfMonth = Carbon::now()->startOfMonth();
        $endOfMonth = Carbon::now()->endOfMonth();

        switch ($request->date_filter) {
            case 'this_week':
                $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                break;
            case 'this_month':
                $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                break;
        }
    }

    $progressData = $query->with('course', 'instructor')->get();

    // Summary Data
    $totalGroups = $progressData->count();
    $onlineGroups = $progressData->where('status', 'Online')->count();
    $offlineGroups = $progressData->where('status', 'Offline')->count();
    $delayedGroups = $progressData->where('status', 'Delayed')->count();
    $finishedGroups = $progressData->where('status', 'Finished')->count();
    $canceledGroups = $progressData->where('status', 'Canceled')->count();

    return view('supervisor.track-progress.index', compact(
        'progressData', 'instructors', 'courses',
        'totalGroups', 'onlineGroups', 'offlineGroups',
        'delayedGroups', 'finishedGroups', 'canceledGroups'
    ));
}

}

