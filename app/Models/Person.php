<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Traits\HasRoles;

class Person extends Model
{
    use HasRoles;

    protected $fillable = [
        'name',
        'last_name',
        'cedula'
    ];

    protected $primaryKey = 'id';

    protected $table = 'persons';

    public function User()
    {
        //return $this->belongsTo('App\Models\User','id');
        return $this->belongsTo(User::class, 'id');

    }
}
