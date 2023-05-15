<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Tasks_users_rl extends Model
{
    protected $fillable = [
        'id_tasks',
        'file',
        'id_users'
    ];

    protected $primaryKey = 'id';
    protected $table = 'tasks_users_rl';
}
