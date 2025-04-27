<?php

use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\CourseProgressController;
use App\Http\Controllers\Admin\EnrollmentController;
use App\Http\Controllers\Admin\EvaluationController;
use App\Http\Controllers\Admin\InstructorCommentController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\InstructorController;
use App\Http\Controllers\Admin\InstructorController as AdminInstructorController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\LessonResourceController;
use App\Http\Controllers\MeetingController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\Admin\StudentController as AdminStudentController;
use App\Http\Controllers\SupervisorController;
use App\Http\Controllers\SurveyController;
use App\Http\Controllers\TicketController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use App\Services\ZoomService;
use Firebase\JWT\JWT;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

Auth::routes();

Route::middleware('auth')->group(function () {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
});
Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
Route::get('/logout-admin', [AuthController::class, 'logoutAdmin'])->name('logout-admin');

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PortalController::class, 'homePage'])->name('home');
Route::get('/course-details', function () {
    return view('student.course-details');
});

Route::get('/message', function () {
    return view('student.message');
});
Route::get('/lessons', function () {
    return view('student.course-lessons');
});


/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin-login', [AuthController::class, 'showAdminLoginForm'])->name('admin-login');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin-login');
Route::get('/login', [AuthController::class, 'showStudentLoginForm'])->name('login');
Route::get('/login', [AuthController::class, 'login'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
Route::post('register-student', [AuthController::class, 'registerStudent'])->name('register-student');
Route::get('/student-login', [AuthController::class, 'showStudentLoginForm'])->name('student-login');
Route::post('/student-login', [AuthController::class, 'studentLogin'])->name('student-login');

/*
|--------------------------------------------------------------------------
| Courses & Lessons
|--------------------------------------------------------------------------
*/
Route::resource('courses', CourseController::class);
Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');
Route::get('/all-courses', [CourseController::class, 'index'])->name('courses.all');
Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.details');

/*
|--------------------------------------------------------------------------
| Admin Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('admin.auth')->group(function () {
    Route::get('/admin-dashboard', function () {
        return view('dashboard.admin');
    });
    Route::get('/admin-courses', [AdminController::class, 'index'])->name('admin-courses');
    Route::get('/admin/profile', function () {
        return view('dashboard.profile');
    });
    Route::get('/admin/settings', function () {
        return view('dashboard.settings');
    })->name('admin-settings');
    Route::post('/create-course', [AdminController::class, 'createCourse'])->name('create-course');
    Route::get('/create-course', [AdminController::class, 'createCourse'])->name('create-course');
    Route::post('/lesson-schedule', [LessonController::class, 'scheduleLesson'])->name('lesson.schedule');
    Route::get('/activate-course', function () {
        return view('dashboard.activate-course');
    })->name('activate-course');
});

// Store lesson
Route::post('/lesson/store', [LessonController::class, 'storeLesson'])->name('lesson.store');

// Upload material to a lesson
Route::post('/lesson/upload-material', [LessonController::class, 'uploadResource'])->name('lesson.uploadMaterial');

// Assign teacher to course
Route::post('/course/assign-teacher', [CourseController::class, 'assignTeacher'])->name('course.assignTeacher');

/*
|--------------------------------------------------------------------------
| Student Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:student')->group(function () {
    // Route::get('/time-table', [StudentController::class, 'timetable'])->name('time-table');
    Route::get('/settings/{id}', [AuthController::class, 'settings'])->name('student-settings');
    Route::post('/update-data', [AuthController::class, 'updateData'])->name('update-data');
    Route::put('/change-password', [AuthController::class, 'changePassword'])->name('change-password');
    Route::get('/my-progress', [StudentController::class, 'mySummary'])->name('my-progress');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student-profile');
    Route::get('/student-courses', [StudentController::class, 'getCourses'])->name('student-courses');
    Route::get('/my-quizz', [StudentController::class, 'getTasks'])->name('my-quizz');
    Route::get('/my-tasks', [StudentController::class, 'myQuizes'])->name('my-tasks');
    Route::get('/test/{id}', [StudentController::class, 'show'])->name('view-test');
    Route::post('/test/{id}/submit', [StudentController::class, 'submitTest'])->name('submit-test');
    Route::get('/test/{id}/results', [StudentController::class, 'viewResults'])->name('test-results');
    Route::get('/student/courses', [StudentController::class, 'getCourses'])->name('student.courses');
    Route::get('/course_lessons/{id}', [StudentController::class, 'showCourseLessons'])->name('course_lessons');
    Route::get('/meetings/{id}', [MeetingController::class, 'show'])->name('meetings.show');
    Route::post('/upload-homework', [MeetingController::class, 'uploadHomework'])->name('homework.upload');
    Route::get('/fetch-attendance/{meeting}', [MeetingController::class, 'fetchAttendance'])->name('attendance.fetch');
    Route::get('/zoom-signature', [MeetingController::class, 'generateSignature'])->name('zoom.signature');
    Route::get('/zoom-signature/{meetingNumber}/{role}', [MeetingController::class, 'generateSignature'])->name('zoom.signature');
    Route::get('/time-table', [StudentController::class, 'timetable'])->name('student.time-table');
    Route::get('/join-now', [CourseController::class, 'studentJoinNow'])->name('student.join-now');
    Route::get('/enroll-now/{id}', [CourseController::class, 'enrollNow'])->name('student.enroll-now');
    Route::get('/meetings/{meeting}/evaluate_inst', [EvaluationController::class, 'showEvaluationForm'])
        ->middleware(['auth:student'])
        ->name('meetings.evaluate');

    Route::post('/meetings/{meeting}/evaluate_inst', [EvaluationController::class, 'submitEvaluation'])
        ->middleware(['auth:student'])
        ->name('meetings.evaluate.submit');
});


// Route::get('/zoom/generate-signature/{meeting_id}', function ($meetingId) {
//     try {
//         $clientId = env('ZOOM_CLIENT_ID');
//         $clientSecret = env('ZOOM_CLIENT_SECRET');
//         $accountId = env('ZOOM_ACCOUNT_ID');

//         if (!$clientId || !$clientSecret) {
//             Log::error('Zoom credentials are missing.');
//             return response()->json(['error' => 'Zoom credentials missing'], 500);
//         }

//         // Request OAuth Token using the correct grant type
//         $response = Http::asForm()->post('https://zoom.us/oauth/token', [
//             'grant_type' => 'client_credentials', // ✅ Corrected Grant Type
//             'client_id' => $clientId,
//             'client_secret' => $clientSecret,
//         ]);

//         if ($response->failed()) {
//             Log::error('Failed to obtain Zoom access token.', ['response' => $response->body()]);
//             return response()->json([
//                 'error' => 'Failed to obtain Zoom access token',
//                 'details' => $response->json()
//             ], 500);
//         }

//         $accessToken = $response->json()['access_token'];

//         // Generate JWT Signature for Zoom SDK
//         $currentTime = time();
//         $payload = [
//             'sdkKey' => $clientId,
//             'mn' => $meetingId,
//             'role' => 0,
//             'iat' => $currentTime,
//             'exp' => $currentTime + 3600,
//             'tokenExp' => $currentTime + 3600
//         ];

//         $signature = JWT::encode($payload, $clientSecret, 'HS256');

//         return response()->json(['signature' => $signature]);

//     } catch (\Exception $e) {
//         Log::error('Error generating Zoom signature:', ['exception' => $e->getMessage()]);
//         return response()->json(['error' => 'Exception occurred', 'details' => $e->getMessage()], 500);
//     }
// })->name('zoom.generate_signature');

// routes/web.php or routes/api.php
Route::get('/zoom/generate-signature', [App\Http\Controllers\MeetingController::class, 'generateSignature'])->name("zoom.generate_signature");
Route::get('/zoom/generate-host-signature', [App\Http\Controllers\MeetingController::class, 'generateHostSignature'])->name("zoom.generate_host_signature");


/*
|--------------------------------------------------------------------------
| Supervisor Routes
|--------------------------------------------------------------------------
*/
Route::prefix('supervisor')->middleware('admin.auth')->group(function () {
    Route::get('/instructor_del/{id}', [AdminInstructorController::class, 'deleteInstructor'])->name('admin.instructor.delete');
    Route::post('/instructors/comment', [InstructorCommentController::class, 'store'])->name('admin.instructors.comment');
    Route::get('/instructors/comments/{instructor_id}', [InstructorCommentController::class, 'getComments'])->name('admin.instructors.get_comments');
    Route::put('/admin/instructors/comment/{id}', [InstructorCommentController::class, 'updateComment'])->name('admin.instructors.updateComment');;
    Route::delete('/admin/instructors/comment/{id}', [InstructorCommentController::class, 'deleteComment'])->name('admin.instructors.deleteComment');;

    Route::get('/instructors', [AdminInstructorController::class, 'index'])->name('admin.instructors.index');
    Route::post('/instructors/store', [AdminInstructorController::class, 'store'])->name('admin.instructors.store');
    Route::post('/instructors/import', [AdminInstructorController::class, 'import'])->name('admin.instructors.import');
    Route::put('/instructors/update/{id}', [AdminInstructorController::class, 'update'])->name('admin.instructors.update');
    Route::get('/evaluations', [EvaluationController::class, 'index'])->name('admin.evaluations.index');
    Route::get('/lesson-resources', [LessonResourceController::class, 'index'])->name('admin.lesson-resources.index');
    Route::delete('/lesson-resources/{id}', [LessonResourceController::class, 'destroy'])->name('admin.lesson-resources.destroy');

    Route::get('/evaluations/manual', [EvaluationController::class, 'create'])->name('admin.evaluations.manual');
    Route::post('/evaluations/store', [EvaluationController::class, 'store'])->name('admin.evaluations.store');
    Route::get('/track-progress', [CourseProgressController::class, 'index'])->name('admin.track-progress.index');
    Route::get('/attendance', [AttendanceController::class, 'index'])->name('admin.attendance.index');
    Route::get('/enrollment_requests', [EnrollmentController::class, 'index'])->name('admin.enrollment_requests');
    Route::post('/approve/{id}', [EnrollmentController::class, 'approve'])->name('admin.approve');
    Route::post('/reject/{id}', [EnrollmentController::class, 'reject'])->name('admin.reject');
    Route::get('/tickets', [TicketController::class, 'index'])->name('admin.tickets');

    // Route::get('/student-details/{id}', [AttendanceController::class, 'studentDetails'])->name('admin.student-details');
    Route::get('/students', [AdminStudentController::class, 'index'])->name('admin.students.index');
    Route::post('/students/import', [AdminStudentController::class, 'import'])->name('admin.students.import');
    Route::get('/students/download-template', [AdminStudentController::class, 'downloadTemplate'])
        ->name('admin.students.download-template');
    Route::post('/admin/students/assign-group', [AdminStudentController::class, 'assignGroup'])->name('admin.students.assign-group');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/
Route::get('/student-details', function () {
    return view('general.student-details');
});

// Route::get('/session-details', function () {
//     return view('general.session-details');
// });
Route::get('/student-details/{student_id}/{id}', [AdminController::class, 'sessionDetailsForStudent'])->name('sessionDetailsForStudent');
Route::get('/session-details/{id}', [AdminController::class, 'sessionDetails'])->name('session-details');
Route::prefix('instructor')->middleware('admin.auth')->group(function () {

    Route::get('/profile', [InstructorController::class, 'profile'])->name('instructor.profile');
    Route::get('/time-table', [InstructorController::class, 'timetable'])->name('instructor.time-table');
    Route::get('/zoom_meetings', [InstructorController::class, 'zoomMeetings'])->name('instructor.zoom_meetings');
    Route::get('/course_details/{id}', [InstructorController::class, 'courseDetail'])->name('instructor.course_details');
    Route::get('/course/{id}/groups', [InstructorController::class, 'viewGroups'])
        ->name('instructor.groups');
    Route::post('/lesson/update-date', [InstructorController::class, 'updateLessonDate'])->name('lesson.update_date');

    Route::get('/students', [InstructorController::class, 'getStudents'])
        ->name('instructor.get_students');

    Route::post('/group/add-student', [InstructorController::class, 'addStudentToGroup'])
        ->name('instructor.add_student');


    Route::post('/group/create', [InstructorController::class, 'createGroup'])
        ->name('instructor.create_group');

    Route::get('/group/{id}', [InstructorController::class, 'groupDetails'])
        ->name('instructor.group_details');

    Route::get('/courses', [InstructorController::class, 'index'])
        ->name('instructor.courses');

    Route::get('/meetings/{id}', [InstructorController::class, 'instructorMeeting'])->name('instructor.meeting');

    // Routes for AJAX endpoints used by the instructor page:
    Route::post('/attendance/update', [InstructorController::class, 'updateAttendance'])->name('instructor.attendance.update');
    Route::get('/homework/view', [InstructorController::class, 'viewHomework'])->name('instructor.homework.view');

    Route::post('/meetings/create-all/{group}', [InstructorController::class, 'createMeetingsForGroup'])
        ->name('instructor.meetings.create_all');
    Route::post('/course/{courseId}/reschedule', [InstructorController::class, 'rescheduleGroupsForCourse'])
        ->name('instructor.reschedule_groups');


    // Display the evaluation page for a meeting
    Route::get('/meetings/{meeting}/evaluate', [InstructorController::class, 'showEvaluationPage'])
        ->name('instructor.evaluate_page');

    // Handle evaluation submission for a meeting
    Route::post('/meetings/{meeting}/evaluate', [InstructorController::class, 'evaluateSession'])
        ->name('instructor.evaluate_session');
});

// Route::get('/time-table', function () {
//     return view('student.timetable');
// });
// Route::get('/instructor/profile', function () { return view('instructor.profile'); });
Route::get('/instructor/settings', function () {
    return view('instructor.settings');
});
Route::get('/my-courses', function () {
    return view('instructor.course-details');
});
Route::get('/my-chat', function () {
    return view('instructor.message');
})->name('instructor-chat');

/*
|--------------------------------------------------------------------------
| Survey Routes
|--------------------------------------------------------------------------
*/
Route::get('/survey/{id}', [SurveyController::class, 'showSurvey'])->name('show_survey');
Route::post('/survey/{id}', [SurveyController::class, 'submitSurvey'])->name('submit_survey');

/*
|--------------------------------------------------------------------------
| Miscellaneous Routes
|--------------------------------------------------------------------------
*/
// Route::get('/settings', function () {
//     return view('student.settings');
// })->name('student-settings');
Route::get('/home', function () {
    return view('student.home');
});

/*
|--------------------------------------------------------------------------
| Middleware Protected Routes (Role-Based Access)
|--------------------------------------------------------------------------
*/
Route::middleware([RoleMiddleware::class])->group(function () {
    Route::get('/admin', function () {
        return view('dashboard.admin');
    });
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::post('/ticket', [TicketController::class, 'store'])
    ->name('ticket.store')
    ->middleware('auth:student');
