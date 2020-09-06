<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use DB;

class User extends Authenticatable
{
    use Notifiable;
    protected $primaryKey = 'user_id';
	public $timestamps = false;

    protected $fillable = [
        'name', 'role_id', 'email', 'password',
    ];

    protected $hidden = [
        'password', 'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function role()
    {
        return $this->belongsTo(Role::class, 'role_id');
    }

    public static function student_all() {
        return DB::table('users')
                    ->select('users.*')
                    ->where('users.role_id', '=', '2')
                    ->orderBy('users.user_id', 'ASC')
                    ->get();
    }

    public static function ambil($id) {
        return DB::table('users')
                    ->select('users.*')
                    ->where([
                        ['users.user_id', '=', $id],
                        ['users.role_id', '!=', '1'],
                    ])
                    ->first();
    }

    public function hasRole($roleName)
    {
        if ($this->role->role_name === $roleName) {
            return true;
        } else {
            return false;
        }
    }
}