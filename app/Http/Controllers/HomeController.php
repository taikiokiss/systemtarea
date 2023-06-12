<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use DB;
use Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }


 
    public function index(Request $request)
    {
        $estados = Task::join('departments_descrip', 'departments_descrip.id', '=', 'tasks.deparment_descrip_id')
            ->whereIn('tasks.estado', ['REALIZADA', 'APROBADA'])
            ->where('departments_descrip.usuario_asignado', '=', Auth::user()->id)
            ->select('tasks.estado')
            ->get();

        $estados_vencidos = Task::join('departments_descrip', 'departments_descrip.id', '=', 'tasks.deparment_descrip_id')
            ->where('departments_descrip.usuario_asignado', '=', Auth::user()->id)
            ->where('tasks.vencida','=','SI')
            ->select('tasks.estado')
            ->get();

        $EN_PROCESO = Task::join('departments_descrip', 'departments_descrip.id', '=', 'tasks.deparment_descrip_id')
            ->where('departments_descrip.usuario_asignado', '=', Auth::user()->id)
            ->where('tasks.estado','!=','REALIZADA')
            ->where('tasks.estado','!=','ANULADA')
            ->select('tasks.estado')
            ->get();

        $REALIZADA = $estados->get('REALIZADA') ?? collect();
        $APROBADA = $estados->get('APROBADA') ?? collect();

        $priresta = count($REALIZADA) + count($estados_vencidos);
        $pricompr = $priresta + count($REALIZADA);

        $valor = 100;
        if (count($REALIZADA) > 0 && $pricompr != 0) {
            $valor = ($priresta / count($REALIZADA)) * 100;
        }

        $valor_dos_deci = sprintf("%01.2f", $valor);
        if (count($REALIZADA) > 0) {
            $valor_dos_deci = sprintf("%01.2f", $valor);
        } elseif(count($REALIZADA) == 0 && count($APROBADA) == 0 && count($EN_PROCESO) == 0 && count($estados_vencidos) == 0) {
            $valor_dos_deci = sprintf("%01.2f", 100);
        }else{
            $valor_dos_deci = sprintf("%01.2f", 0);
        }

        return view('home', compact('REALIZADA', 'APROBADA', 'EN_PROCESO', 'estados_vencidos', 'valor_dos_deci'));




    }


}
