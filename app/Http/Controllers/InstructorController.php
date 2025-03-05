<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Course;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\GroupStudent;
use App\Models\Lesson;
use App\Models\Meeting;
use App\Models\Student;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class InstructorController extends Controller
{

    public function index()
{
    $teacherId = Auth::guard('teacher')->user()->id;

    // Fetch only courses where the teacher is assigned via a group
    $courses = Course::whereHas('groups', function ($query) use ($teacherId) {
        $query->where('instructor_id', $teacherId);
    })->with(['coursePaths.paths', 'coursePaths.lessons'])->paginate(10);

    // Fetch categories & teachers for filtering (if needed)
    $categories = Category::with('courses')->get();
    $teachers = User::where('role', 'teacher')->get();

    return view('instructor.admin-courses', compact('courses', 'categories', 'teachers'));
}

    public function zoomMeetings()
{
    // Get the authenticated instructor
    $instructor = Auth::guard('admin')->user();

    // Fetch the meetings for groups that the instructor teaches
    $meetings = \App\Models\Meeting::whereHas('group', function ($query) use ($instructor) {
        $query->where('instructor_id', $instructor->id);
    })
    ->with(['group.course', 'lesson'])
    ->orderBy('start_time', 'asc')
    ->get();

    return view('zoom.zoom-meetings', compact('meetings', 'instructor'));
}


public function profile(){
    $instructor = Auth::guard('admin')->user();
    return view('instructor.profile', compact('instructor'));
}

public function timetable()
{
    // Get the authenticated instructor
    $instructor = Auth::guard('admin')->user();

    // Fetch the groups the instructor is assigned to
    $groups = \App\Models\Group::where('instructor_id', $instructor->id)
        ->with(['course', 'schedules.lesson', 'schedules.group']) // Ensure group is loaded
        ->get();

    // Extract unique courses from the groups
    $courses = $groups->pluck('course')->unique(); 

    return view('instructor.timetable', compact('instructor', 'groups', 'courses'));
}

    

    public function showEvaluationPage($meetingId)
    {
        // Load meeting with related lesson, group (and its students) and course
        $meeting = \App\Models\Meeting::with(['lesson', 'group.students', 'group.course'])->findOrFail($meetingId);
    
        // Load evaluations for students in this group (if any)
        $evaluations = \App\Models\InstructorToStudentEvaluation::whereIn('student_id', $meeting->group->students->pluck('id'))
            ->where('course_id', $meeting->group->course->id)
            ->get();
    
        return view('instructor.post-session', compact('meeting', 'evaluations'));
    }
    

    public function evaluateSession(Request $request, $meetingId)
{
    $request->validate([
        'evaluations' => 'required|array',
        'evaluation_period_start' => 'required|date',
        'evaluation_period_end'   => 'required|date',
    ]);

    // Load the meeting with group, course, and lesson details.
    $meeting = \App\Models\Meeting::with(['group.students', 'group.course', 'lesson'])->findOrFail($meetingId);
    $courseId = $meeting->group->course->id;
    // Get course_path_id and path_of_path_id from the lesson record.
    $coursePathId = $meeting->lesson->course_path_id;
    $pathOfPathId = $meeting->lesson->path_of_path_id;

    // Define score mappings.
    $scoreMapping = [
        'Excellent'  => 10,
        'Very Good'  => 7,
        'Good'       => 5,
        'Fair'       => 2,
    ];
    $homeworkMapping = [
        'Submitted homework'     => 10,
        "Didn't submit homework" => 0,
        'No homework'            => 10,
    ];
    foreach ($request->evaluations as $studentId => $data) {
        // Get the joined date from the GroupStudent record if not provided.
        $groupStudent = \App\Models\GroupStudent::where('student_id', $studentId)
            ->where('group_id', $meeting->group->id)
            ->first();
        $joinedDate = $data['joined_at'] ?? ($groupStudent ? $groupStudent->created_at->format('Y-m-d') : null);
    
        // Check attendance status from the submitted hidden field.
        $attendanceStatus = $data['attendance'] ?? 'present';
        // Force lowercase to be safe.
        $attendanceStatus = strtolower($attendanceStatus);
    
        // Calculate scores.
        if ($attendanceStatus === 'absent') {
            $interactionScore = 0;
            $performanceScore = 0;
            $homeworkScore    = 0;
        } else {
            $interactionScore = isset($scoreMapping[$data['interaction']]) ? $scoreMapping[$data['interaction']] : 0;
            $performanceScore = isset($scoreMapping[$data['performance']]) ? $scoreMapping[$data['performance']] : 0;
            $homeworkScore    = isset($homeworkMapping[$data['homework']]) ? $homeworkMapping[$data['homework']] : 0;
        }
        $sessionScore = $interactionScore + $performanceScore + $homeworkScore;
        $sessionEvaluation = [
            'interaction'   => $attendanceStatus === 'absent' ? 'Absent' : ($data['interaction'] ?? null),
            'performance'   => $attendanceStatus === 'absent' ? 'Absent' : ($data['performance'] ?? null),
            'homework'      => $attendanceStatus === 'absent' ? 'Absent' : ($data['homework'] ?? null),
            'session_score' => $sessionScore,
            'evaluated_at'  => now()->toDateTimeString(),
            'joined_at'     => $joinedDate,
            'attendance'    => $attendanceStatus, // 'absent' or 'present'
        ];
        // Update or create the evaluation record for this student.
        $evaluation = \App\Models\InstructorToStudentEvaluation::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->when($coursePathId, function($query) use ($coursePathId) {
                return $query->where('course_path_id', $coursePathId);
            })
            ->when($pathOfPathId, function($query) use ($pathOfPathId) {
                return $query->where('path_of_path_id', $pathOfPathId);
            })
            ->first();
    
        if ($evaluation) {
            $sessions = $evaluation->evaluation_details ?? [];
            $sessions[] = $sessionEvaluation;
            $evaluation->evaluation_details = $sessions;
            $total = 0;
            foreach ($sessions as $sess) {
                $total += $sess['session_score'] ?? 0;
            }
            $evaluation->total_score = $total;
            $evaluation->evaluation_score = count($sessions) ? ($total / (count($sessions) * 30)) * 100 : null;
            $evaluation->joined_at = $joinedDate;
            $evaluation->evaluation_period_start = $request->input('evaluation_period_start');
            $evaluation->evaluation_period_end   = $request->input('evaluation_period_end');
            $evaluation->save();
        } else {
            $evaluationCode = 'pyra-' . $courseId . '-' . sprintf('%05d', $studentId);
            $sessions = [$sessionEvaluation];
            $total = $sessionScore;
            $evaluationScore = ($total / 30) * 100;
            \App\Models\InstructorToStudentEvaluation::create([
                'code'                     => $evaluationCode,
                'student_id'               => $studentId,
                'course_id'                => $courseId,
                'course_path_id'           => $coursePathId,
                'path_of_path_id'          => $pathOfPathId,
                'joined_at'                => $joinedDate,
                'evaluation_period_start'  => $request->input('evaluation_period_start'),
                'evaluation_period_end'    => $request->input('evaluation_period_end'),
                'evaluation_details'       => $sessions,
                'total_score'              => $total,
                'evaluation_score'         => $evaluationScore,
                'group_schedule_id'        => Meeting::find($meetingId)->group_schedule_id
            ]);
        }
    
        // --- Update Attendance for this student ---
    
        // Get all schedules for the group (across all lessons) ordered by date and start time.
        $orderedSchedules = \App\Models\GroupSchedule::where('group_id', $meeting->group->id)
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();
    
        // Find the index of the current session using the meeting's group_schedule_id.
        $currentSessionIndex = $orderedSchedules->search(function ($schedule) use ($meeting) {
            return $schedule->id == $meeting->group_schedule_id;
        });
        if ($currentSessionIndex === false) {
            $currentSessionIndex = 0;
        }
    
        // Determine current attendance value: 0 if absent, 1 if present.
        $currentValue = ($attendanceStatus === 'absent') ? 0 : 1;
    
        // Retrieve the attendance record for this student.
        $attendance = \App\Models\Attendance::where('student_id', $studentId)
            ->where('course_id', $courseId)
            ->when($coursePathId, function($query) use ($coursePathId) {
                return $query->where('course_path_id', $coursePathId);
            })
            ->when($pathOfPathId, function($query) use ($pathOfPathId) {
                return $query->where('path_of_path_id', $pathOfPathId);
            })
            ->first();
    
        if ($attendance) {
            $attendanceSessions = is_string($attendance->sessions)
                ? json_decode($attendance->sessions, true)
                : ($attendance->sessions ?? []);
            // Fill in missing indices up to the current session index with 0.
            for ($i = 0; $i <= $currentSessionIndex; $i++) {
                if (!array_key_exists($i, $attendanceSessions)) {
                    $attendanceSessions[$i] = 0;
                }
            }
            // Set the current session's value.
            $attendanceSessions[$currentSessionIndex] = $currentValue;
            ksort($attendanceSessions);
            $attendance->sessions = json_encode($attendanceSessions, JSON_FORCE_OBJECT);
            $attendance->save();
        } else {
            // Create a new attendance record.
            $newSessions = [];
            for ($i = 0; $i <= $currentSessionIndex; $i++) {
                $newSessions[$i] = 0;
            }
            $newSessions[$currentSessionIndex] = $currentValue;
            $attendance = new \App\Models\Attendance();
            $attendance->user_id = Auth::guard('admin')->user()->id;
            $attendance->student_id = $studentId;
            $attendance->course_id = $courseId;
            $attendance->course_path_id = $coursePathId;
            $attendance->path_of_path_id = $pathOfPathId;
            $attendance->day = \Carbon\Carbon::parse($meeting->start_time)->format('l');
            $attendance->time = \Carbon\Carbon::parse($meeting->start_time)->format('H:i:s');
            $attendance->status = 'Online';
            $attendance->sessions = json_encode($newSessions, JSON_FORCE_OBJECT);
            $attendance->save();
        }
    }
    







    
    return redirect()->back()->with('success', 'Evaluations saved successfully!');
}

    



    public function instructorMeeting($id)
    {
        // Load meeting along with its group and lesson relationships.
        $meeting = \App\Models\Meeting::with(['group.students', 'lesson'])->findOrFail($id);
    
        // Extract the group from the meeting.
        $group = $meeting->group;
    
        // Pass both $meeting and $group to the view.
        return view('instructor.meeting', compact('meeting', 'group'));
    }
    
    public function updateAttendance(Request $request)
    {
        // Validate request
        $validated = $request->validate([
            'student_id' => 'required|exists:students,id',
            'status'     => 'required|in:0,1',
            'meeting_id' => 'required|exists:meetings,id',
        ]);
    
        // Retrieve the meeting details
        $meeting = \App\Models\Meeting::findOrFail($validated['meeting_id']);
        
        // Retrieve lesson details (to get course_path_id & path_of_path_id)
        $lesson = \App\Models\Lesson::find($meeting->lesson_id);
        $coursePathId = $lesson ? $lesson->course_path_id : null;
        $pathOfPathId = $lesson ? $lesson->path_of_path_id : null;
    
        // Retrieve the group and course information
        $group = \App\Models\Group::where('id', $meeting->group_id)->first();
    
        if (!$group) {
            return response()->json(['success' => false, 'message' => 'Group not found for this meeting'], 400);
        }
    
        $courseId = $group->course_id;
    
        // Find existing attendance record
        $attendance = \App\Models\Attendance::where('student_id', $validated['student_id'])
            ->where('course_id', $courseId)
            ->when($coursePathId, fn($q) => $q->where('course_path_id', $coursePathId))
            ->when($pathOfPathId, fn($q) => $q->where('path_of_path_id', $pathOfPathId))
            ->first();
    
        // Get session index based on group schedule order
        $scheduleSessions = $group->schedules->pluck('id')->toArray();
        $currentSessionIndex = array_search($meeting->group_schedule_id, $scheduleSessions);
    
        if ($currentSessionIndex === false) {
            return response()->json(['success' => false, 'message' => 'Invalid session index'], 400);
        }
    
        if ($attendance) {
            // Parse existing sessions
            $attendanceSessions = is_string($attendance->sessions)
                ? json_decode($attendance->sessions, true)
                : ($attendance->sessions ?? []);
    
            // Ensure all previous sessions have values
            for ($i = 0; $i <= $currentSessionIndex; $i++) {
                if (!array_key_exists($i, $attendanceSessions)) {
                    $attendanceSessions[$i] = 0;
                }
            }
    
            // Update attendance for the current session
            $attendanceSessions[$currentSessionIndex] = (int) $validated['status'];
    
            // Save back to database
            $attendance->sessions = json_encode($attendanceSessions, JSON_FORCE_OBJECT);
            $attendance->save();
        } else {
            // Create new attendance record
            $newSessions = [];
            for ($i = 0; $i <= $currentSessionIndex; $i++) {
                $newSessions[$i] = 0;
            }
    
            $newSessions[$currentSessionIndex] = (int) $validated['status'];
    
            $attendance = \App\Models\Attendance::create([
                'user_id'         => Auth::guard('admin')->user()->id,
                'student_id'      => $validated['student_id'],
                'course_id'       => $courseId,
                'course_path_id'  => $coursePathId,
                'path_of_path_id' => $pathOfPathId,
                'day'             => \Carbon\Carbon::parse($meeting->start_time)->format('l'),
                'time'            => \Carbon\Carbon::parse($meeting->start_time)->format('H:i:s'),
                'status'          => 'Online',
                'sessions'        => json_encode($newSessions, JSON_FORCE_OBJECT),
            ]);
        }
    
        return response()->json(['success' => true, 'message' => 'Attendance updated successfully!']);
    }
    
public function viewHomework(Request $request)
{
    $validated = $request->validate([
        'student_id' => 'required|exists:students,id',
        'meeting_id' => 'required|exists:meetings,id',
    ]);

    // Retrieve the homework record for the student in this meeting.
    // Adjust the logic according to your database schema.
    $homework = \App\Models\Homework::where('student_id', $validated['student_id'])
        ->where('meeting_id', $validated['meeting_id'])
        ->first();

    if ($homework) {
        // You can return an HTML snippet, or a URL to view the homework.
        return response()->json(['homework' => view('instructor.partials.homework_view', compact('homework'))->render()]);
    }

    return response()->json(['homework' => null]);
}

    public function viewGroups($id)
{
    // Ensure the course is fetched with groups
    $course = Course::with('groups.students')->findOrFail($id);
    $instructors = User::where('role', 'teacher')->get();
    // Debugging: Check if the groups are loaded

    return view('instructor.groups.index', compact('course','instructors'));
}
public function createGroup(Request $request)
{
    if (!Auth::guard('admin')->user()->can('group-create')) {
        abort(403, 'Unauthorized');
    }

    $validatedData = $request->validate([
        'name' => 'required|string|max:255',
        'instructor_id' => 'required|exists:users,id',
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

    // ✅ Create the group
    $group = Group::create([
        'name' => $validatedData['name'],
        'course_id' => $validatedData['course_id'],
        'instructor_id' => $validatedData['instructor_id'],
    ]);

    // ✅ Generate schedules using selected days
    $this->generateLessonSchedule(
        $group->id,
        $validatedData['start_date'],
        $validatedData['weekly_sessions'],
        $courseDuration,
        $validatedData['start_time'],
        $validatedData['end_time'],
        $validatedData['course_id'], // ✅ Pass course_id correctly
        $validatedData['session_days']
    );

    return response()->json(['message' => 'Group created and lessons scheduled!'], 200);
}

private function generateLessonSchedule($groupId, $startDate, $weeklySessions, $courseDuration, $startTime, $endTime, $courseId, $sessionDays)
{
    $startDate = Carbon::parse($startDate);
    $totalWeeks = $courseDuration;
    $scheduledSessions = 0;

    // ✅ Fetch lessons in proper track order
    $lessons = Lesson::whereHas('coursePath', function ($query) use ($courseId) {
                        $query->where('course_id', $courseId);
                    })
                    ->orWhereHas('pathOfPath', function ($query) use ($courseId) {
                        $query->whereHas('coursePath', function ($q) use ($courseId) {
                            $q->where('course_id', $courseId);
                        });
                    })
                    ->orderBy('course_path_id')
                    ->orderBy('path_of_path_id')
                    ->orderBy('order')
                    ->get();

    if ($lessons->isEmpty()) {
        Log::warning("⚠ No lessons found for course ID: $courseId");
        return;
    }

    $daysOfWeekMap = [
        "Sunday" => 0, "Monday" => 1, "Tuesday" => 2,
        "Wednesday" => 3, "Thursday" => 4, "Friday" => 5, "Saturday" => 6
    ];

    $lessonIndex = 0;  // Track lessons assigned
    $currentDate = $startDate->copy(); // Keep a copy of the start date

    for ($week = 0; $week < $totalWeeks; $week++) {
        foreach ($sessionDays as $day) {
            if ($lessonIndex >= $lessons->count()) break; // Stop if all lessons are scheduled
            
            // ✅ Move to the next correct session day
            if ($currentDate->dayOfWeek != $daysOfWeekMap[$day]) {
                $currentDate = $currentDate->next($daysOfWeekMap[$day]);
            }

            // ✅ Assign lesson to this day
            GroupSchedule::create([
                'group_id' => $groupId,
                'lesson_id' => $lessons[$lessonIndex]->id,
                'start_time' => $startTime,
                'end_time' => $endTime,
                'date' => $currentDate->format('Y-m-d')
            ]);

            Log::info("✅ Scheduled Lesson ID: {$lessons[$lessonIndex]->id} on {$currentDate->format('Y-m-d')}");

            $lessonIndex++; // Move to next lesson
            $scheduledSessions++;

            // ✅ Move to the next week after finishing the last session day
            if ($scheduledSessions % $weeklySessions == 0) {
                $currentDate->addWeek(); 
                $currentDate = $currentDate->next($daysOfWeekMap[$sessionDays[0]]);
            }
        }
    }

    Log::info("🟢 Lesson scheduling completed for Group ID: $groupId");
}



public function rescheduleGroupsForCourse(Request $request, $courseId)
{
    // Get all groups for the course.
    $groups = Group::where('course_id', $courseId)->get();

    // Fetch all lessons for the course, ordered as needed.
    $lessons = Lesson::where('course_id', $courseId)
                ->orderBy('order', 'asc')
                ->get();

    foreach ($groups as $group) {
        // Get IDs of lessons already scheduled for this group.
        $scheduledLessonIds = GroupSchedule::where('group_id', $group->id)
                                    ->pluck('lesson_id')
                                    ->toArray();

        // Determine session days: you can retrieve this from existing schedules or define a default.
        $sessionDays = [];
        $schedules = GroupSchedule::where('group_id', $group->id)->get();
        foreach ($schedules as $schedule) {
            $sessionDays[] = Carbon::parse($schedule->date)->format('l');
        }
        if (empty($sessionDays)) {
            // Default to a specific day if no session days are set.
            $sessionDays[] = 'Monday';
        }

        // Determine the last scheduled date; use group's start date or today as a fallback.
        $lastDateString = GroupSchedule::where('group_id', $group->id)
                            ->orderBy('date', 'desc')
                            ->value('date');
        $start_time = GroupSchedule::where('group_id', $group->id)
                            ->orderBy('date', 'desc')
                            ->value('start_time');
        $end_time = GroupSchedule::where('group_id', $group->id)
                            ->orderBy('date', 'desc')
                            ->value('end_time');
        $lastDate = $lastDateString ? Carbon::parse($lastDateString) : Carbon::today();

        // Define default start and end times.
        // Alternatively, if lessons have a 'lesson_time', you might use that.
        $defaultStartTime = '07:00:00';
        $defaultEndTime   = '08:00:00';

        // Iterate over lessons and schedule any that are not yet scheduled.
        foreach ($lessons as $lesson) {
            if (in_array($lesson->id, $scheduledLessonIds)) {
                continue; // Skip already scheduled lessons.
            }

            // Calculate the next valid date based on the session days.
            $nextDate = $lastDate->copy()->addDay();
            while (!in_array($nextDate->format('l'), $sessionDays)) {
                $nextDate->addDay();
            }

            // Create the new schedule entry.
            GroupSchedule::create([
                'group_id'   => $group->id,
                'lesson_id'  => $lesson->id,
                'start_time' => $start_time, // Ensure this is not null.
                'end_time'   => $end_time,
                'date'       => $nextDate->format('Y-m-d'),
            ]);

            // Update lastDate for subsequent scheduling.
            $lastDate = $nextDate;
        }
    }

    return response()->json(['message' => 'Group schedules updated with new lessons!'], 200);
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
        'coursePaths.paths.lessons.resources'  // Eager load each lesson's resources
    ])->findOrFail($id);
    $teachers = User::where('role', 'teacher')->get();

    \Log::info('Loaded Course Data:', ['course' => $course->toArray()]);
    \Log::info('Loaded Teachers:', ['teachers' => $teachers->toArray()]);

    return view('instructor.course-details', compact('course', 'teachers'));
}
public function createMeetingsForGroup(Request $request, $groupId)
{
    // Retrieve the group with its schedules and associated lessons
    $group = \App\Models\Group::with(['schedules.lesson'])->findOrFail($groupId);

    // Validate that there are no duplicate sessions on the same date and start time.
    $sessionKeys = [];
    foreach ($group->schedules as $schedule) {
        $key = $schedule->date . ' ' . $schedule->start_time;
        if (isset($sessionKeys[$key])) {
            return redirect()->back()->with('error', 'Duplicate session found for date and time: ' . $key);
        }
        $sessionKeys[$key] = true;
    }

    $zoomService = new \App\Services\ZoomService();
    $createdCount = 0;

    foreach ($group->schedules as $schedule) {
        // Skip if a meeting was already created for this schedule
        if ($schedule->meeting_id) {
            continue;
        }

        // Ensure that the lesson exists for this schedule
        if (!$schedule->lesson) {
            continue;
        }

        // Create a topic from the group name and lesson title
        $topic = "Group: " . $group->name . " - Lesson: " . $schedule->lesson->title;

        try {
            // Call the ZoomService to create the meeting
            $meetingData = $zoomService->createMeeting(
                $topic,
                $schedule->date,
                $schedule->start_time,
                $schedule->end_time
            );

            // Calculate the duration for storing in our meeting row
            $startDateTime = \Carbon\Carbon::parse($schedule->date . ' ' . $schedule->start_time);
            $endDateTime   = \Carbon\Carbon::parse($schedule->date . ' ' . $schedule->end_time);
            $duration = $startDateTime->diffInMinutes($endDateTime);

            // Create a meeting row in the meetings table
            $meetingRow = new \App\Models\Meeting();
            $meetingRow->zoom_meeting_id = $meetingData['id'] ?? null;
            $meetingRow->topic           = $topic;
            $meetingRow->start_time      = $startDateTime->toDateTimeString();
            $meetingRow->duration        = $duration;
            $meetingRow->join_url        = $meetingData['join_url'] ?? null;
            $meetingRow->status          = 'live'; // Or set based on $meetingData if available
            $meetingRow->lesson_id       = $schedule->lesson->id;
            $meetingRow->group_id        = $group->id;
            $meetingRow->group_schedule_id = $schedule->id;
            $meetingRow->save();

            // Update the group_schedule with the meeting id (foreign key to meetings table)
            $schedule->meeting_id = $meetingRow->id;
            $schedule->save();

            $createdCount++;
        } catch (\Exception $e) {
            \Log::error('Error creating Zoom meeting for lesson: ' . $schedule->lesson->title . ' - ' . $e->getMessage());
            return redirect()->back()->with('error', 'Error creating meeting: ' . $e->getMessage());
        }
    }

    return redirect()->back()->with('success', "$createdCount meeting(s) created successfully.");
}




}
