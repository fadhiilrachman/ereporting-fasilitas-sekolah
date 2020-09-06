<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $primaryKey = 'role_id';
	public $timestamps = false;
	protected $fillable = [
		'role_name'
    ];
    
    public function getUserObject()
    {
        return $this->hasMany(User::class, 'user_id');
    }
}
