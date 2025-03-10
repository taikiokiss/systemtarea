<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Type extends Model
{
	
    public $timestamps = true;

    protected $table = 'types';

    protected $fillable = ['name','estado'];
	
    public function User()
    {
        return $this->belongsTo(User::class, 'id');

    }


}
