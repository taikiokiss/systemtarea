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
        $registros1 = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 


        foreach ($registros1 as $registro) {
            $fechaEntrega = $registro->fecha_entrega;
            $fechaHoy = date("Y-m-d");


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

            if($registro->vencida != 'SI' && (($registro->estado != 'ANULADA' || $registro->estado != 'REALIZADA') && $registro->accion != 'CONSULTAR' )){
                if ($fechaHoy > $fechaEntrega) {

                    Task::select(DB::table('tasks'))
                        ->where('id', $registro->id)
                        ->update([
                            'vencida' => 'SI'
                        ]);

                    Mail::to('elmaic_14@hotmail.com') //asignadodepart-  emailAsig
                        ->send(new TareaVencida($registros));
                        //->cc('tabatablet65@gmail.com') //solicitarea-    emailSolici
                } else {
                    
                }
            }

        }
        
    }
}
