<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use DB;

class Rooms extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'room_id';
	protected $fillable = [
		'room_name'
    ];

    public static function semua() {
        return DB::table('rooms')
                    ->orderBy('rooms.room_id', 'ASC')
                    ->get();
    }

    public static function ambil($id) {
        return DB::table('rooms')
                    ->where('rooms.room_id', $id)
                    ->first();
    }

    public function getFacilitesObject()
    {
        return $this->hasMany(Facilities::class, 'facilities_id');
    }
}
