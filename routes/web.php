<?php

use Illuminate\Support\Facades\Route;
// use App\Http\Controllers\TeacherController;

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

// Route::get('/ff', function () {
//     return view('welcome');
// });

// Auth::routes();

// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
// Route::get('/teacher',[App\Http\Controllers\TeacherController::class, 'show']);

Route::get('{any}', [App\Http\Controllers\HomeController::class, 'index'])->where('any','.*');

