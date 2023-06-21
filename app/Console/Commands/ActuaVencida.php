<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Historico_mov_tarea;
use DB;
use App\Mail\TareaVencida;
use Mail;

class ActuaVencida extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'actuavencida:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando funciona para verificar si la fecha de entrega no se ha vencido';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        
        $registros1 = DB::table('tasks')->get();

        foreach ($registros1 as $registro) {
            $fechaEntrega = $registro->fecha_entrega;
            $fechaHoy = date("Y-m-d");

            if($registro->vencida != 'SI' && (($registro->estado != 'ANULADA' || $registro->estado != 'REALIZADA') && $registro->accion != 'CONSULTAR' )){
                if ($fechaHoy > $fechaEntrega) {

                    Task::select(DB::table('tasks'))
                        ->where('id', $registro->id)
                        ->update([
                            'vencida' => 'SI'
                        ]);
                } else {
                    
                }
            }

        }
        
    }
}
