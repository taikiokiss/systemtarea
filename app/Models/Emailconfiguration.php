<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Emailconfiguration extends Model
{
    protected $fillable = [
        'transport',
        'mailer',
        'host',
        'port',
        'username',
        'password',
        'encryption',
        'from_address',
        'from_name'
    ];

    protected $primaryKey = 'id';

    protected $table = 'emailconfigurations';
}
