<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Historico_mov_tarea;
use DB;

class CerrarTarea extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'cerrar:tarea';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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

            if ($diasTranscurridos >= 3) {

                if ($registro->estado == 'ENTREGADA') {
                    Task::select(DB::table('tasks'))
                        ->where('id', $registro->id)
                        ->update([
                            'estado' => 'APROBADA',
                            'accion' => 'CONSULTAR',
                        ]);

                        $historicoMovimientos = [
                            [
                                'id_tarea'          => $registro->id,
                                'observacion'       => 'APROBADO AUTOMATICO',
                                'usuario'           => 4,
                                'fecha_act'         => date('Y-m-d H:i:s'),
                                'estado_id_tarea'   => 'APROBADA'
                            ],
                            [
                                'id_tarea'          => $registro->id,
                                'observacion'       => 'CERRADO AUTOMATICO',
                                'usuario'           => 4,
                                'fecha_act'         => date('Y-m-d H:i:s'),
                                'estado_id_tarea'   => 'REALIZADA'
                            ]
                        ];

                    Historico_mov_tarea::insert($historicoMovimientos);

                } else {}
            } else {}
        }    
    }
}
