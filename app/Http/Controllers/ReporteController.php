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
use App\Models\Departments_descrip;

class ReporteController extends Controller
{

    
    public function report_resumido(Request $request){


        $FechaInicio = $request->get('created_at');
        $FechaFin = $request->get('updated_at');


        Session::put('FechaInicio', $FechaInicio);
        Session::put('FechaFin', $FechaFin);

        $tasks = Task::Join('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->where(function ($query) {
                $query->orWhere('departments_descrip.usuario_asignado', '=', Auth::user()->id);
            })
            ->Fechas($FechaInicio,$FechaFin)            
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip','departments_descrip.usuario_asignado as id_user_asign')
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


        $tasks = Task::Join('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
            ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
            ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
            ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
            ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
            ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
            ->Where('tasks.id', '=', $id)
            ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip','departments_descrip.usuario_asignado as id_user_asign')
            ->orderBy('tasks.created_at', 'desc')
            ->get();

        $text_pdf = 'REPORTE_DETALLADO';

        $pdf = PDF::loadView('print.reporte_detallado', compact('historico_mov_tarea','id','tasks'));

        $pdf->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream($text_pdf.'.pdf');
    }

    public function imprimir_reporte_resumido(){


        $tasks = Session::get('report_resumido');

        $registrosAgrupados = $tasks->groupBy('id_user_asign')->map(function ($items, $key) {
            $nombreApellido = Person::find($key); 
            
            return [
                'asign_a' => $key,
                'nombre_apellido' => $nombreApellido->name.' '.$nombreApellido->last_name,
                'registros' => $items
            ];
        });

        $fi = Session::get('FechaInicio');

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
