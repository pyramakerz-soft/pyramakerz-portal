<?php

use App\Http\Controllers\PortalController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\StudentController;
Route::get('/', function () {
    return view('welcome');
});
// Route::get('/home', function () {
//     return view('home');
// });

Route::get('home', [PortalController::class, 'homePage'])->name('home');
Route::post('register_student', [PortalController::class, 'registerStudent'])->name('register_student');

Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:student')->group(function () {
    Route::get('/student/courses', [StudentController::class, 'getCourses'])->name('student.courses');
    Route::post('/logout', [AuthController::class, 'logout'])->name('logout');
});