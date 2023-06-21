<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Email_configuration;

class MailSettingsController extends Controller
{
    public function mailsettings()
    {
        $settings = Email_configuration::all();

        return view('mail.settings', compact('settings'));
    }

    public function update(Request $request)
    {

        $settings_data = Email_configuration::all();        
        $settings = Email_configuration::find($settings_data[0]->id);
        $settings->update($request->all());
        
        $notificationa=array(
            'message' => 'La configuración fue actualizada con éxito.',
            'alert-type' => 'success'
        );

        return redirect()->route('mail.settings', $settings->id)
            ->with($notificationa);
    }

}
