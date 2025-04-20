<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Student;
use App\Models\Course;
use App\Models\CourseStudent;
use App\Models\GroupStudent;
use App\Models\CoursesPath;
use App\Models\GroupSchedule;
use App\Models\StudentAnswer;
use App\Models\StudentEnrollment;
use App\Models\StudentTask;
use App\Models\StudentTest;
use App\Models\Test;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class StudentController extends Controller
{

    public function profile()
    {
        $student = Auth::guard('student')->user();
        return view('student.profile', compact('student'));
    }

    public function timetable()
    {
        // Get the authenticated student
        $student = Auth::guard('student')->user(); // Assuming 'student' guard is used
        // Fetch groups the student is enrolled in
        $groups = \App\Models\Group::whereHas('students', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->with(['course', 'schedules.lesson', 'schedules.group'])->get();

        // Extract unique courses from the student's groups
        $courses = $groups->pluck('course')->unique();

        return view('student.timetable', compact('student', 'groups', 'courses'));
    }

    public function myQuiz()
    {
        $student = Auth::guard('student')->user();
        return view('student.my-quizz', compact('student'));
    }
    public function myQuizes()
    {
        $student = Auth::guard('student')->user();
        $tasks = StudentTest::where('student_id', $student->id)->with('test.questions')->get();
        return view('student.tasks', compact('student', 'tasks'));
    }
    public function showCourseLessons($courseId)
    {

        // $instructorController = app(\App\Http\Controllers\WhatsAppController::class);
        // $instructorController->sendWhatsAppMessage();
        $student = Auth::guard('student')->user();

        // Get the group associated with the student for this course
        $groupStudent = GroupStudent::where('student_id', $student->id)
            ->whereHas('group', function ($query) use ($courseId) {
                $query->where('course_id', $courseId);
            })
            ->with(['group.schedules.lesson.resources']) // Ensure the resources are loaded
            ->first();

        if (!$groupStudent) {
            return redirect()->route('student.courses')->with('error', 'You are not enrolled in this course.');
        }

        // Get the student's group
        $group = $groupStudent->group;

        // Map lessons from the group's schedules (sorted by date)
        $lessons = $group->schedules->sortBy('date')->map(function ($schedule) use ($group) {
            $lesson = $schedule->lesson;

            return [
                'id'             => $lesson->id,
                'title'          => $lesson->title,
                'video_url'      => $lesson->video_url,
                'description'    => $lesson->description,
                'date'           => $schedule->date,
                'start_time'     => $schedule->start_time,
                'end_time'       => $schedule->end_time,
                'materials'      => $lesson->resources ?? collect([]),
                'group_id'       => $group->id,
                'schedule_id'    => $schedule->id,
                'path_id'        => optional($lesson->pathOfPath)->id,
                'path_name'      => optional($lesson->pathOfPath)->name,
                'course_path_id' => optional($lesson->pathOfPath->coursePath)->id,
                'course_path_name' => optional($lesson->pathOfPath->coursePath)->name,
            ];
        });

        return view('student.course-lessons', compact('group', 'lessons', 'student'));
    }




    public function show($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        $studentId = Auth::id();

        // Fetch student answers for this test
        $studentAnswers = StudentAnswer::where('student_id', $studentId)->where('test_id', $id)->get();

        // Check if the student has completed this test
        $testCompleted = $studentAnswers->count() === $test->questions->count();

        return view('student.test', compact('test', 'studentAnswers', 'testCompleted'));
    }


    public function submitTest(Request $request, $testId)
    {
        $validated = $request->validate([
            'answers' => 'required|array',
        ]);

        $studentId = Auth::id();

        foreach ($validated['answers'] as $questionId => $selectedChoice) {
            StudentAnswer::updateOrCreate(
                [
                    'student_id' => $studentId,
                    'test_id' => $testId,
                    'question_id' => $questionId,
                ],
                ['selected_choice' => $selectedChoice]
            );
        }

        return redirect()->route('view-test', $testId)->with('success', 'Test submitted successfully!');
    }

    public function viewResults($id)
    {
        $test = Test::with('questions')->findOrFail($id);
        $studentAnswers = StudentAnswer::where('student_id', Auth::id())->where('test_id', $id)->get();

        return view('student.test_results', compact('test', 'studentAnswers'));
    }


    public function getCourses(Request $request)
    {
        $student = Auth::guard('student')->user();

        // Fetch Active Courses: Courses where the student is assigned to a group
        $groupCourses = GroupStudent::with([
            'group.course.coursePaths',
            'group.schedules.lesson'
        ])
            ->where('student_id', $student->id)
            ->whereHas('group.schedules', function ($query) {
                $query->where('date', '>=', now()); // Ongoing or future courses
            })
            ->get();

        // Fetch the student's enrolled group IDs
        $studentGroups = GroupStudent::where('student_id', $student->id)->pluck('group_id');

        // Fetch Course Paths that belong to courses where the student is in one of the groups
        $allCoursePaths = CoursesPath::with([
            'course.groups',   // load groups related to the course
            'paths.lessons'    // load lessons for each PathOfPath
        ])->whereHas('course.groups', function ($query) use ($studentGroups) {
            $query->whereIn('id', $studentGroups);
        })->get();

        // Now, determine finished paths (i.e. those whose lessons’ schedules are all in the past)
        $finishedCourses = collect();

        foreach ($allCoursePaths as $coursePath) {
            // Filter the child paths (PathOfPath)
            $finishedChildPaths = $coursePath->paths->filter(function ($childPath) use ($studentGroups) {
                // Get all lesson IDs for this child path
                $lessonIds = $childPath->lessons->pluck('id');
                if ($lessonIds->isEmpty()) {
                    return false; // No lessons means we ignore this path
                }
                // Get all schedules for these lessons, but only for the student's groups
                $schedules = GroupSchedule::whereIn('lesson_id', $lessonIds)
                    ->whereIn('group_id', $studentGroups)
                    ->get();
                if ($schedules->isEmpty()) {
                    return false; // If there are no schedules at all, do not mark it as finished
                }
                // Check that every schedule is in the past
                foreach ($schedules as $schedule) {
                    if (Carbon::parse($schedule->date)->greaterThanOrEqualTo(now())) {
                        return false; // Found at least one schedule that is not yet past
                    }
                }
                return true; // All schedules are in the past, so the path is finished
            });

            if ($finishedChildPaths->isNotEmpty()) {
                // Attach the finished child paths to the course path
                $coursePath->finishedPaths = $finishedChildPaths;
                $finishedCourses->push($coursePath);
            }
        }
        $enrolledCourses = CourseStudent::with('course.instructor')
            ->where('student_id', $student->id)
            ->whereDoesntHave('course.groups.students', function ($query) use ($student) {
                $query->where('student_id', $student->id);
            })
            ->get();
        // Run this to confirm finished courses structure before rendering:

        // Ensure paths with remaining scheduled lessons are kept
        $upcomingCourses = $allCoursePaths->map(function ($coursePath) {
            // Retrieve only PathOfPaths that have scheduled lessons in the future
            $filteredChildPaths = $coursePath->paths->map(function ($childPath) {
                $upcomingLessons = collect(); // Initialize empty collection

                foreach ($childPath->lessons as $lesson) {
                    // Check if this lesson has any future schedule
                    $scheduledLessons = GroupSchedule::where('lesson_id', $lesson->id)
                        ->where('date', '>', now())
                        ->exists();

                    if ($scheduledLessons) {
                        $upcomingLessons->push($lesson);
                    }
                }

                // Keep this child path only if it has upcoming lessons
                if ($upcomingLessons->isNotEmpty()) {
                    $childPath->filteredLessons = $upcomingLessons;
                    return $childPath;
                }

                return null;
            })->filter();

            // Keep course paths that have at least one valid path with upcoming lessons
            if ($filteredChildPaths->isNotEmpty()) {
                $coursePath->filteredPaths = $filteredChildPaths;
                return $coursePath;
            }

            return null;
        })->filter();
        return view('student.enrolled-courses', compact(
            'groupCourses',
            'enrolledCourses',
            'finishedCourses',
            'upcomingCourses',
            'student'
        ));
    }






    public function mySummary()
    {

        $student = Auth::guard('student')->user(); // Assuming 'student' guard is used
        // Fetch groups the student is enrolled in
        $groups = \App\Models\Group::whereHas('students', function ($query) use ($student) {
            $query->where('student_id', $student->id);
        })->with(['course', 'schedules.lesson', 'schedules.group'])->get();

        // Extract unique courses from the student's groups
        $courses = $groups->pluck('course')->unique();


        $student = Auth::guard('student')->user();
        // $courses = StudentEnrollment::where('student_id', $student->id)->count();
        return view('student.dashboard', compact('student', 'courses', 'groups'));
    }

    public function getTasks(Request $request, Test $test)
    {
        $student = Auth::guard('student')->user();
        $tasks = StudentTask::where('student_id', $student->id)->get();
        return view('student.my-quizz', compact('student', 'tasks'));
    }
}
