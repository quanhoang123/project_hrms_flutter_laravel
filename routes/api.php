<?php

use App\Http\Controllers\API\AccountController;
use App\Http\Controllers\API\DashboardController;
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
Route::post('/update', 'UserController@update');


Route::group(['middleware' => OnlyActiveAccount::class], function () {
    Route::get('/logout',  [UserController::class,'logout']);

    // Account controller
    Route::get('/roles', [AccountController::class,'index']);
    Route::get('/create-role',[AccountController::class,'create']);
    Route::post('/store-role',[AccountController::class,'store']);
    Route::get('/show-role/{id}',[AccountController::class,'show']);
    Route::get('/show-permission',[AccountController::class,'show_permission']);
    Route::post('/edit-role/{id}',[AccountController::class,'update']);


    // Employee controoler
    Route::get('/employee',[NhanSuController::class,'index']);
    Route::get('/read-employee/{id}',[NhanSuController::class,'read']);
    Route::get('/add-employee',[NhanSuController::class,'create']);
    Route::post('/add-employee',[NhanSuController::class,'store']);
    Route::get('/edit-employee/{id}', [NhanSuController::class,'edit']);
    Route::post('/edit-employee/{id}',[NhanSuController::class,'update']);
    Route::post('/delete-employee/{id}',[NhanSuController::class,'destroy']);


    // Ung Tuyen Nhan Vien Controller
    
});
