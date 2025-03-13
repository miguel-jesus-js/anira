<?php

use App\Http\Controllers\AddressController;
use App\Http\Controllers\EmployeeController;
use App\Http\Controllers\CustomerController;
use App\Http\Controllers\TypeEmployeeController;
use App\Http\Controllers\TypeCustomerController;
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
Route::delete('/type-employees/{id}', [TypeEmployeeController::class, 'delete']);
Route::get('/type-employees-export', [TypeEmployeeController::class, 'export']);


Route::get('/type-customers', [TypeCustomerController::class, 'index']);
Route::post('/type-customers', [TypeCustomerController::class, 'store']);
Route::get('/type-customers/{id}', [TypeCustomerController::class, 'show']);
Route::put('/type-customers/{id}', [TypeCustomerController::class, 'update']);
Route::delete('/type-customers/{id}', [TypeCustomerController::class, 'delete']);
Route::get('/type-customers-export', [TypeCustomerController::class, 'export']);

Route::get('/employees', [EmployeeController::class, 'index']);
Route::post('/employees', [EmployeeController::class, 'store']);
Route::get('/employees/{id}', [EmployeeController::class, 'show']);
Route::put('/employees/{id}', [EmployeeController::class, 'update']);
Route::delete('/employees/{id}', [EmployeeController::class, 'delete']);
Route::get('/employees-export', [EmployeeController::class, 'export']);

Route::get('/customers', [CustomerController::class, 'index']);
Route::post('/customers', [CustomerController::class, 'store']);
Route::get('/customers/{id}', [CustomerController::class, 'show']);
Route::put('/customers/{id}', [CustomerController::class, 'update']);
Route::delete('/customers/{id}', [CustomerController::class, 'delete']);
Route::get('/customers-export', [CustomerController::class, 'export']);

Route::post('/address/{id}', [AddressController::class, 'store']);
Route::put('/address/{id}', [AddressController::class, 'update']);
Route::delete('/address/{peopleId}/{addressId}', [AddressController::class, 'delete']);
Route::post('/address-validate', [AddressController::class, 'validate']);

