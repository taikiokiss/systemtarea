<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Task;
use DB;
use Auth;
use Hash;

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

        $REALIZADA = $estados->filter(function ($estado) {
            return $estado->estado === 'REALIZADA';
        });        

        $APROBADA = $estados->filter(function ($estado) {
            return $estado->estado === 'APROBADA';
        });

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


    public function showChangePasswordForm(){
        return view('auth.changepassword');
    }

    public function changePassword(Request $request){

        if (!(Hash::check($request->get('current-password'), Auth::user()->password))) {
            // The passwords matches
        
        $notification=array(
            'message' => 'Su clave actual no coincide con la clave que proporciono. Intentalo de nuevo.',
            'alert-type' => 'error'
        );
            return redirect()->back()->with($notification);
        }

        if(strcmp($request->get('current-password'), $request->get('new-password')) == 0){
            $notification=array(
                'message' => 'La nueva clave no puede ser la misma que su clave actual. Por favor, elija una clave diferente.',
                'alert-type' => 'error'
            );
                return redirect()->back()->with($notification);
        }

        if(strlen($request->get('new-password')) <= 7 ){
            $notification=array(
                'message' => 'Las clave es muy pequeña, deben ser más de 8 caracteres. Intentalo de nuevo.',
                'alert-type' => 'error'
            );
                return redirect()->back()->with($notification);
        }

        if($request->get('new-password') != $request->get('new-password-confirm') ){
            $notification=array(
                'message' => 'Las claves no son las mismas. Intentalo de nuevo.',
                'alert-type' => 'error'
            );
                return redirect()->back()->with($notification);
        }

        //Change Password
        $user = Auth::user();
        $user->password = bcrypt($request->get('new-password'));
        $user->save();

        
        $notification=array(
            'message' => 'Clave cambiada con éxito!',
            'alert-type' => 'success'
        );

        return redirect()->back()->with($notification);

    }



}
