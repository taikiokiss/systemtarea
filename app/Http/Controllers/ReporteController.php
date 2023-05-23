<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use PDF;

use App\Historico_mov_tarea;
use App\Task;
use App\Tasks_users_rl;
use App\User;

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
            ->where('tasks.usuario_solicitante','=',Auth::user()->id)
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

    //DETALLE DE PRODUCTOS
    public function imprimir_reporte_detallado($id){


        $sucursal = DB::table('sucursal')
            ->join('company', 'company.Comp_Id','sucursal.Comp_Id')
            ->leftjoin('factura_cabecera','factura_cabecera.Suc_Id','sucursal.Sucursal_Id')
            ->select('sucursal.*','sucursal.Direccion as SDireccion','company.*', 'company.Direccion as CDireccion', 'company.Telefono as CTelefono' , 'company.Email as CEmail')
            ->where('company.comp_Id','=',Auth::user()->company_id,'AND')
            ->where('factura_cabecera.FacCab_Id','=',$id)
            ->orderBy('sucursal.Sucurs_Descrip','ASC')
            ->get(); 

        $factura = Factura_cabecera::Join('users as a', 'a.id', 'factura_cabecera.Persona_Id')
            ->Join('persona as c', 'c.Persona_Id','a.persona_id')
            ->where('factura_cabecera.Estado','=','ACTIVO')
            ->select(
                    'factura_cabecera.*',
                    'c.Persona_nombre as nombre_cliente',
                    'c.Persona_apellido as apellido_cliente',
                    'c.Email as CEmail'
                )
            ->where('factura_cabecera.FacCab_Id','=',$id)
            ->orderBy('factura_cabecera.created_at','DESC')
            ->get(); 

        $factura_detalle = Factura_detalle::join('tipo_producto_servicio','tipo_producto_servicio.id','factura_detalle.Tipo_Prod_Servi')
            ->select('factura_detalle.*',
                    'tipo_producto_servicio.nombre')
            ->where('factura_detalle.FacCab_Id','=',$id)
            ->get();

        $factura_pago = Factura_pagos::join('forma_pago','forma_pago.FPago_Id','factura_pagos.FPago_Id')
            ->leftjoin('institucion','institucion.Institucion_id','factura_pagos.Institucion_id')
            ->leftjoin('banco','banco.Banco_Id','factura_pagos.Banco_Id')
            ->leftjoin('tarjetas','tarjetas.Taj_Id','factura_pagos.Taj_Id')
            ->select('factura_pagos.*',
                    'forma_pago.FPago_Descripcion',
                    'banco.Banco_Descripcion',
                    'tarjetas.Tarjeta_Descripcion',
                    'institucion.Institucion_Descripcion'
                )
            ->where('factura_pagos.FacCab_Id','=',$id)
            ->get();

        $factura_pago_info = DB::table('factura_pagos')
            ->select('factura_pagos.*')
            ->where('factura_pagos.FacCab_Id','=',$id)
            ->get();

        $suma[] = 0;

        foreach($factura_pago_info as $var){

            $suma[] = $var->Valor;
            
        }

        $suma_total_1 = array_sum($suma);

        $suma_total = sprintf('%.2f', $suma_total_1);


        $text_pdf = 'FACTURACION_INDIVIDUAL_DETALLE_PAGO';

        $pdf = PDF::loadView('print.listado_facturacion_individual_content', compact('factura','factura_detalle','factura_pago','sucursal','suma_total'));

        $pdf->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream($text_pdf.'.pdf');
    }

    //LISTADO DE MANTENIMIENTO
    public function imprimir_reporte_resumido(){

        $factura = Session::get('report_resumido');

        $fi = Session::get('FechaInicio');
        $ff = Session::get('FechaFin');

        $fecha_ini = date('d/m/Y', strtotime($fi));
        $fecha_fin = date('d/m/Y', strtotime($ff));  

        $text_pdf = 'REPORTE_RESUMIDO'.'DESDE_'.$fecha_ini.'_HASTA_'.$fecha_fin;

        $pdf = PDF::loadView('print.reporte_resumido', compact('factura','fi','ff'));

        $pdf->setPaper('A4', 'portrait');

        $pdf->getDomPDF()->set_option("enable_php", true);

        return $pdf->stream($text_pdf.'.pdf');
    }





}
