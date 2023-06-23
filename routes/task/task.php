<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {


	Route::get('/tareas', 'TaskController@index')
		->name('tasks.principales.index')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas-asignadas', 'TaskController@asignadas')
		->name('tasks.principales.asignadas')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas-resueltas', 'TaskController@resueltas')
		->name('tasks.principales.resueltas')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas-vencidas', 'TaskController@vencidas')
		->name('tasks.principales.vencidas')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas-pendientes', 'TaskController@pendientes')
		->name('tasks.principales.pendientes')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/create', 'TaskController@create')
		->name('tasks.create')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/descargar/{archivo}', 'TaskController@descargarArchivo')
		->name('tasks.download')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::post('/tareas/store', 'TaskController@store')
		->name('tasks.store')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/edit', 'TaskController@edit')
		->name('tasks.edit')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::put('/tareas/{tarea}', 'TaskController@update')
		->name('tasks.update')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/cerrar_tarea_view', 'TaskController@cerrar_tarea_view')
		->name('tasks.acciones.cerrar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/aprobar_tarea_view', 'TaskController@aprobar_tarea_view')
		->name('tasks.acciones.aprobar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/aprobarfinaltarea_view', 'TaskController@aprobarfinal_tarea_view')
		->name('tasks.acciones.aprobarfinaltarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/entregar_tarea_view', 'TaskController@entregar_tarea_view')
		->name('tasks.acciones.entregar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/rechazar_tarea_view', 'TaskController@rechazar_tarea_view')
		->name('tasks.acciones.rechazar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}/consultar_tarea_view', 'TaskController@consultar_tarea_view')
		->name('tasks.acciones.consultar_tarea_view')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::put('/tareas/actualizar_estados_tareas/{tarea}/{variable}', 'TaskController@actualizar_estados_tareas')
		->name('tasks.actualizar_estados_tareas')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

	Route::get('/tareas/{tarea}', 'TaskController@destroy')
		->name('tasks.destroy')
		->middleware('role:ADMINISTRADOR|USUARIO|SUPER-ADMIN');

});
?>