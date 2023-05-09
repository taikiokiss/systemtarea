<?php

namespace App;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{

    use Notifiable;
    use HasRoles;

    public $timestamps = true;
    
    protected $primaryKey = 'id';

    protected $table = 'users';

    protected $fillable = ['email','password','persona_id','estado'];


    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];
    

    public function Person()
    {
        return $this->belongsTo('App\Models\Person', 'persona_id');
    }
}

