<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Historico_mov_tarea;
use DB;

class AprobarTarea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'aprobar:tarea';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Este comando funciona para aprobar automaticamente la tarea si han pasado 4 dias.';

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
            $fechaEntrega = $registro->fecha_creacion;
            $fechaHoy = date("Y-m-d");

            $intervalo = date_diff(date_create($fechaHoy), date_create($fechaEntrega));
            $diasTranscurridos = $intervalo->format("%a");

            if ($diasTranscurridos >= 4) {

                if ($registro->estado == 'EN PROCESO') {
                    Task::select(DB::table('tasks'))
                        ->where('id', $registro->id)
                        ->update([
                            'estado' => 'APROBADA'
                            'accion' => 'ENTREGAR'
                        ]);

                    Historico_mov_tarea::create([
                        'id_tarea'          => $registro->id,
                        'observacion'       => 'APROBADO AUTOMATICO',
                        'usuario'           => 4,
                        'fecha_act'         => date("Y-m-d h:i:s"),
                        'estado_id_tarea'   => 'APROBADA'                
                    ]);
                } else {}
            } else {}
        }    
    }
}
