<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Task;
use App\Tasks_users_rl;
use App\Historico_mov_tarea;
use App\Models\Department;
use App\Models\Departments_descrip;
use App\Models\User;
use App\Models\Person;
use App\Models\Group;
use App\Models\Move_user_task;
use Auth;
use DB;
use App\Mail\NuevaTarea;
use App\Mail\TareaCerrada;
use Mail;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where('tasks.usuario_solicitante','=',Auth::user()->id,'AND')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 

        return view('tasks.principales.index', compact('tasks'));
    }

    public function asignadas()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where('departments_descrip.usuario_asignado','=',Auth::user()->id)
            ->where('tasks.estado','!=','REALIZADA')
            ->where('tasks.estado','!=','ANULADA')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.principales.asignadas', compact('tasks'));
    }

    public function resueltas()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where('departments_descrip.usuario_asignado','=',Auth::user()->id)
            ->where('tasks.estado','=','REALIZADA')
            ->where('tasks.accion','=','CONSULTAR')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.principales.resueltas', compact('tasks'));
    }

    public function vencidas()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where('departments_descrip.usuario_asignado','=',Auth::user()->id,'AND')
            ->where('tasks.vencida','=','SI')
            ->where('tasks.estado','!=','REALIZADA')
            ->where('tasks.accion','!=','CONSULTAR')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.principales.vencidas', compact('tasks'));
    }

    public function pendientes()
    {
        $tasks = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where('departments_descrip.usuario_asignado','=',Auth::user()->id,'AND')
            ->where('tasks.estado','=','APROBADA')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.principales.pendientes', compact('tasks'));
    }


    public function create()
    {
        $departmentt = Department::where('estado', 'ACTIVO')->get();        
        $depart_list = DB::table('departments_descrip')
            ->join('users', 'users.id', '=', 'departments_descrip.usuario_asignado')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('departments_descrip.estado','=','ACTIVO','AND')
            ->where('departments_descrip.old_new','!=','2')
            ->select('departments_descrip.*','departments.*','persons.id as idperson','departments.id as idpersondepar', 'persons.name as nombre', 'persons.last_name as apellido')
            ->get();

        $opcion_rrp = DB::table('option')
            ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
            ->where('option.nombre_opcion','=','REPETIR_CADA')
            ->select('sub_option.*')
            ->get();

        $datos = [
            'departma' => $departmentt,
            'opciones' => $depart_list,
        ];

        return view('tasks.create', compact('datos','opcion_rrp'));
    }

    public function store(Request $request)
    {
            $ff = $request->get('select_val_sel');
            $fecha_actual = date("Y-m-d");
            //sumo 1 día
            $dff = date("Y-m-d",strtotime($fecha_actual."+ ".$ff." days")); 
            $tasks = array();
            $tasks = new Task;
            $tasks->asunto          = $request->input('asunto');
            $tasks->descripcion     = $request->input('descripcion');
            $tasks->fecha_entrega   = $dff;
            $tasks->fecha_creacion  = $fecha_actual;
            $tasks->deparment_descrip_id   = $request->input('asign_a');
            $tasks->usuario_solicitante     = Auth::user()->id;
            $tasks->vencida         = 'NO';
            $tasks->estado          = 'EN PROCESO';
            $tasks->accion          = 'APROBAR';
            $tasks->save();

            $files = $request->file('file');
            if (!empty($files)) {
                for ($i = 0; $i < count($files); $i++) {
            
                    $file   = $files[$i];
                    $nombre = $files[$i]->getClientOriginalName();
                    $var = rand(0,9999999);
                    $ced = Auth::user()->person->cedula;
                    $path   = $file->storeAs('',$ced.$var.$nombre);


                    if ($file !== null) {
                        $tasks_rl = new Tasks_users_rl;
                        $tasks_rl->id_tasks = $tasks->id;
                        $tasks_rl->file = $path;
                        $tasks_rl->id_users = Auth::user()->id;
                        $tasks_rl->save();
                    }
                }
            }

            Historico_mov_tarea::create([
                'id_tarea'          => $tasks->id,
                'observacion'       => $tasks->descripcion,
                'usuario'           => Auth::user()->id,
                'fecha_act'         => date("Y-m-d H:i:s"),
                'estado_id_tarea'   => 'ASIGNADA'                
            ]);
            
            Move_user_task::create([
                'id_tarea'                  => $tasks->id,
                'id_usuario_movimiento'     => Auth::user()->id,
                'accion'                    => 'CREACION DE TAREA',
                'fecha_movimiento'          => date("Y-m-d H:i:s")
            ]);


        $email_info = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->where('tasks.id','=',$tasks->id)
            ->select('tasks.*','departments_descrip.subtarea_descrip','usuarioSolici.email as email_Solicita','usuarioAsig.email as email_Asignado')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 

        $tasks_users_rl = DB::table('tasks_users_rl')
            ->where('tasks_users_rl.id_tasks', '=', $tasks->id)
            ->select('tasks_users_rl.file')
            ->get();

        $files = $tasks_users_rl->pluck('file')->toArray();

        Mail::to($email_info[0]->email_Asignado)
            ->cc($email_info[0]->email_Solicita)
            ->send(new NuevaTarea($tasks->id, $files));
            

        $notificationa=array(
            'message' => 'Tarea creada con éxito',
            'alert-type' => 'success'
        );
        return redirect()->route('tasks.principales.index', $tasks->id)
            ->with($notificationa);        
    }

    public function edit($id, Request $request)
    {
        $tasks1 = Task::find($id);
        $tasks = Departments_descrip::find($tasks1->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks->usuario_asignado || auth()->user()->id === $tasks1->usuario_solicitante ) ) {

                $opcion_rrp = DB::table('option')
                    ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                    ->where('option.nombre_opcion','=','REPETIR_CADA')
                    ->select('sub_option.*')
                    ->get();

                $department2 = Department::where('estado', 'ACTIVO')->get();

                $depart_list = Departments_descrip::where('estado', 'ACTIVO')->where('old_new', '1')->get();

                $datos = [
                    'departma' => $department2,
                    'opciones' => $depart_list,
                ];

                $tasks_users_rl = DB::table('tasks_users_rl')
                    ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                    ->join('persons', 'persons.id', '=', 'users.persona_id')
                    ->join('departments', 'departments.id', '=', 'users.deparment_id')
                    ->where('users.estado','=','ACTIVO','AND')
                    ->where('tasks_users_rl.id_tasks','=',$id)
                    ->select('persons.*','departments.*','tasks_users_rl.*')
                    ->get();

                $ciclo = DB::table('option')
                    ->join('sub_option','sub_option.cabe_opcion','option.id_subopcion')
                    ->where('option.nombre_opcion','=','REPETIR_CADA','AND')
                    ->where('sub_option.id','=',$tasks->ciclo)
                    ->get();

                $tasks1 = DB::table('tasks')
                    ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                    ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                    ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                    ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                    ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                    ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                    ->where('tasks.id','=',$id)
                    ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                    ->orderBy('tasks.created_at', 'desc')
                    ->get(); 

                return view('tasks.edit', compact('tasks1','tasks','datos','opcion_rrp','tasks_users_rl'));

        } else {
            abort(403); 
        }
    }

    public function descargarArchivo($archivo)
    {
        
        $rutaArchivo = public_path('storage/archivos_adjuntos/' . $archivo);

        return response()->download($rutaArchivo);
    }

    public function update(Request $request, $id)
    {

        $tasks = Task::find($id);
        $campos = ['asunto', 'descripcion','fecha_entrega', 'departamento', 'asign_a', 'rcada'];
        $actualizacion = [];

        foreach ($campos as $campo) {
            if (isset($request->$campo)) {
                $actualizacion[$campo] = $request->$campo;
            }
        }

        if (!empty($actualizacion)) {
            $files = $request->file('file');

            Task::where('id', $id)->update($actualizacion);
            
            if (!empty($files)) {
                for ($i = 0; $i < count($files); $i++) {
            
                    $file   = $files[$i];
                    $nombre = $files[$i]->getClientOriginalName();
                    $var = rand(0,9999999);
                    $ced = Auth::user()->person->cedula;
                    $path   = $file->storeAs('',$ced.$var.$nombre);


                    if ($file !== null) {
                        $tasks_rl = new Tasks_users_rl;
                        $tasks_rl->id_tasks = $tasks->id;
                        $tasks_rl->file = $path;
                        $tasks_rl->id_users = Auth::user()->id;
                        $tasks_rl->save();
                    }
                }
            }

            Move_user_task::create([
                'id_tarea'                  => $tasks->id,
                'id_usuario_movimiento'     => Auth::user()->id,
                'accion'                    => 'EDICION DE TAREA',
                'fecha_movimiento'          => date("Y-m-d H:i:s")
            ]);

        }

        $notificationa=array(
            'message' => 'Tarea actualizada con éxito.',
            'alert-type' => 'success'
        );

        return redirect()->route('tasks.principales.index', $tasks->id)
            ->with($notificationa);
    }

    public function actualizar_estados_tareas(Request $request, $id, $variable)
    {

        $tasks = Task::find($id);
        $campos = ['asunto','descripcion','observacion','departamento','asign_a','calificacion'];
        $actualizacion = [];

        $email_info = DB::table('tasks')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->where('tasks.id','=',$tasks->id)
            ->select('tasks.*','departments_descrip.subtarea_descrip','usuarioSolici.email as email_Solicita','usuarioAsig.email as email_Asignado')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 

        $tasks_users_rl = DB::table('tasks_users_rl')
            ->where('tasks_users_rl.id_tasks', '=', $tasks->id)
            ->select('tasks_users_rl.file')
            ->get();

        $filestc = $tasks_users_rl->pluck('file')->toArray();

        foreach ($campos as $campo) {
            if (isset($request->$campo)) {
                $actualizacion[$campo] = $request->$campo;
            }
        }
        
        if (!empty($actualizacion)) {

            $files = $request->file('file');
            $estado = '';
            $accion = '';

            if ($variable == 'CONSULTAR' || $variable == 'CERRAR') {
                $estado = 'REALIZADA';
                $accion = 'CONSULTAR'; //CERRO LA TAREA o CONSULTO LA TAREA
                $entrega_real = date("Y-m-d H:i:s");
                $calificacion = $request->get('calificacion');
                
                    Mail::to($email_info[0]->email_Asignado) //PERSONA QUE ES ASIGNADA LA TAREA
                        ->send(new TareaCerrada($tasks->id, $filestc));

            }elseif ($variable == 'ENTREGAR') {
                $estado = 'ENTREGADA';
                $accion = 'APROBAR';
                $entrega_real = NULL; //ENTREGO LA TAREA, FALTA APROBACION
                $calificacion = NULL;

            }elseif ($variable == 'APROBAR') {
                $estado = 'APROBADA';
                $accion = 'ENTREGAR'; //APROBO LA CREACION DE LA TAREA
                $entrega_real = NULL;
                $calificacion = NULL;

            }elseif ($variable == 'RECHAZAR') {
                $estado = 'RECHAZADA';
                $accion = 'ENTREGAR';
                $entrega_real = NULL; //RECHAZO LA ENTREGA DE LA TAREA
                $calificacion = NULL;

            }elseif ($variable == 'APROBAR_1') {
                $estado = 'APROBADA';
                $accion = 'CONSULTAR';
                $entrega_real = NULL; //APROBO LA ENTREGA DE LA TAREA
                $calificacion = NULL;

            }
            if (!empty($estado) && !empty($accion)) {
                $actualizacion['estado'] = $estado;
                $actualizacion['accion'] = $accion;
                $actualizacion['entrega_real'] = $entrega_real;
                $actualizacion['calificacion'] = $calificacion;


                Task::where('id', $tasks->id)->update($actualizacion);
    
                Historico_mov_tarea::create([
                    'id_tarea' => $tasks->id,
                    'observacion' => $request->get('observacion'),
                    'usuario' => Auth::user()->id,
                    'fecha_act' => date("Y-m-d H:i:s"),
                    'estado_id_tarea' => $estado
                ]);


                $acciones = [
                    'CONSULTAR' => 'CONSULTO LA TAREA',
                    'CERRAR' => 'CERRO LA TAREA',
                    'ENTREGAR' => 'ENTREGO LA TAREA, FALTA APROBACION',
                    'APROBAR' => 'APROBO LA CREACION DE LA TAREA',
                    'RECHAZAR' => 'RECHAZO LA ENTREGA DE LA TAREA',
                    'APROBAR_1' => 'APROBO LA ENTREGA DE LA TAREA',
                ];


                if (isset($acciones[$variable])) {
                    Move_user_task::create([
                        'id_tarea' => $tasks->id,
                        'id_usuario_movimiento' => Auth::user()->id,
                        'accion' => $acciones[$variable],
                        'fecha_movimiento' => date("Y-m-d H:i:s")
                    ]);
                }
            }

            
            if (!empty($files)) {
                for ($i = 0; $i < count($files); $i++) {
            
                    $file   = $files[$i];
                    $nombre = $files[$i]->getClientOriginalName();
                    $var = rand(0,9999999);
                    $ced = Auth::user()->person->cedula;
                    $path   = $file->storeAs('',$ced.$var.$nombre);


                    if ($file !== null) {
                        $tasks_rl = new Tasks_users_rl;
                        $tasks_rl->id_tasks = $tasks->id;
                        $tasks_rl->file = $path;
                        $tasks_rl->id_users = Auth::user()->id;
                        $tasks_rl->save();
                    }
                }
            }
        }


        $notificationa=array(
            'message' => 'Ejecutado con éxito.',
            'alert-type' => 'success'
        );

        return redirect()->route('tasks.principales.index', $tasks->id)
            ->with($notificationa);
    }

    public function cerrar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {

            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();

            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();


            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

            $tasks1 = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$id)
                ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

            return view('tasks.acciones.cerrar_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function aprobar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {

            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();
                
            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();

            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

            $tasks1 = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$id)
                ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

            return view('tasks.acciones.aprobar_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function aprobarfinal_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {

            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();
                
            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();


            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

            $tasks1 = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$id)
                ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

            return view('tasks.acciones.aprobarfinal_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function entregar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {
 
            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();
                
            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();


            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

            $tasks1 = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$id)
                ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

            return view('tasks.acciones.entregar_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function rechazar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {

            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();
                
            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();


            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

                $tasks1 = DB::table('tasks')
                    ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                    ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                    ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                    ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                    ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                    ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                    ->where('tasks.id','=',$id)
                    ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                    ->orderBy('tasks.created_at', 'desc')
                    ->get(); 


            return view('tasks.acciones.rechazar_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function consultar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        $tasks1 = Departments_descrip::find($tasks->deparment_descrip_id);

        if (auth()->check() && (auth()->user()->id === $tasks1->usuario_asignado || auth()->user()->id === $tasks->usuario_solicitante ) ) {

            $opcion_rrp = DB::table('option')
                ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA')
                ->select('sub_option.*')
                ->get();
                
            $tasks_users_rl = DB::table('tasks_users_rl')
                ->join('users', 'users.id', '=', 'tasks_users_rl.id_users')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('tasks_users_rl.id_tasks','=',$id)
                ->select('persons.*','departments.*','tasks_users_rl.*')
                ->get();


            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->orderBy('historico_mov_tarea.created_at', 'asc')
                ->get();

                $tasks1 = DB::table('tasks')
                    ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                    ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                    ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                    ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                    ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                    ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                    ->where('tasks.id','=',$id)
                    ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid','departments_descrip.subtarea_descrip as nombretarea','departments_descrip.tiempo_demora as tiempotarea','departments_descrip.id as idttarea')
                    ->orderBy('tasks.created_at', 'desc')
                    ->get(); 
            return view('tasks.acciones.consultar_tarea', compact('tasks1','tasks','opcion_rrp','tasks_users_rl','historico_mov_tarea'));
        } else {
            abort(403); 
        }
    }

    public function destroy($id)    
    {
        Task::select(DB::table('tasks'))
            ->where('id', $id)
            ->update([
                'estado' => 'ANULADA',
                'accion' => 'CONSULTAR',
            ]);

        Move_user_task::create([
            'id_tarea' => $id,
            'id_usuario_movimiento' => Auth::user()->id,
            'accion' => 'ANULO LA TAREA',
            'fecha_movimiento' => date("Y-m-d H:i:s")
        ]);


        $notification=array(
            'message' => 'Tarea anulada con éxito.',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }


}
