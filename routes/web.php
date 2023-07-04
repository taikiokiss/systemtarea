<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SendEmailController; 

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
Route::get('/clear', function() {
    Artisan::call('cache:clear');
    Artisan::call('config:cache');
    Artisan::call('view:clear');
    return "Cleared!";
});

Route::get('/', function () {
    return  redirect('/login');
});

Auth::routes(['register' => false]);
Auth::routes();

Route::middleware(['auth'])->group(function () {
	Route::get('/home', 'HomeController@index')
		->name('home');

	Route::get('/changePassword','HomeController@showChangePasswordForm');

	Route::post('/changePassword','HomeController@changePassword')
		->name('changePassword');

//Route Hooks - Do not delete//
	Route::view('groups', 'livewire.groups.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');
	Route::view('departments', 'livewire.departments.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');
	Route::view('permissions', 'livewire.permissions.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');
	Route::view('roles', 'livewire.roles.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');
	Route::view('users', 'livewire.users.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');
	Route::view('departments_descrip', 'livewire.departments_descrips.index')->middleware('role:ADMINISTRADOR|SUPER-ADMIN');

});

require __DIR__ . '/task/task.php';
require __DIR__ . '/mail/mail.php';
require __DIR__ . '/reportes_print/reportes_print.php';


