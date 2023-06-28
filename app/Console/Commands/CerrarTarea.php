<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Task;
use App\Historico_mov_tarea;
use DB;
use App\Mail\TareaCerrada;
use Mail;

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

            $registros = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$registro->id)
                ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip','usuarioAsig.email as emailAsig','usuarioSolici.email as emailSolici')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

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
                                'usuario'           => 1,
                                'fecha_act'         => date('Y-m-d H:i:s'),
                                'estado_id_tarea'   => 'APROBADA'
                            ],
                            [
                                'id_tarea'          => $registro->id,
                                'observacion'       => 'CERRADO AUTOMATICO',
                                'usuario'           => 1,
                                'fecha_act'         => date('Y-m-d H:i:s'),
                                'estado_id_tarea'   => 'REALIZADA'
                            ]
                        ];

                    Historico_mov_tarea::insert($historicoMovimientos);

                    Mail::to('elmaic_14@hotmail.com') //asignadodepart-  emailAsig
                        ->send(new TareaCerrada($registros));

                } else {}
            } else {}
        }    
    }
}
