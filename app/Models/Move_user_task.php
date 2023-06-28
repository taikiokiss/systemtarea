<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Move_user_task extends Model
{
    protected $fillable = [
        'id_tarea',
        'id_usuario_movimiento',
        'accion',
        'fecha_movimiento'
    ];

    protected $primaryKey = 'id';
    protected $table = 'move_user_tasks';
}
