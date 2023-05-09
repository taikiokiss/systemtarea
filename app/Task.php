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
        'ciclo',
        'usuario_solicitante'
    ];

    protected $primaryKey = 'id';
    protected $table = 'taks';
}



    
    
    
    
    
    
