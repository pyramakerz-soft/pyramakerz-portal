<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\GroupStudent;
use App\Models\Lesson;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InstructorController extends Controller
{

    public function index()
    {
        $courses = Course::with(['coursePaths.paths', 'coursePaths.lessons'])->paginate(10);
        $categories = Category::with('courses')->get();
        $teachers = User::where('role', 'teacher')->get();
        
        return view('instructor.admin-courses', compact('courses','categories','teachers'));
    }
    
    public function viewGroups($id)
{
    // Ensure the course is fetched with groups
    $course = Course::with('groups.students')->findOrFail($id);

    // Debugging: Check if the groups are loaded

    return view('instructor.groups.index', compact('course'));
}
public function createGroup(Request $request)
{
    if (!Auth::guard('admin')->user()->can('group-create')) {
        abort(403, 'Unauthorized');
    }
    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'course_id' => 'required|exists:courses,id',
        'weekly_sessions' => 'required|integer|min:1|max:7',
        'start_date' => 'required|date',
        'start_time' => 'required',
        'end_time' => 'required',
        'session_days' => 'required|array|min:1|max:7',
        'session_days.*' => 'in:Sunday,Monday,Tuesday,Wednesday,Thursday,Friday,Saturday'
    ]);

    $course = Course::findOrFail($validatedData['course_id']);
    $courseDuration = $course->duration; // Duration in weeks

    // Create the group
    $group = Group::create([
        'name' => $validatedData['name'],
        'course_id' => $validatedData['course_id']
    ]);

    // Generate schedules using selected days
    $this->generateLessonSchedule(
        $group->id,
        $validatedData['start_date'],
        $validatedData['weekly_sessions'],
        $courseDuration,
        $validatedData['start_time'],
        $validatedData['end_time'],
        $validatedData['course_id'],
        $validatedData['session_days']
    );

    return response()->json(['message' => 'Group created and lessons scheduled!'], 200);
}


private function generateLessonSchedule($groupId, $startDate, $weeklySessions, $courseDuration, $startTime, $endTime, $courseId, $sessionDays)
{
    $startDate = Carbon::parse($startDate);
    $lessonIndex = 0;
    $totalWeeks = $courseDuration;
    
    // Fetch lessons in order for the given course
    $lessons = Lesson::whereHas('coursePath', function ($query) use ($courseId) {
                        $query->where('course_id', $courseId);
                    })
                    ->orWhereHas('pathOfPath', function ($query) use ($courseId) {
                        $query->whereHas('coursePath', function ($q) use ($courseId) {
                            $q->where('course_id', $courseId);
                        });
                    })
                    ->orderBy('order', 'asc')
                    ->get();

    if ($lessons->isEmpty()) {
        return;
    }

    $totalLessons = $lessons->count();
    $daysOfWeekMap = ["Sunday" => 0, "Monday" => 1, "Tuesday" => 2, "Wednesday" => 3, "Thursday" => 4, "Friday" => 5, "Saturday" => 6];

    $currentWeek = 0; // Track the number of weeks

    // Iterate over all lessons, ensuring proper weekly spacing
    while ($lessonIndex < $totalLessons && $currentWeek < $totalWeeks) {
        foreach ($sessionDays as $day) {
            if ($lessonIndex >= $totalLessons) break;

            $targetDate = $startDate->copy()->next($daysOfWeekMap[$day])->addWeeks($currentWeek);

            GroupSchedule::create([
                'group_id' => $groupId,
                'lesson_id' => $lessons[$lessonIndex]->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'date' => $targetDate->format('Y-m-d')
            ]);

            $lessonIndex++; // Move to the next lesson
        }

        $currentWeek++; // Move to the next week
    }
}
public function updateLessonDate(Request $request)
{
    if (!Auth::guard('admin')->user()->can('groupschedule-edit')) {
        abort(403, 'Unauthorized');
    }
    $request->validate([
        'schedule_id' => 'required|exists:group_schedules,id',
        'new_date' => 'required|date'
    ]);

    $schedule = GroupSchedule::findOrFail($request->schedule_id);
    $group = Group::find($schedule->group_id);

    // Convert dates to Carbon instances
    $oldDate = Carbon::parse($schedule->date);
    $newDate = Carbon::parse($request->new_date);
    $daysDifference = $oldDate->diffInDays($newDate, false);

    if ($daysDifference > 0) {
        // Update the single lesson if delay is less than a week
        if ($daysDifference < 7) {
            $schedule->update(['date' => $newDate]);
        } 
        // If delay is more than a week, update all future lessons and mark the group as delayed
        else {
            $group->update(['is_delayed' => 1]);

            $schedulesToUpdate = GroupSchedule::where('group_id', $group->id)
                ->where('date', '>=', $schedule->date)
                ->orderBy('date', 'asc')
                ->get();

            foreach ($schedulesToUpdate as $lessonSchedule) {
                $lessonSchedule->update(['date' => Carbon::parse($lessonSchedule->date)->addDays($daysDifference)]);
            }
        }
    }

    return response()->json(['message' => 'Lesson schedule updated successfully!'], 200);
}




public function groupDetails($id)
{
    // Fetch the group with students
    $group = Group::with('students')->findOrFail($id);

    // Pass data to the view
    return view('instructor.groups.show', compact('group'));
}

public function getStudents()
{
    $students = Student::select('id', 'name', 'email')->get();
    return response()->json(['students' => $students]);
}

public function addStudentToGroup(Request $request)
{
    // Fetch the group with its students
    $group = Group::with('students')->findOrFail($request->group_id);
    $student = Student::findOrFail($request->student_id);
    // Ensure the relationship is initialized (Fixes the 'contains on null' error)
    $group->loadMissing('students');

    // Check if student is already in the group
    if ($group->students->contains('id', $student->id)) {
        return response()->json(['message' => 'Student is already in this group!'], 400);
    }

    // Attach the student
    $group_student = new GroupStudent();
    $group_student->group_id = $group->id;
    $group_student->student_id = $student->id;
    $group_student->instructor_id = Course::find($group->course_id)->instructor_id;
    $group_student->save();
    // $group->students()->attach($student->id);

    return response()->json(['message' => 'Student added successfully!']);
}

public function courseDetail(string $id)
{
    $course = Course::with([
        'coursePaths.paths.lessons' // Load course paths, their sub-paths, and lessons
    ])->findOrFail($id);
    $teachers = User::where('role', 'teacher')->get();

    // Debugging: Check if data exists
    \Log::info('Loaded Course Data:', ['course' => $course->toArray()]);
    \Log::info('Loaded Teachers:', ['teachers' => $teachers->toArray()]);

    return view('instructor.course-details', compact('course', 'teachers'));
}

}
