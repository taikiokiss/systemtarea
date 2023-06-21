<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::get('mail-settings', 'MailSettingsController@mailsettings')
		->name('mail.settings')
		->middleware('role:ADMINISTRADOR|ADMINISTRADOR-NV');

	Route::put('mail-settings', 'MailSettingsController@update')
		->name('mail.settings.update')
		->middleware('role:ADMINISTRADOR|ADMINISTRADOR-NV');

	Route::get('logs-admin-view-system', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index']);

});
?>