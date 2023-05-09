<?php 

namespace App\Models;

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

    protected $fillable = ['email','password','persona_id','deparment_id','group_id','estado'];
	

    public function Person()
    {
        return $this->belongsTo(Person::class, 'persona_id');
    }

    public function Department()
    {
        return $this->belongsTo(Department::class, 'deparment_id');
    }

    public function Group()
    {
        return $this->belongsTo(Group::class, 'group_id');
    }


}
