<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rooms;
use App\Facilities;
use DB;

class Criterias extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'criteria_id';
	protected $fillable = [
		'facilities_id', 'criteria_1', 'criteria_2', 'criteria_3', 'criteria_4', 'criteria_5'
    ];

    public static function semua() {
        return DB::table('criterias')
                    ->join('facilities', 'criterias.facilities_id', '=', 'facilities.facilities_id')
                    ->join('rooms', 'rooms.room_id', '=', 'facilities.room_id')
                    ->select('criterias.*', 'facilities.facilities_name', 'rooms.room_name')
                    ->orderBy('criterias.criteria_id', 'ASC')
                    ->get();
    }

    public static function ambil_rooms() {
        return Rooms::semua();
    }

    public static function ambil_facilities_room($id) {
        return DB::table('facilities')
                    ->select('facilities.*')
                    ->where('facilities.room_id', $id)
                    ->get();
    }

    public static function ambil($id) {
        return DB::table('criterias')
                    ->join('facilities', 'criterias.facilities_id', '=', 'facilities.facilities_id')
                    ->join('rooms', 'rooms.room_id', '=', 'facilities.room_id')
                    ->select('criterias.*', 'facilities.facilities_name', 'facilities.room_id', 'rooms.room_name')
                    ->where('criterias.criteria_id', $id)
                    ->first();
    }

    public function criteria()
    {
        return $this->haveMany(Facilities::class);
    }
}
