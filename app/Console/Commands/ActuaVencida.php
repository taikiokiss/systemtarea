<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use DB;

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

        $registros = DB::table('tasks')->get();

        foreach ($registros as $registro) {
            $fechaEntrega = $registro->fecha_entrega;
            $fechaHoy = date("Y-m-d");

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
