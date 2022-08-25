<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\SubjectController;
use App\Http\Controllers\RegisterController;
use Illuminate\Support\Facades\Auth;
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

// Route::get('/', function () {
//     return view('welcome');
// });

Route::get("students/{id}/subjects/unregistered", SubjectController::class."@unregistered")->name("students.subjects.unregistered");
//"students/{id}/subjects/unregistered": URL 
//SubjectController::class."@unregistered": action hay đường dẫn 
//name("students.subjects.unregistered"): tên phương thức trong thằng SubjectController hay là name
//Route::get : phương thức GET

Route::get('students/export',StudentController::class.'@export')->name('students.export'); // url, vô classstudent chạy hàm export, tên để dễ gọi

Route::get('students/formImport',StudentController::class.'@formImport')->name('students.formImport');
Route::post('students/import',StudentController::class.'@import')->name('students.import');  

// echo StudentController::class sinh ra đường dẫn  App\Http\Controllers\StudentController
Route::resource('students',StudentController::class); // nếu nó có thê thằng /students thì chạy zô thằng App\Http\Controllers\StudentController
Route::resource('subjects',SubjectController::class); // nếu nó có thê thằng /students thì chạy zô thằng App\Http\Controllers\StudentController
Route::resource('registers',RegisterController::class); 
Route::resource('/',StudentController::class); 



Auth::routes(['verify'=>true]);
Route::redirect('/home', route('students.index'), 301)->name('home');
// Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
