<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {


	Route::get('/tareas', 'TaskController@index')
		->name('tasks.index')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas-asignadas', 'TaskController@asignadas')
		->name('tasks.asignadas')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/create', 'TaskController@create')
		->name('tasks.create')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/descargar/{archivo}', 'TaskController@descargarArchivo')
		->name('tasks.download')
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

	Route::get('/tareas/{tarea}/cerrar_tarea_view', 'TaskController@cerrar_tarea_view')
		->name('tasks.cerrar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/{tarea}/aprobar_tarea_view', 'TaskController@aprobar_tarea_view')
		->name('tasks.aprobar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/{tarea}/entregar_tarea_view', 'TaskController@entregar_tarea_view')
		->name('tasks.entregar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/{tarea}/rechazar_tarea_view', 'TaskController@rechazar_tarea_view')
		->name('tasks.rechazar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO');


	Route::put('/tareas/actualizar_estados_tareas/{tarea}/{variable}', 'TaskController@actualizar_estados_tareas')
		->name('tasks.actualizar_estados_tareas')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/{tarea}', 'TaskController@destroy')
		->name('tasks.destroy')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('/tareas/{tarea}/show', 'TaskController@show')
		->name('tasks.show')
		->middleware('role:ADMINISTRADOR|USUARIO');






		
});
?>