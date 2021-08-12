<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\BaiVietController;
use App\Http\Controllers\API\EmployeeController;
use App\Http\Controllers\API\UngTuyenController;
use App\Http\Controllers\UserController;
use App\Http\Middleware\OnlyActiveAccount;
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

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

// Home Routes...
Route::get('/', function () {
    return redirect()->route('dashboard');
});
Route::post('/register', 'UserController@register');
Route::post('/login', [UserController::class,'login']);
Route::get('/user', [UserController::class,'getCurrentUser']);
Route::post('/update', [UserController::class,'update']);

    // Employee controoler
    Route::get('/employee',[EmployeeController::class,'index']);
    Route::get('/read-employee/{id}',[EmployeeController::class,'read']);
    Route::get('/add-employee',[EmployeeController::class,'create']);
    Route::post('/add-employee',[EmployeeController::class,'store']);
    Route::get('/edit-employee/{id}', [EmployeeController::class,'edit']);
    Route::post('/edit-employee/{id}',[EmployeeController::class,'update']);
    Route::post('/delete-employee/{id}',[EmployeeController::class,'destroy']);

    Route::get('baiviet', [BaiVietController::class,'index']);
    Route::get('baiviet/{id}', [BaiVietController::class,'show']);
    Route::post('baiviet', [BaiVietController::class,'store']);
    Route::put('baiviet/{id}', [BaiVietController::class,'update']);
    Route::delete('baiviet/{id}', [BaiVietController::class,'delete']);

    Route::get('ungtuyen', [UngTuyenController::class,'index']);
    Route::get('ungtuyen/{id}', [UngTuyenController::class,'show']);
    Route::post('ungtuyen', [UngTuyenController::class,'store']);
    Route::put('ungtuyen/{id}', [UngTuyenController::class,'update']);
    Route::delete('ungtuyen/{id}', [UngTuyenController::class,'delete']);

   


Route::group(['middleware' => OnlyActiveAccount::class], function () {
   
    // Ung Tuyen Nhan Vien Controller
     // Account
    Route::get('/logout',  [UserController::class,'logout']);
     // Account controller
    Route::get('/roles', [AccountController::class,'index']);
    Route::get('/create-role',[AccountController::class,'create']);
    Route::post('/store-role',[AccountController::class,'store']);
    Route::get('/show-role/{id}',[AccountController::class,'show']);
    Route::get('/show-permission',[AccountController::class,'show_permission']);
    Route::post('/edit-role/{id}',[AccountController::class,'update']);
 
 
});
