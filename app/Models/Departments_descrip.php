<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Departments_descrip extends Model
{
	
    public $timestamps = true;

    protected $table = 'departments_descrip';

    protected $fillable = ['departments_id','subtarea_descrip','usuario_asignado','tiempo_demora','estado','old_new'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->hasOne('App\Models\Department', 'id', 'departments_id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function user()
    {
        return $this->hasOne('App\Models\User', 'id', 'usuario_asignado');
    }
    
}
