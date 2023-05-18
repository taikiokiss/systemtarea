<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
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

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
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
                    $path   = $file->storeAs('/public/archivos_adjuntos',$ced.$var.$nombre);


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

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function cerrar($id, Request $request)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id, Request $request)
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

        $tasks = Task::find($id);

        $tasks1 = DB::table('tasks')
            ->join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments', 'departments.id', '=', 'tasks.department_id')
            ->where('tasks.id','=',$id)
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 

        //dd($tasks1[0]->descripcion);

        return view('tasks.edit', compact('tasks1','tasks','datos','opcion_rrp'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
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
