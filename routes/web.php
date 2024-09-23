<?php

use App\Http\Controllers\StudentController;
use App\Models\Student;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/register', [StudentController::class, 'create'])->name('register');
Route::post('/addStudent', [StudentController::class, 'store'])->name('addStudent');
Route::get('/getStudents', [StudentController::class, 'show'])->name('getStudents');
