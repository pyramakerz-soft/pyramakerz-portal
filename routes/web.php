<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\CourseController;
use App\Http\Controllers\LessonController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
// Route::get('/', function () {
//     return view('welcome');
// });
Route::get('/', [PortalController::class, 'homePage'])->name('home');
// Route::get('/home', function () {
//     return view('home');
// });
// Route::get('/create-course', function () {
//     return view('dashboard.create-course');
// });
Route::resource("courses", CourseController::class);
Route::post('/lessons', [LessonController::class, 'store'])->name('lessons.store');


Route::get('/activate-course', function () {
    return view('dashboard.activate-course');
})->name('course.details');

Route::get('/admin', function () {
    return view('dashboard.admin');
});

Route::get('/admin-courses', function () {
    return view('dashboard.admin-courses');
});


// student routes

// Route::get('/student-login', function () {
//     return view('auth.student-login');
// });

// Route::get('/my-courses', function () {
//     return view('student.enrolled-courses');
// });

Route::get('/my-progress', function () {
    return view('student.dashboard');
});
Route::get('/course-details', function () {
    return view('student.course-details');
});
Route::get('/view-course', function () {
    return view('student.active');
});

Route::middleware('student.auth')->group(function () {
    Route::get('/profile', [StudentController::class, 'profile'])->name('student-profile');
    Route::get('/my-courses', [StudentController::class, 'getCourses'])->name('my-courses');
    Route::get('/my-quizz', [StudentController::class, 'myQuiz'])->name('my-quizz');
    // Route::get('/my-progress', [StudentController::class, 'profile'])->name('student-profile');
    // Add other routes here
});

// Route::get('/my-quizz', function () {
//     return view('student.my-quizz');
// });

Route::get('/my-tasks', function () {
    return view('student.tasks');
});

Route::get('/settings', function () {
    return view('student.settings');
});


Route::get('/session-details', function () {
    return view('student.session-details');
});

Route::get('/home', function () {
    return view('student.home');
});
Route::get('/all-courses', [CourseController::class, 'index'])->name('courses.all');

Route::get('/course/{id}', [CourseController::class, 'show'])->name('course.details');

Route::get('/message', function () {
    return view('student.message');
});
// instructor
Route::get('/time-table', function () {
    return view('instructor.timetable');
});
Route::get('/instructor/profile', function () {
    return view('instructor.profile');
});
Route::get('/instructor/settings', function () {
    return view('instructor.settings');
});
Route::get('/my-courses', function () {
    return view('instructor.course-details');
});
Route::get('/my-chat', function () {
    return view('instructor.message');
});


// dashboard
Route::get('/admin/profile', function () {
    return view('dashboard.profile');
});
Route::get('/admin/settings', function () {
    return view('dashboard.settings');
});

Route::prefix('admin')->group(function () {
    Route::post('/create_course', [AdminController::class, 'createCourse'])->name('create_course');
});

// Route::get('home', [PortalController::class, 'homePage'])->name('home');
// Route::post('register_student', [PortalController::class, 'registerStudent'])->name('register_student');

Route::get('/survey/{id}', [SurveyController::class, 'showSurvey'])->name('show_survey');
Route::post('/survey/{id}', [SurveyController::class, 'submitSurvey'])->name('submit_survey');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/student-login', [AuthController::class, 'showStudentLoginForm'])->name('student-login');
Route::post('/student-login', [AuthController::class, 'studentLogin'])->name('student-login');
Route::middleware('auth:student')->group(function () {
    Route::get('/student/courses', [StudentController::class, 'getCourses'])->name('student.courses');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});