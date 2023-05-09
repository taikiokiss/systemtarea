<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
	
    public $timestamps = true;

    protected $table = 'groups';

    protected $fillable = ['name','jefe_grupo','miembro_grupo'];
	
    public function User()
    {
        return $this->belongsTo(User::class, 'id');

    }


}
