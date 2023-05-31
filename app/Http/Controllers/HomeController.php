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
        $estados = Task::whereIn('estado', ['REALIZADA',  'APROBADA'],'AND')
            ->where('asign_a','=',Auth::user()->id)
            ->get()
            ->groupBy('estado');

        $estados_vencidos = Task::where('asign_a','=',Auth::user()->id)
            ->where('vencida','=','SI')
            ->get()
            ->groupBy('estado');

        $EN_PROCESO = Task::where('asign_a','=',Auth::user()->id)
            ->where('estado','!=','REALIZADA')
            ->get()
            ->groupBy('estado');

        $REALIZADA  = $estados->get('REALIZADA') ?? collect();
        $APROBADA   = $estados->get('APROBADA') ?? collect();

        $priresta = count($REALIZADA)+count($estados_vencidos);
        $pricompr = $priresta+count($REALIZADA);
        
        if ($pricompr != 0 ) {
            $valor = ($priresta/count($REALIZADA))*100;
        }else{
            $valor = 100;
        }

        $valor_dos_deci = sprintf("%01.2f", $valor);

        return view('home',compact('REALIZADA','APROBADA','EN_PROCESO','estados_vencidos','valor_dos_deci'));
    }
}
