<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rooms;
use DB;

class Facilities extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'facilities_id';
	protected $fillable = [
		'room_id', 'facilities_name'
    ];

    public static function semua() {
        return DB::table('facilities')
                    ->join('rooms', 'facilities.room_id', '=', 'rooms.room_id')
                    ->select('facilities.*', 'rooms.room_name')
                    ->orderBy('facilities.facilities_id', 'ASC')
                    ->get();
    }

    public static function ambil($id) {
        return DB::table('facilities')
                    ->join('rooms', 'facilities.room_id', '=', 'rooms.room_id')
                    ->select('facilities.*', 'rooms.room_name')
                    ->where('facilities.facilities_id', $id)
                    ->first();
    }

    public static function ambil_rooms() {
        return Rooms::semua();
    }

    public function room()
    {
        return $this->belongsTo(Rooms::class, 'room_id');
    }

    public function facilities()
    {
        return $this->haveMany(Rooms::class, 'room_id');
    }
}
