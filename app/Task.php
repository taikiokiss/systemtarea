<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Task extends Model
{
    protected $fillable = [
        'asunto',
        'descripcion',
        'fecha_entrega',
        'department_id',
        'asign_a',
        'ciclo',
        'usuario_solicitante',
        'estado',
        'accion'
    ];

    protected $primaryKey = 'id';
    protected $table = 'tasks';
}



    
    
    
    
    
    
