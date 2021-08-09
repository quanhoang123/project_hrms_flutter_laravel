<?php

use App\Http\Controllers\API\DashboardController;
use App\Http\Controllers\UserController;
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
Route::get('/logout',  [UserController::class,'logout']);

// Dashboard Routes...
Route::get('dashboard', [
    'middleware' => ['permission:read-dashboard'],
    'uses' => [DashboardController::class,'index'],
    'as'   => 'dashboard'
])->middleware(['auth','only_active_user']);

// Route::get('/userss',[UserController::class,'index']);

// User Routes...
Route::prefix('users')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/', ['middleware' => ['permission:read-users'], 'uses'=>'UserController@index','as'=>'user.index']);
    Route::get('/add', ['middleware' => ['permission:create-users'], 'uses'=>'UserController@create','as'=>'user.add.get']);
    Route::post('/add', ['middleware' => ['permission:create-users'], 'uses'=>'UserController@store','as'=>'user.add.post']);
    Route::get('/edit/{id}', ['middleware' => ['permission:update-users'], 'uses' =>'UserController@edit','as'=>'user.edit.get']);
    Route::post('/edit', ['middleware' => ['permission:update-users'], 'uses'=>'UserController@update','as'=>'user.edit.post']);
    Route::get('/delete/{id}', ['middleware' => ['permission:delete-users'], 'uses'=>'UserController@destroy','as'=>'user.delete.get']);
});

// Nhân Sự Routes...
Route::prefix('staffs')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/', ['middleware' => ['permission:read-nhan-su'], 'uses'=>'NhanSuController@index','as'=>'nhan_su.index']);
    Route::get('/read/{id}', ['middleware' => ['permission:read-nhan-su'], 'uses'=>'NhanSuController@read','as'=>'nhan_su.read.get']);
    Route::get('/add', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'NhanSuController@create','as'=>'nhan_su.add.get']);
    Route::post('/add', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'NhanSuController@store','as'=>'nhan_su.add.post']);
    Route::get('/edit/{id}', ['middleware' => ['permission:update-nhan-su'], 'uses' =>'NhanSuController@edit','as'=>'nhan_su.edit.get']);
    Route::post('/edit/{id}', ['middleware' => ['permission:update-nhan-su'], 'uses'=>'NhanSuController@update','as'=>'nhan_su.edit.post']);
    Route::get('/delete/{id}', ['middleware' => ['permission:delete-nhan-su'], 'uses'=>'NhanSuController@destroy','as'=>'nhan_su.delete.get']);
    Route::get('/export-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'NhanSuController@exportExcel','as'=>'nhan_su.export-excel.get']);
    Route::get('/import-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'NhanSuController@importExcel','as'=>'nhan_su.import-excel.get']);
    Route::post('/import-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'NhanSuController@postImportExcel','as'=>'nhan_su.import-excel.post']);
});

Route::prefix('employees')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/', ['middleware' => ['permission:read-nhan-su'], 'uses'=>'UngCuVienController@index','as'=>'ungcuvien.index']);
    Route::get('/read/{id}', ['middleware' => ['permission:read-nhan-su'], 'uses'=>'UngCuVienController@read','as'=>'ungcuvien.read.get']);
    Route::get('/add', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'UngCuVienController@create','as'=>'ungcuvien.add.get']);
    Route::post('/add', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'UngCuVienController@store','as'=>'ungcuvien.add.post']);
    Route::get('/edit/{id}', ['middleware' => ['permission:update-nhan-su'], 'uses' =>'UngCuVienController@edit','as'=>'ungcuvien.edit.get']);
    Route::post('/edit/{id}', ['middleware' => ['permission:update-nhan-su'], 'uses'=>'UngCuVienController@update','as'=>'ungcuvien.edit.post']);
    Route::get('/delete/{id}', ['middleware' => ['permission:delete-nhan-su'], 'uses'=>'UngCuVienController@destroy','as'=>'ungcuvien.delete.get']);
    Route::get('/export-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'UngCuVienController@exportExcel','as'=>'ungcuvien.export-excel.get']);
    Route::get('/import-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'UngCuVienController@importExcel','as'=>'ungcuvien.import-excel.get']);
    Route::post('/import-excel', ['middleware' => ['permission:create-nhan-su'], 'uses'=>'UngCuVienController@postImportExcel','as'=>'ungcuvien.import-excel.post']);
});

// Company Routes...
Route::prefix('company')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/init', ['middleware' => ['permission:update-company'], 'uses'=>'CompanyController@init','as'=>'company.init']);
    Route::get('/', ['middleware' => ['permission:update-company'], 'uses'=>'CompanyController@index','as'=>'company.index']);
    Route::post('/update', ['middleware' => ['permission:update-company'], 'uses'=>'CompanyController@update','as'=>'company.update']);
});

// Ajax Routes...
Route::prefix('ajax')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::post('/dsBoPhanTheoPhongBan', ['uses'=>'NhanSuController@dsBoPhanTheoPhongBan','as'=>'dsBoPhanTheoPhongBan']);
    Route::post('/postThemHopDong', ['middleware' => ['permission:create-hop-dong'], 'uses'=>'HopDongController@postThemHopDong','as'=>'postThemHopDong']);
    Route::post('/postTimHopDongTheoId', ['uses'=>'HopDongController@postTimHopDongTheoId','as'=>'postTimHopDongTheoId']);
    Route::post('/postSuaHopDong', ['middleware' => ['permission:update-hop-dong'], 'uses'=>'HopDongController@postSuaHopDong','as'=>'postSuaHopDong']);
    Route::post('/postXoaHopDong', ['middleware' => ['permission:delete-hop-dong'], 'uses'=>'HopDongController@postXoaHopDong','as'=>'postXoaHopDong']);

    Route::post('/postThemQuyetDinh', ['middleware' => ['permission:create-quyet-dinh'], 'uses'=>'QuyetDinhController@postThemQuyetDinh','as'=>'postThemQuyetDinh']);
    Route::post('/postTimQuyetDinhTheoId', ['uses'=>'QuyetDinhController@postTimQuyetDinhTheoId','as'=>'postTimQuyetDinhTheoId']);
    Route::post('/postSuaQuyetDinh', ['middleware' => ['permission:update-quyet-dinh'], 'uses'=>'QuyetDinhController@postSuaQuyetDinh','as'=>'postSuaQuyetDinh']);
    Route::post('/postXoaQuyetDinh', ['middleware' => ['permission:delete-quyet-dinh'], 'uses'=>'QuyetDinhController@postXoaQuyetDinh','as'=>'postXoaQuyetDinh']);

});

// File Manager
Route::prefix('file-manager')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/', ['middleware' => ['permission:update-file-manager'], 'uses'=>'FileManagerController@index','as'=>'file-manager.index']);
});

// Role Route...
Route::prefix('roles')->middleware(['auth', 'only_active_user'])->group(function () {
    Route::get('/', ['middleware' => ['permission:read-acl'], 'uses'=>'RoleController@index','as'=>'role.index']);
    Route::get('/create', ['middleware' => ['permission:create-acl'], 'uses'=>'RoleController@create','as'=>'role.create']);
    Route::post('/store', ['middleware' => ['permission:create-acl'], 'uses'=>'RoleController@store','as'=>'role.store']);
    Route::get('/show/{id}', ['middleware' => ['permission:update-acl'], 'uses'=>'RoleController@show','as'=>'role.show']);
    Route::get('/edit/{id}', ['middleware' => ['permission:update-acl'], 'uses'=>'RoleController@edit','as'=>'role.edit']);
    Route::post('/edit/{id}', ['middleware' => ['permission:delete-acl'], 'uses'=>'RoleController@update','as'=>'role.update']);
});