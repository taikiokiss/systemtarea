<?php 

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Department extends Model
{
	
    public $timestamps = true;

    protected $table = 'departments';

    protected $fillable = ['namedt','estado'];
	
    public function User()
    {
        return $this->belongsTo(User::class, 'id');

    }


}
