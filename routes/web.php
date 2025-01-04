<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PortalController;
use App\Http\Controllers\SurveyController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/home', function () {
//     return view('home');
// });
Route::get('/create-course', function () {
    return view('dashboard.create-course');
});

Route::get('/activate-course', function () {
    return view('dashboard.activate-course');
});

Route::get('/admin', function () {
    return view('dashboard.admin');
});

Route::get('/admin-courses', function () {
    return view('dashboard.admin-courses');
});
Route::prefix('admin')->group(function () {
Route::post('/create_course', [AdminController::class, 'createCourse'])->name('create_course');
});

Route::get('home', [PortalController::class, 'homePage'])->name('home');
Route::post('register_student', [PortalController::class, 'registerStudent'])->name('register_student');

Route::get('/survey/{id}', [SurveyController::class, 'showSurvey'])->name('show_survey');
Route::post('/survey/{id}', [SurveyController::class, 'submitSurvey'])->name('submit_survey');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:student')->group(function () {
    Route::get('/student/courses', [StudentController::class, 'getCourses'])->name('student.courses');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});