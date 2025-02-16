<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SurveyController;
use App\Http\Middleware\RoleMiddleware;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Public Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [PortalController::class, 'homePage'])->name('home');
Route::get('/course-details', function () { return view('student.course-details'); });
Route::get('/view-course', function () { return view('student.active'); });
Route::get('/message', function () { return view('student.message'); });

/*
|--------------------------------------------------------------------------
| Authentication Routes
|--------------------------------------------------------------------------
*/
Route::get('/admin-login', [AuthController::class, 'showAdminLoginForm'])->name('admin-login');
Route::post('/admin-login', [AuthController::class, 'adminLogin'])->name('admin-login');
Route::get('/login', [AuthController::class, 'showStudentLoginForm'])->name('login');
Route::post('register', [AuthController::class, 'register'])->name('register');
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
    Route::get('/admin-dashboard', function () { return view('dashboard.admin'); });
    Route::get('/admin-courses', [AdminController::class, 'index'])->name('admin-courses');
    Route::get('/admin/profile', function () { return view('dashboard.profile'); });
    Route::get('/admin/settings', function () { return view('dashboard.settings'); });
    Route::get('/course_details/{id}', [AdminController::class, 'courseDetail'])->name('admin_course_details');
    Route::post('/create-course', [AdminController::class, 'createCourse'])->name('create-course');
    Route::get('/create-course', [AdminController::class, 'createCourse'])->name('create-course');
Route::get('/activate-course', function () { return view('dashboard.activate-course'); })->name('activate-course');

});

// Store lesson
Route::post('/lesson/store', [LessonController::class, 'storeLesson'])->name('lesson.store');

// Upload material to a lesson
Route::post('/lesson/upload-material', [LessonController::class, 'uploadMaterial'])->name('lesson.uploadMaterial');

// Assign teacher to course
Route::post('/course/assign-teacher', [CourseController::class, 'assignTeacher'])->name('course.assignTeacher');

/*
|--------------------------------------------------------------------------
| Student Routes (Protected)
|--------------------------------------------------------------------------
*/
Route::middleware('auth:student')->group(function () {
    Route::get('/my-progress', [StudentController::class, 'mySummary'])->name('my-progress');
    Route::get('/profile', [StudentController::class, 'profile'])->name('student-profile');
    Route::get('/student-courses', [StudentController::class, 'getCourses'])->name('student-courses');
    Route::get('/my-quizz', [StudentController::class, 'getTasks'])->name('my-quizz');
    Route::get('/my-tasks', [StudentController::class, 'myQuizes'])->name('my-tasks');
    Route::get('/test/{id}', [StudentController::class, 'show'])->name('view-test');
    Route::post('/test/{id}/submit', [StudentController::class, 'submitTest'])->name('submit-test');
    Route::get('/test/{id}/results', [StudentController::class, 'viewResults'])->name('test-results');
    Route::get('/student/courses', [StudentController::class, 'getCourses'])->name('student.courses');
    Route::get('/logout', [AuthController::class, 'logout'])->name('logout');
});

/*
|--------------------------------------------------------------------------
| Instructor Routes
|--------------------------------------------------------------------------
*/
Route::get('/time-table', function () { return view('instructor.timetable'); });
Route::get('/instructor/profile', function () { return view('instructor.profile'); });
Route::get('/instructor/settings', function () { return view('instructor.settings'); });
Route::get('/my-courses', function () { return view('instructor.course-details'); });
Route::get('/my-chat', function () { return view('instructor.message'); });

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
Route::get('/settings', function () { return view('student.settings'); });
Route::get('/session-details', function () { return view('student.session-details'); });
Route::get('/home', function () { return view('student.home'); });

/*
|--------------------------------------------------------------------------
| Middleware Protected Routes (Role-Based Access)
|--------------------------------------------------------------------------
*/
Route::middleware([RoleMiddleware::class])->group(function () {
    Route::get('/admin', function () { return view('dashboard.admin'); });
});
