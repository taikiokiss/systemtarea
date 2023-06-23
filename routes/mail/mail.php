<?php 

Auth::routes();

Route::middleware(['auth'])->group(function () {

	Route::get('mail-settings', 'MailSettingsController@mailsettings')
		->name('mail.settings')
		->middleware('role:SUPER-ADMIN');

	Route::put('mail-settings', 'MailSettingsController@update')
		->name('mail.settings.update')
		->middleware('role:SUPER-ADMIN');

	Route::get('logs-admin-view-system', [\Rap2hpoutre\LaravelLogViewer\LogViewerController::class, 'index'])
		->middleware('role:SUPER-ADMIN');

});
?>