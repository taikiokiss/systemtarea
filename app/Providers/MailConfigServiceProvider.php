<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Config;
use Illuminate\Support\Facades\DB;

class MailConfigServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if (\Schema::hasTable('emailconfigurations')) {
            $mail = DB::table('emailconfigurations')->first();
            if ($mail) //checking if table is not empty
            {
                $config = array(
                    'mailer'        =>  $mail->mailer,
                    'host'          =>  $mail->host,
                    'port'          =>  $mail->port,
                    'encryption'    =>  $mail->encryption,
                    'username'      =>  $mail->username,
                    'password'      =>  $mail->password,
                    'from_address'  =>  $mail->from_address,
                    'from_name'     =>  $mail->from_name,
                );
                Config::set('mail.mailers.smtp', $config);
            }
        }
    }
}
