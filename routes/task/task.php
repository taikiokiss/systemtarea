<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {


	Route::get('/tareas', 'TaskController@index')
		->name('tasks.index');
	
	Route::get('/all-tareas', 'TaskController@indexall')
		->name('tasks.indexall');
	
	Route::get('/tareas/create', 'TaskController@create')
		->name('tasks.create');
	
	Route::post('/tareas/store', 'TaskController@store')
		->name('tasks.store');
	
	Route::get('/tareas/{tarea}/edit', 'TaskController@edit')
		->name('tasks.edit');
	
	Route::put('/tareas/{tarea}', 'TaskController@update')
		->name('tasks.update');
	
	Route::get('/tareas/{tarea}', 'TaskController@destroy')
		->name('tasks.destroy');
	
	Route::get('/all-tareas/{tarea}', 'TaskController@activ')
		->name('tasks.activ');
	
	Route::get('/tarea/{tarea}', 'TaskController@desactiv')
		->name('tasks.desactiv');
		
});
?>