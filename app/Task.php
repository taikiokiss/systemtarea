<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'asunto',
        'descripcion',
        'observacion',
        'fecha_entrega',
        'fecha_creacion',
        'ciclo',
        'usuario_solicitante',
        'departments_descrip',
        'estado',
        'accion',
        'entrega_real',
        'vencida'
    ];

    protected $primaryKey = 'id';
    protected $table = 'tasks';

    public function scopeFechas($query, $created_at, $updated_at){
        if($created_at && $updated_at){
          return $query
           ->whereDate('tasks.created_at','>=', $created_at)
           ->whereDate('tasks.updated_at','<=', $updated_at);
        }
      }

    
    public function scopeTareaNo($query, $ProductosNom){
        if($ProductosNom ){
          return $query
           ->where('tasks.id','=', $ProductosNom);
        }
      }

}



    
    
    
    
    
    
