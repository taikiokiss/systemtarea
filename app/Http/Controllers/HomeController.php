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

        return view('home',compact('REALIZADA','APROBADA','EN_PROCESO','estados_vencidos'));
    }
}
