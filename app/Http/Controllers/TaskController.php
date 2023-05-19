<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Task;
use App\Tasks_users_rl;
use App\Historico_mov_tarea;
use App\Models\Department;
use App\Models\User;
use App\Models\Person;
use App\Models\Group;
use Auth;
use DB;

class TaskController extends Controller
{

    public function index()
    {
        $tasks = DB::table('tasks')
            ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments', 'departments.id', '=', 'tasks.department_id')
            ->where('tasks.usuario_solicitante','=',Auth::user()->id,'AND')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.index', compact('tasks'));
    }

    public function asignadas()
    {
        $tasks = DB::table('tasks')
            ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments', 'departments.id', '=', 'tasks.department_id')
            ->where('tasks.asign_a','=',Auth::user()->id)
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 
        return view('tasks.asignadas', compact('tasks'));
    }

    public function create()
    {

        $departmentt = Department::all();

        $opcion_rrp = DB::table('option')
            ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
            ->where('option.nombre_opcion','=','REPETIR_CADA')
            ->select('sub_option.*')
            ->get();

        $userss = DB::table('users')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('users.estado','=','ACTIVO')
            ->select('persons.*','departments.*')
            ->get();

        $datos = [
            'departma' => $departmentt,
            'opciones' => $userss,
        ];
        return view('tasks.create', compact('datos','opcion_rrp'));
    }

    public function store(Request $request)
    {

            $tasks = array();
            $tasks = new Task;
            $tasks->asunto          = $request->input('asunto');
            $tasks->descripcion     = $request->input('descripcion');
            $tasks->fecha_entrega   = $request->input('fecha_entrega');
            $tasks->department_id   = $request->input('departamento');
            $tasks->asign_a         = $request->input('asign_a');
            $tasks->ciclo           = $request->input('rcada');
            $tasks->usuario_solicitante     = Auth::user()->id;
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
                'fecha_act'         => $tasks->created_at,
                'estado_id_tarea'   => 'ASIGNADA'                
            ]);
            

        $notificationa=array(
            'message' => 'Tarea creada con éxito',
            'alert-type' => 'success'
        );
        return redirect()->route('tasks.index', $tasks->id)
            ->with($notificationa);        
    }

    public function show($id, Request $request)
    {
        return view('tasks.show');
    }

    public function edit($id, Request $request)
    {
        $tasks = Task::find($id);
        
        if (auth()->check() && (auth()->user()->id === $tasks->asign_a || auth()->user()->id === $tasks->usuario_solicitante ) ) {
                $departmentt = Department::all();

                $opcion_rrp = DB::table('option')
                    ->join('sub_option', 'sub_option.cabe_opcion', '=', 'option.id_subopcion')
                    ->where('option.nombre_opcion','=','REPETIR_CADA')
                    ->select('sub_option.*')
                    ->get();

                $userss = DB::table('users')
                    ->join('persons', 'persons.id', '=', 'users.persona_id')
                    ->join('departments', 'departments.id', '=', 'users.deparment_id')
                    ->where('users.estado','=','ACTIVO')
                    ->select('persons.*','departments.*')
                    ->get();

                $datos = [
                    'departma' => $departmentt,
                    'opciones' => $userss,
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
                    ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
                    ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                    ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                    ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                    ->join('departments', 'departments.id', '=', 'tasks.department_id')
                    ->where('tasks.id','=',$id)
                    ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid')
                    ->orderBy('tasks.created_at', 'desc')
                    ->get(); 


                return view('tasks.edit', compact('tasks1','tasks','datos','opcion_rrp','ciclo','tasks_users_rl'));

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
        }



        $notificationa=array(
            'message' => 'Tarea actualizada con éxito.',
            'alert-type' => 'success'
        );

        return redirect()->route('tasks.index', $tasks->id)
            ->with($notificationa);
    }

    public function cerrar_tarea_up(Request $request, $id)
    {

        $tasks = Task::find($id);
        $campos = ['asunto', 'descripcion','observacion','fecha_entrega', 'departamento', 'asign_a', 'rcada'];
        $actualizacion = [];

        foreach ($campos as $campo) {
            if (isset($request->$campo)) {
                $actualizacion[$campo] = $request->$campo;
            }
        }

        if (!empty($actualizacion)) {

            $files = $request->file('file');
            $actualizacion['estado'] = 'REALIZADA';
            $actualizacion['accion'] = 'CONSULTAR';

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
        }

            Historico_mov_tarea::create([
                'id_tarea'          => $tasks->id,
                'observacion'       => $request->get('observacion'),
                'usuario'           => Auth::user()->id,
                'fecha_act'         => $tasks->created_at,
                'estado_id_tarea'   => 'REALIZADA'                
            ]);


        $notificationa=array(
            'message' => 'Tarea cerrada con éxito.',
            'alert-type' => 'error'
        );

        return redirect()->route('tasks.index', $tasks->id)
            ->with($notificationa);
    }

    public function cerrar_tarea_view($id, Request $request)
    {
        $tasks = Task::find($id);
        
        if (auth()->check() && (auth()->user()->id === $tasks->asign_a || auth()->user()->id === $tasks->usuario_solicitante ) ) {
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

            $ciclo = DB::table('option')
                ->join('sub_option','sub_option.cabe_opcion','option.id_subopcion')
                ->where('option.nombre_opcion','=','REPETIR_CADA','AND')
                ->where('sub_option.id','=',$tasks->ciclo)
                ->get();

            $historico_mov_tarea = DB::table('historico_mov_tarea')
                ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
                ->join('persons', 'persons.id', '=', 'users.persona_id')
                ->join('departments', 'departments.id', '=', 'users.deparment_id')
                ->where('users.estado','=','ACTIVO','AND')
                ->where('historico_mov_tarea.id_tarea','=',$id)
                ->select('persons.*','departments.*','historico_mov_tarea.*')
                ->get();

            $tasks1 = DB::table('tasks')
                ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments', 'departments.id', '=', 'tasks.department_id')
                ->where('tasks.id','=',$id)
                ->select('tasks.*','perAsig.id as IdAsig','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments.id as depaid')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 


            return view('tasks.cerrar_tarea', compact('tasks1','tasks','opcion_rrp','ciclo','tasks_users_rl','historico_mov_tarea'));
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

        $notification=array(
            'message' => 'Tarea anulada con éxito.',
            'alert-type' => 'success'
        );
        return back()->with($notification);
    }


}
