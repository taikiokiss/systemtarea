<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

use App\Historico_mov_tarea;
use App\Task;
use App\Tasks_users_rl;
use App\User;
use App\Models\Person;
use Session;
use Auth;

class ReporteController extends Controller
{

    
    public function report_resumido(Request $request){


        $FechaInicio = $request->get('created_at');
        $FechaFin = $request->get('updated_at');


        Session::put('FechaInicio', $FechaInicio);
        Session::put('FechaFin', $FechaFin);

        $tasks = Task::join('users as usuarioAsig','usuarioAsig.id','tasks.asign_a')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments', 'departments.id', '=', 'tasks.department_id')
            ->where(function ($query) {
                $query->orWhere('tasks.usuario_solicitante', '=', Auth::user()->id)
                    ->orWhere('tasks.asign_a', '=', Auth::user()->id);
            })
            ->Fechas($FechaInicio,$FechaFin)
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt')
            ->orderBy('tasks.created_at', 'desc')
            ->get(); 


        if($FechaFin < $FechaInicio ){

            $notificationa=array(
                'message' => 'Fechas colocadas incorrectamente, por favor, ubiquelas correctamente e intente de nuevo.',
                'alert-type' => 'error'
            );

            return back()->with($notificationa);

        }

        Session::put('report_resumido', $tasks);

        return view('reportes.report_resumido', compact('tasks'));

    }

    public function imprimir_reporte_detallado($id){

        $historico_mov_tarea = DB::table('historico_mov_tarea')
            ->join('users', 'users.id', '=', 'historico_mov_tarea.usuario')
            ->join('persons', 'persons.id', '=', 'users.persona_id')
            ->join('departments', 'departments.id', '=', 'users.deparment_id')
            ->where('historico_mov_tarea.id_tarea','=',$id)
            ->select('persons.*','departments.*','historico_mov_tarea.*')
            ->orderBy('historico_mov_tarea.created_at', 'asc')
            ->get();

        $text_pdf = 'REPORTE_DETALLADO';

        $pdf = PDF::loadView('print.reporte_detallado', compact('historico_mov_tarea'));

        $pdf->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream($text_pdf.'.pdf');
    }

    public function imprimir_reporte_resumido(){


        $tasks = Session::get('report_resumido');

        $registrosAgrupados = $tasks->groupBy('asign_a')->map(function ($items, $key) {
            $nombreApellido = Person::find($key); 
            
            return [
                'asign_a' => $key,
                'nombre_apellido' => $nombreApellido->name.' '.$nombreApellido->last_name,
                'registros' => $items
            ];
        });
        
        $fi = Session::get('FechaInicio');
        dd($fi);
        
        $ff = Session::get('FechaFin');

        $fecha_ini = date('d/m/Y', strtotime($fi));
        $fecha_fin = date('d/m/Y', strtotime($ff));  

        $text_pdf = 'REPORTE_RESUMIDO'.'DESDE_'.$fecha_ini.'_HASTA_'.$fecha_fin;

        $pdf = PDF::loadView('print.reporte_resumido', compact('registrosAgrupados','fi','ff'));

        $pdf->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream($text_pdf.'.pdf');
    }





}
