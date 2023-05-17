<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {


	Route::get('/tareas', 'TaskController@index')
		->name('tasks.index')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas-asignadas', 'TaskController@asignadas')
		->name('tasks.asignadas')
		->middleware('role:ADMINISTRADOR|USUARIO');
		
	Route::get('/all-tareas', 'TaskController@indexall')
		->name('tasks.indexall')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::get('/tareas/create', 'TaskController@create')
		->name('tasks.create')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::post('/tareas/store', 'TaskController@store')
		->name('tasks.store')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::get('/tareas/{tarea}/edit', 'TaskController@edit')
		->name('tasks.edit')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::put('/tareas/{tarea}', 'TaskController@update')
		->name('tasks.update')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::get('/tareas/{tarea}', 'TaskController@destroy')
		->name('tasks.destroy')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::get('/all-tareas/{tarea}', 'TaskController@activ')
		->name('tasks.activ')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::get('/tarea/{tarea}', 'TaskController@desactiv')
		->name('tasks.desactiv')
		->middleware('role:ADMINISTRADOR|USUARIO');

		
});
?>