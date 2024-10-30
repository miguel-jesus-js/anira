<?php

use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\TypeEmployeeController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store']);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update']);
Route::delete('/users/{id}', [UserController::class, 'destroy']);


Route::get('/type-employees', [TypeEmployeeController::class, 'index']);
Route::post('/type-employees', [TypeEmployeeController::class, 'store']);
Route::get('/type-employees/{id}', [TypeEmployeeController::class, 'show']);
Route::put('/type-employees/{id}', [TypeEmployeeController::class, 'update']);
Route::delete('/type-employees/{id}', [TypeEmployeeController::class, 'destroy']);

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'destroy']);
