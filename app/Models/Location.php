<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Location extends Model
{
	
    public $timestamps = true;

    protected $table = 'locations';

    protected $fillable = ['name','estado'];
	
    public function User()
    {
        return $this->belongsTo(User::class, 'id');

    }


}
