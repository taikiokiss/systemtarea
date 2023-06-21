<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Email_configuration extends Model
{
    protected $fillable = [
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

    protected $table = 'email_configurations';
}
