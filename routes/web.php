<?php

use Illuminate\Support\Facades\Route;

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
    return  redirect('/login');
});

Auth::routes(['register' => false]);

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

//Route Hooks - Do not delete//
	Route::view('groups', 'livewire.groups.index')->middleware('role:ADMINISTRADOR');
	Route::view('departments', 'livewire.departments.index')->middleware('role:ADMINISTRADOR');
	Route::view('permissions', 'livewire.permissions.index')->middleware('role:ADMINISTRADOR');
	Route::view('roles', 'livewire.roles.index')->middleware('role:ADMINISTRADOR');
	Route::view('users', 'livewire.users.index')->middleware('role:ADMINISTRADOR');

require __DIR__ . '/task/task.php';
require __DIR__ . '/reportes_print/reportes_print.php';

