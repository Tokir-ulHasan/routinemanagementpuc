<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('auth:sanctum')->get('/athenticated', function () {
    return true;
});

// Table Inster Api

Route::get('routine/teachers/list',[App\Http\Controllers\TeacherController::class, 'show']);
Route::get('room/list',[App\Http\Controllers\RoomController::class, 'show']);
Route::get('routine/courses/list',[App\Http\Controllers\CourseController::class, 'show']);
Route::get('department/list',[App\Http\Controllers\DepartmentController::class, 'show']);
Route::get('section/list/{s_id}',[App\Http\Controllers\SectionController::class, 'show']);
Route::get('routine/list/{id}',[App\Http\Controllers\RoutineController::class, 'show']);
Route::get('logout',[App\Http\Controllers\UserController::class, 'logout']);
Route::get('assigned/Course/list/{t_id}/{s_id}',[App\Http\Controllers\AssignedCoursesController::class, 'index']);
Route::get('assigned/Course/list2/{s_id}',[App\Http\Controllers\AssignedCoursesController::class, 'show']);
Route::get('session/list', [App\Http\Controllers\UserController::class,'show']);
Route::get('time/list/{s_id}', [App\Http\Controllers\TimeController::class,'show']);
Route::get('subsection/list/{s_id}',[App\Http\Controllers\SubSectionController::class, 'show']);


Route::post('department/add', [App\Http\Controllers\DepartmentController::class,'store']);
Route::post('teacher/add', [App\Http\Controllers\TeacherController::class,'store']);
Route::post('room/add', [App\Http\Controllers\RoomController::class,'store']);
Route::post('course/add', [App\Http\Controllers\CourseController::class,'store']);
Route::post('session/add', [App\Http\Controllers\UserController::class,'store']);
Route::post('section/add', [App\Http\Controllers\SectionController::class,'store']);
Route::post('routine/add', [App\Http\Controllers\RoutineController::class,'store']);
Route::post('time/add', [App\Http\Controllers\TimeController::class,'store']);
Route::post('day/add', [App\Http\Controllers\DayController::class,'store']);
Route::post('assigned/Course', [App\Http\Controllers\AssignedCoursesController::class,'store']);
Route::post('subSection/add', [App\Http\Controllers\SubSectionController::class,'store']);


Route::put('department/update/{id}',[App\Http\Controllers\DepartmentController::class, 'update']);
Route::put('session/update/{id}',[App\Http\Controllers\UserController::class, 'update']);
Route::put('routine/update/{id}', [App\Http\Controllers\RoutineController::class,'update']);


Route::delete('routine/delete/{id}', [App\Http\Controllers\RoutineController::class,'destroy']);
Route::delete('delete/assigned/Course/{id}', [App\Http\Controllers\AssignedCoursesController::class,'destroy']);


Route::post('login', [App\Http\Controllers\UserController::class,'login']);

