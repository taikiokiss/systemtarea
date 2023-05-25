<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {



//RUTAS DE REPORTES

	Route::get('tareas/reporte/resumido', 'ReporteController@report_resumido')
		->name('reportes.report_resumido')
		->middleware('role:ADMINISTRADOR|USUARIO');


//RUTAS DE IMPRESION

	Route::get('tareas/print/reporte_resumido/', 'ReporteController@imprimir_reporte_resumido')
		->name('print.reporte_resumido')
		->middleware('role:ADMINISTRADOR|USUARIO');

	Route::get('tareas/print/reporte_detallado/{data}', 'ReporteController@imprimir_reporte_detallado')
		->name('print.reporte_detallado')
		->middleware('role:ADMINISTRADOR|USUARIO');


		
});
?>