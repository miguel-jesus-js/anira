<?php

use App\Http\Controllers\UserController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Support\Facades\Route;

Route::get('/', function (){
    return view('welcome');
});

Route::get('/users', [UserController::class, 'index']);
Route::post('/users', [UserController::class, 'store'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::get('/users/{id}', [UserController::class, 'show']);
Route::put('/users/{id}', [UserController::class, 'update'])->withoutMiddleware([VerifyCsrfToken::class]);
Route::delete('/users/{id}', [UserController::class, 'destroy'])->withoutMiddleware([VerifyCsrfToken::class]);
