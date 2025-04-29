<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CoursesPath;
use App\Models\Evaluation;
use App\Models\ManualEvaluation;
use App\Models\Meeting;
use App\Models\PathOfPath;
use App\Models\StudentToInst;
use App\Models\User;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;

class EvaluationController extends Controller
{

    public function index(Request $request)
    {
        $instructors = User::where('role', 'teacher')->get();

        // Query for Automated Evaluations
        $query = Evaluation::query();
        // Query for Manual Evaluations
        $manualQuery = ManualEvaluation::query();

        // Apply Filters
        if ($request->instructor_id) {
            $query->where('instructor_id', $request->instructor_id);
            $manualQuery->where('trainer_id', $request->instructor_id);
        }

        if ($request->date_filter) {
            $startOfWeek = Carbon::now()->startOfWeek(Carbon::SUNDAY);
            $endOfWeek = Carbon::now()->endOfWeek(Carbon::SUNDAY);
            $startOfMonth = Carbon::now()->startOfMonth();
            $endOfMonth = Carbon::now()->endOfMonth();
            $startOfYear = Carbon::now()->startOfYear();
            $endOfYear = Carbon::now()->endOfYear();

            switch ($request->date_filter) {
                case 'this_week':
                    $query->whereBetween('created_at', [$startOfWeek, $endOfWeek]);
                    $manualQuery->whereBetween('date', [$startOfWeek, $endOfWeek]);
                    break;
                case 'this_month':
                    $query->whereBetween('created_at', [$startOfMonth, $endOfMonth]);
                    $manualQuery->whereBetween('date', [$startOfMonth, $endOfMonth]);
                    break;
                case 'this_year':
                    $query->whereBetween('created_at', [$startOfYear, $endOfYear]);
                    $manualQuery->whereBetween('date', [$startOfYear, $endOfYear]);
                    break;
            }
        }

        if ($request->start_date && $request->end_date) {
            $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            $manualQuery->whereBetween('date', [$request->start_date, $request->end_date]);
        }

        if ($request->min_percentage) {
            $query->where('percentage', '>=', $request->min_percentage);
            $manualQuery->where('evaluation_percentage', '>=', $request->min_percentage);
        }

        // Fetch Data
        $evaluations = $query->with('instructor')->get();
        $manualEvaluations = $manualQuery->with('trainer', 'supervisor')->get();
        $query = StudentToInst::query();
        if ($request->instructor_id) {
            $query->whereHas('meeting.group.instructor', function ($query) use ($request) {
                $query->where('id', $request->instructor_id);
            });
        }
        $student_to_inst = $query->with('meeting.group.course.instructor')->get();

        // dd($student_to_inst);

        return view('supervisor.evaluations.index', compact('evaluations', 'manualEvaluations', 'instructors', 'student_to_inst'));
    }


    public function create()
    {
        $trainers = User::where('role', 'teacher')->get();
        $programs = CoursesPath::select('name')->union(PathOfPath::select('name'))->get();

        return view('supervisor.manual_evaluation', compact('trainers', 'programs'));
    }


    public function store(Request $request)
    {
        $request->validate([
            'trainer_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'program' => 'required|string',
            'rank' => 'required|in:S,A,B,C,D,F',
            'scores' => 'required|array', // Ensure it's an array of scores
            'scores.*' => 'numeric|min:0|max:10', // Each score should be between 0-10
            'comments' => 'array|nullable',
            'comments.*' => 'nullable|string|max:255',
        ]);

        // Calculate evaluation percentage
        $totalScore = array_sum($request->scores);
        $numCriteria = count($request->scores);
        $evaluationPercentage = ($numCriteria > 0) ? round(($totalScore / ($numCriteria * 10)) * 100, 2) : 0;

        // Create the evaluation record
        ManualEvaluation::create([
            'trainer_id' => $request->trainer_id,
            'date' => $request->date,
            'program' => $request->program,
            'rank' => $request->rank,
            'setup' => $request->scores[0] ?? 10,
            'preparation' => $request->scores[1] ?? 10,
            'objectives' => $request->scores[2] ?? 10,
            'delivery_capacity' => $request->scores[3] ?? 10,
            'controlling_session' => $request->scores[4] ?? 10,
            'communication_students' => $request->scores[5] ?? 10,
            'attendance_evaluation_sheets' => $request->scores[6] ?? 10,
            'personal_impact' => $request->scores[7] ?? 10,
            'training_techniques' => $request->scores[8] ?? 10,
            'evaluation_percentage' => $evaluationPercentage,
            'supervisor_id' => Auth::guard('admin')->id(), // Fetching the logged-in supervisor ID
            'comments' => json_encode($request->comments), // Store comments as JSON
        ]);

        return response()->json(['message' => 'Evaluation recorded successfully!'], 200);
    }


    // Show the evaluation form
    public function showEvaluationForm($meetingId)
    {
        $meeting = Meeting::with('group', 'lesson')->findOrFail($meetingId);

        // Check if the session has ended
        // Combine end date and end time to create a full Carbon datetime object
        $meetingEndDateTime = Carbon::parse($meeting->date . ' ' . $meeting->end_time);

        // Check if the current time is before the meeting end time
        if (now()->lt($meetingEndDateTime)) {
            return redirect()->back()->with('error', 'You can only evaluate a completed session.');
        }
        return view('student.evaluate-session', compact('meeting'));
    }

    // Handle evaluation submission
    public function submitEvaluation(Request $request, $meeting_id)
    {
        // Validate Input
        $request->validate([
            'content_quality' => 'required|integer|min:1|max:5',
            'instructor_clarity' => 'required|integer|min:1|max:5',
            'engagement' => 'required|integer|min:1|max:5',
            'pace' => 'required|integer|min:1|max:5',
            'technology_usage' => 'required|integer|min:1|max:5',
            'overall_experience' => 'required|integer|min:1|max:5',
            'feedback' => 'nullable|string|max:1000',
        ]);

        // Ensure meeting has ended before allowing evaluation
        $meeting = Meeting::with('groupSchedule')->findOrFail($meeting_id);
        $meetingEndDateTime = Carbon::parse($meeting->groupSchedule->date . ' ' . $meeting->groupSchedule->end_time);

        if (now()->lt($meetingEndDateTime)) {
            return redirect()->back()->with('error', 'You can only evaluate a completed session.');
        }

        // Store Evaluation
        StudentToInst::create([
            'student_id' => Auth::guard('student')->user()->id,
            'meeting_id' => $meeting_id,
            'content_quality' => $request->content_quality,
            'instructor_clarity' => $request->instructor_clarity,
            'engagement' => $request->engagement,
            'pace' => $request->pace,
            'technology_usage' => $request->technology_usage,
            'overall_experience' => $request->overall_experience,
            'feedback' => $request->feedback,
        ]);

        return redirect()->route('student.time-table')->with('success', 'Evaluation submitted successfully!');
    }
    public function viewEvalComments($id)
    {
        $evaluation = ManualEvaluation::findOrFail($id);

        if (!$evaluation) {
            return response()->json([], 404);
        }

        $comments = json_decode($evaluation->comments, true) ?? [];

        $criteriaList = [
            'Setup',
            'Preparation',
            'Objectives',
            'Delivery Capacity',
            'Controlling Session',
            'Communication with Students',
            'Attendance of Evaluation Sheets',
            'Personal Impact',
            'Training Techniques'
        ];

        // Fetch supervisor name
        $supervisor = User::find($evaluation->supervisor_id)->name ?? null;

        $response = [];

        foreach ($comments as $index => $comment) {
            if (!is_null($comment) && $comment !== '') {
                $response[] = [
                    'supervisor' => $supervisor ?? 'Supervisor',
                    'criteria' => $criteriaList[$index] ?? 'Unknown Criteria',
                    'comment' => $comment,
                    'created_at' => $evaluation->created_at,
                ];
            }
        }

        return response()->json($response);
    }
}
