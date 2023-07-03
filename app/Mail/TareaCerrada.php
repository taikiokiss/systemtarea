<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use DB;
use App\Models\Emailconfiguration;

class TareaCerrada extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public $registros ;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($registros )
    {
        $this->registros  = $registros ;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {

        $config_data_email = Emailconfiguration::first();

        $fromAddress =    $config_data_email->from_address;
        $fromName    =    $config_data_email->from_name;
        $subject = 'TAREA CERRADA';

            $registros  = DB::table('tasks')
                ->leftJoin('users as usuarioSolici','usuarioSolici.id','tasks.usuario_solicitante')
                ->leftJoin('persons as perSoli', 'perSoli.id', '=', 'usuarioSolici.persona_id')
                ->join('departments_descrip','departments_descrip.id','tasks.deparment_descrip_id')
                ->join('departments', 'departments.id', '=', 'departments_descrip.departments_id')
                ->join('users as usuarioAsig','usuarioAsig.id','departments_descrip.usuario_asignado')
                ->join('persons as perAsig', 'perAsig.id', '=', 'usuarioAsig.persona_id')
                ->where('tasks.id','=',$this->registros)
                ->select('tasks.*','perAsig.name as NombreAsig','perAsig.last_name as ApellidoAsig','perSoli.name as NombreSoli','perSoli.last_name as ApellidoSoli','departments.namedt','departments_descrip.subtarea_descrip','usuarioAsig.email as emailAsig','usuarioSolici.email as emailSolici')
                ->orderBy('tasks.created_at', 'desc')
                ->get(); 

        return $this->view('mail.TareaCerrada')
                    ->from($fromAddress, $fromName)
                    ->subject($subject)
                    ->with([ "registr" => $registros ]);

    }
}
