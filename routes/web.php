<?php

use App\Http\Controllers\CourseController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\pageController;
use App\Http\Controllers\RoomController;
use App\Http\Controllers\TimetableController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/login', [UserController::class, 'index'])->name('login');
Route::post('/login', [UserController::class, 'loginUser']);
Route::middleware(['auth', 'userauth'])->group(function () {
    Route::get('/logout', [UserController::class, 'destroy']);
    Route::get('/', [pageController::class, 'index']);
    Route::get('/department', [DepartmentController::class, 'index']);
    Route::get('/course', [CourseController::class, 'index']);
    Route::get('/room', [RoomController::class, 'index']);
    Route::get('/timetable', [TimetableController::class, 'index']);


    Route::get('/course/edit/{id}', [CourseController::class, 'edit']);
    Route::get('/room/edit/{id}', [RoomController::class, 'edit']);
    Route::post('/course/edit/{id}', [CourseController::class, 'update']);
    Route::post('/room/edit/{id}', [RoomController::class, 'update']);

    Route::get('/course/show', [CourseController::class, 'show']);
    Route::get('/room/show', [RoomController::class, 'show']);
    Route::get('/timetable/show/{id}', [TimetableController::class, 'show']);

    Route::post('/session', [pageController::class, 'store']);
    Route::post('/department', [DepartmentController::class, 'store']);
    Route::post('/course', [CourseController::class, 'store']);
    Route::post('/room', [RoomController::class, 'store']);
    Route::post('/timetable', [TimetableController::class, 'computeTable']);

    Route::post('/department/delete/{id}', [DepartmentController::class, 'destroy']);
    Route::post('/course/delete/{id}', [CourseController::class, 'destroy']);
    Route::post('/room/delete/{id}', [RoomController::class, 'destroy']);
    Route::post('/timetable/save', [TimetableController::class, 'store']);
});
