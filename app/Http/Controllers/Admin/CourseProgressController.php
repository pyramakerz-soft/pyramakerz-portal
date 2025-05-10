<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CourseProgress;
use App\Models\User;
use App\Models\Course;
use App\Models\Group;
use Carbon\Carbon;

class CourseProgressController extends Controller
{
    public function index(Request $request)
    {
        // $groups = Group::whereNotNull('instructor_id')->get();
        // foreach ($groups as $group) {
        //     $courseProgress = CourseProgress::where('group_id', $group->id)->first();
        //     if (!$courseProgress) {
        //         $courseProgress = new CourseProgress();
        //         $courseProgress->group_id = $group->id;
        //         $courseProgress->instructor_id = $group->instructor_id;
        //         $courseProgress->course_id = $group->course_id;
        //         $courseProgress->start_date = $group->schedules->first()->date;
        //         $courseProgress->save();
        //     }
        // }
        $courseProgressall = CourseProgress::all();
        foreach ($courseProgressall as $courseProgress) {
            $groupSchedules = $courseProgress->group->schedules;
            $courseProgress->end_date = $groupSchedules->last()->date;
            $completedCount = $groupSchedules->where('date', '<=', Carbon::now())->count();
            $courseProgress->completed_sessions = $completedCount;
            $courseProgress->total_sessions = $groupSchedules->count();
            $courseProgress->status = $completedCount == $courseProgress->total_sessions ? 'Finished' : 'Online';
            $courseProgress->save();
        }
        $instructors = User::where('role', 'teacher')->get();
        $courses = Course::all();
        $query = CourseProgress::query();

        // Filters
        if ($request->instructor_id) {
            $query->where('instructor_id', $request->instructor_id);
        }

        if ($request->course_id) {
            $query->where('course_id', $request->course_id);
        }
        if ($request->group_id) {
            $query->where('group_id', $request->group_id);
        }

        if ($request->status) {
            //     $query->whereHas('group', function ($q) use ($request) {
            //         $q->where('status', $request->status);
            //     });
            // }
            $query->where('status', $request->status);
        }
        if ($request->start_date) {
            $query->whereDate('created_at', '>=', $request->start_date);
        }
        if ($request->end_date) {
            $query->whereDate('created_at', '<=', $request->end_date);
        }

        $progressData = $query->with('course', 'instructor')->get();

        // Summary Data
        // $totalGroups = $progressData->count();
        // $onlineGroups = $progressData->where('status', 'Online')->count();
        // $offlineGroups = $progressData->where('status', 'Offline')->count();
        // $delayedGroups = $progressData->where('status', 'Delayed')->count();
        // $finishedGroups = $progressData->where('status', 'Finished')->count();
        // $canceledGroups = $progressData->where('status', 'Canceled')->count();
        $groupQuery = Group::query();
        $totalGroups = $groupQuery->count();
        $activeGroups = $groupQuery->where('status', 'active')->count();
        $unactiveGroups = $totalGroups - $activeGroups;

        return view('supervisor.track-progress.index', compact(
            'progressData',
            'instructors',
            'courses',
            'totalGroups',
            'activeGroups',
            'unactiveGroups',
        ));
    }
}
