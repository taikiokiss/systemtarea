<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Historico_mov_tarea extends Model
{
    protected $fillable = [
        'id_tarea',
        'observacion',
        'usuario',
        'fecha_act',
        'estado_id_tarea'
    ];

    protected $primaryKey = 'id';
    protected $table = 'historico_mov_tarea';
}
