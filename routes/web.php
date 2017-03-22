<?php

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

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', ['uses' => 'HomeController@index', 'as' => 'home']);

Route::get('/classification', ['uses' => 'Classification\ClassificationController@index', 'as' => 'classification.index']);

Route::get('/users', ['uses' => 'Classification\User\UserController@index', 'as' => 'users.index']);
Route::post('/users', ['uses' => 'Auth\RegisterController@register', 'as' => 'users.register']);
Route::get('/users/show/{id}', ['uses' => 'Classification\User\UserController@show', 'as' => 'users.show']);
Route::post('/users/updateRole/{id}', ['uses' => 'Classification\User\UserController@updateRole', 'as' => 'users.updateRole']);
Route::get('/users/destroy/{id}', ['uses' => 'Classification\User\UserController@destroy', 'as' => 'users.destroy']);

Route::get('/role', ['uses' => 'Classification\User\Role\RoleController@index', 'as' => 'role.index']);
Route::post('/role', ['uses' => 'Classification\User\Role\RoleController@store', 'as' => 'role.store']);
Route::get('/role/show/{id}', ['uses' => 'Classification\User\Role\RoleController@show', 'as' => 'role.show']);
Route::post('/role/updatePermission/{id}', ['uses' => 'Classification\User\Role\RoleController@updatePermission', 'as' => 'role.updatePermission']);
Route::post('/role/update/{id}', ['uses' => 'Classification\User\Role\RoleController@update', 'as' => 'role.update']);

Route::get('/permission', ['uses' => 'Classification\User\Permission\PermissionController@index', 'as' => 'permission.index']);
Route::post('/permission', ['uses' => 'Classification\User\Permission\PermissionController@store', 'as' => 'permission.store']);
Route::post('/permission/update/{id}', ['uses' => 'Classification\User\Permission\PermissionController@update', 'as' => 'permission.update']);

