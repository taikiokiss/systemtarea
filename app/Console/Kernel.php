<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
       Commands\ActuaVencida::class,
       Commands\AprobarTarea::class,
       Commands\CerrarTarea::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
       //TAREA ENCARGADA DE VERIFICAR SI SE ENCUENTRA VENCIDA LA FECHA O NO 
            //$schedule->command('actuavencida:cron')->everyMinute();

       //TAREA ENCARGADA DE APROBAR UNA TAREA SI NO LO HAN HECHO PASADO 4 DIAS 
            //$schedule->command('aprobar:tarea')->everyMinute();

       //TAREA ENCARGADA DE CERRAR UNA TAREA SI NO LO HAN HECHO PASADO 3 DIAS 
            //$schedule->command('cerrar:tarea')->everyMinute();            
    }


    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
