<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
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
            ->where('tasks.estado','=','ACTIVO')
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt',)
            ->get(); 
        return view('tasks.index', compact('tasks'));

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $departmentt = Department::all();

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
        return view('tasks.create', compact('datos'));
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
            $tasks->estado          = 'ACTIVO';
            $tasks->save();




        $notificationa=array(
            'message' => 'Tarea ingresada con éxito',
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
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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
        //
    }
}
