<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\Meeting;
use App\Models\Group;
use App\Models\GroupSchedule;
use App\Models\GroupStudent;
use App\Services\ZoomService;
use Firebase\JWT\JWT;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class MeetingController extends Controller
{
    protected $zoomService;

    public function __construct(ZoomService $zoomService)
    {
        $this->zoomService = $zoomService;
    }

    /**
     * Start or retrieve a Zoom session for a lesson.
     */
    public function startSession($lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        $groupSchedule = GroupSchedule::where('lesson_id', $lessonId)->first();

        if (!$groupSchedule) {
            return redirect()->back()->with('error', 'No schedule found for this lesson.');
        }

        $group = Group::findOrFail($groupSchedule->group_id);

        // Check if a meeting already exists
        $meeting = Meeting::where('lesson_id', $lessonId)->where('status', 'live')->first();

        if (!$meeting) {
            // Create new Zoom meeting using Zoom API
            $zoomMeeting = $this->zoomService->createMeeting(
                $lesson->title,
                now()->addMinutes(1)->toIso8601String(),
                60
            );

            $meeting = Meeting::create([
                'zoom_meeting_id' => $zoomMeeting['id'],
                'topic' => $lesson->title,
                'start_time' => $zoomMeeting['start_time'],
                'duration' => $zoomMeeting['duration'],
                'join_url' => $zoomMeeting['join_url'],
                'lesson_id' => $lesson->id,
                'group_id' => $group->id,
                'group_schedule_id' => $groupSchedule->id,
                'status' => 'live',
            ]);
        }

        return view('student.meeting', compact('meeting', 'lesson', 'group', 'groupSchedule'));
    }

    /**
     * Show meeting details.
     */
    public function show($id)
    {
        $meeting = Meeting::with('lesson')->findOrFail($id);

        if (!$meeting->lesson) {
            return redirect()->route('student.courses')->with('error', 'Lesson not found.');
        }

        $students = GroupStudent::where('group_id', $meeting->group_id)
            ->with('student')
            ->get()
            ->map(function ($groupStudent) {
                return $groupStudent->student;
            });

        $groupSchedule = GroupSchedule::where('lesson_id', $meeting->lesson->id)->first();

        return view('student.meeting', compact('meeting', 'students', 'groupSchedule'));
    }

    /**
     * Fetch attendance dynamically
     */
    public function fetchAttendance($meetingId)
    {
        try {
            $meeting = Meeting::findOrFail($meetingId);
            
            $students = GroupStudent::where('group_id', $meeting->group_id)
                ->with('student')
                ->get()
                ->map(function ($groupStudent) use ($meeting) {
                    $student = $groupStudent->student;

                    $allSchedules = GroupSchedule::where('group_id', $meeting->group_id)
                        ->orderBy('lesson_id', 'asc')
                        ->pluck('lesson_id')
                        ->toArray();

                    $sessionIndex = array_search($meeting->lesson->id, $allSchedules);
                    $attendance = Attendance::where('student_id', $student->id)
                        ->where('course_path_id', $meeting->lesson->course_path_id)
                        ->where('path_of_path_id', $meeting->lesson->path_of_path_id)
                        ->first();

                    $isPresent = 0;
                    if ($attendance && is_array($attendance->sessions) && isset($attendance->sessions[$sessionIndex])) {
                        $isPresent = $attendance->sessions[$sessionIndex];
                    }

                    return [
                        'id' => $student->id,
                        'name' => $student->name,
                        'is_present' => (bool) $isPresent,
                    ];
                });

            return response()->json(['students' => $students], 200, [], JSON_UNESCAPED_UNICODE);

        } catch (\Exception $e) {
            \Log::error("Fetch Attendance Error: " . $e->getMessage());
            return response()->json(['error' => 'Error fetching attendance'], 500);
        }
    }

    /**
     * Handle Homework Upload.
     */
    public function uploadHomework(Request $request)
    {
        $request->validate([
            'homework' => 'required|file|mimes:pdf,docx,txt,jpg,png|max:2048',
        ]);

        $path = $request->file('homework')->store('homeworks', 'public');

        return response()->json([
            'message' => 'Homework uploaded successfully!',
            'path' => Storage::url($path)
        ]);
    }

    /**
     * Generate Zoom SDK Signature
     */
    public function generateSignature(Request $request)
    {
        $meetingNumber = $request->meetingNumber;
        $role = $request->role; // 0 for attendee, 1 for host

        $sdkKey = env('ZOOM_CLIENT_ID');
        $sdkSecret = env('ZOOM_CLIENT_SECRET');

        $time = time() * 1000 - 30000; // in milliseconds
        $data = base64_encode($sdkKey . $meetingNumber . $time . $role);
        $hash = hash_hmac('sha256', $data, $sdkSecret, true);
        $signature = base64_encode($sdkKey . "." . $meetingNumber . "." . $time . "." . $role . "." . base64_encode($hash));

        return response()->json(['signature' => rtrim($signature, '=')]);
    }
}
