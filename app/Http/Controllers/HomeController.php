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
        $estados = Task::whereIn('estado', ['REALIZADA', 'ENTREGADA', 'APROBADA', 'RECHAZADA', 'EN PROCESO'],'AND')
            ->where('usuario_solicitante','=',Auth::user()->id)
            ->get()
            ->groupBy('estado');
            
        $REALIZADA = $estados->get('REALIZADA') ?? collect();
        $ENTREGADA = $estados->get('ENTREGADA') ?? collect();
        $APROBADA = $estados->get('APROBADA') ?? collect();
        $RECHAZADA = $estados->get('RECHAZADA') ?? collect();
        $EN_PROCESO = $estados->get('EN PROCESO') ?? collect();

        return view('home',compact('REALIZADA','ENTREGADA','APROBADA','RECHAZADA','EN_PROCESO'));
    }
}
