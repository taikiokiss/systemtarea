<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Permission extends Model
{
	
    public $timestamps = true;

    protected $table = 'permissions';

    protected $fillable = ['name','guard_name'];
	
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function modelHasPermission()
    {
        return $this->hasOne('App\Models\ModelHasPermission', 'permission_id', 'id');
    }
    
    /**
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function roleHasPermission()
    {
        return $this->hasOne('App\Models\RoleHasPermission', 'permission_id', 'id');
    }
    
}
