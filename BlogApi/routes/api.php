<?php

use App\Http\Controllers\MemberController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::group(['middleware' => 'auth:sanctum'], function () {

    Route::get('/students', [StudentController::class, 'list']);
    Route::post('/students/add', [StudentController::class, 'addStudent']);
    Route::put('/students/update/{id}', [StudentController::class, 'updateStudent']);
    Route::delete('/students/delete/{id}', [StudentController::class, 'deleteStudent']);
    Route::get('/students/filter/{search}', [StudentController::class, 'searchStudent']);
});

Route::resource('members', MemberController::class);

Route::post('register', [UserController::class, 'register']);
Route::post('login', [UserController::class, 'login']);
