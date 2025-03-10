<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Inventory extends Model
{
	
    public $timestamps = true;

    protected $table = 'inventorys';

    protected $fillable = ['name','type','serial','modelo','location','description','estado','user_create'];
	
    public function User()
    {
        return $this->belongsTo(User::class, 'id');

    }


}
