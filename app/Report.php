<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use App\Rooms;
use App\Facilities;
use DB;

class Report extends Model
{
    public $timestamps = false;
    protected $primaryKey = 'report_id';
	protected $fillable = [
        'user_id', 'facilities_id', 'criteria_1', 'criteria_2', 'criteria_3', 'criteria_4', 'criteria_5', 'status'
    ];

    public static function ambil_rooms() {
        return Rooms::semua();
    }

    public static function ambil_facilities_room($id) {
        return DB::table('facilities')
                    ->select('facilities.*')
                    ->where('facilities.room_id', $id)
                    ->get();
    }

    public static function tu_total_laporan_masuk() {
        return DB::table('reports')
            ->count();
    }

    public static function tu_total_laporan_diproses() {
        return DB::table('reports')
            ->whereIn('reports.status', ['accepted', 'rejected'])
            ->count();
    }

    public static function tu_total_laporan_belum_diproses() {
        return DB::table('reports')
            ->where([
                'reports.status' => 'under_review'
            ])
            ->count();
    }

    public static function siswa_total_laporan_dibuat($id) {
        return DB::table('reports')
            ->where([
                'reports.user_id' => $id
            ])
            ->count();
    }

    public static function siswa_total_laporan_ditinjau($id) {
        return DB::table('reports')
            ->where([
                'reports.user_id' => $id,
                'reports.status' => 'under_review'
            ])
            ->count();
    }

    public static function siswa_total_laporan_diterima($id) {
        return DB::table('reports')
            ->where([
                'reports.user_id' => $id,
                'reports.status' => 'accepted'
            ])
            ->count();
    }

    public static function siswa_total_laporan_ditolak($id) {
        return DB::table('reports')
            ->where([
                'reports.user_id' => $id,
                'reports.status' => 'rejected'
            ])
            ->count();
    }

    public static function ambil_criterias_facilities($id) {
        return DB::table('criterias')
                    ->join('facilities', 'criterias.facilities_id', '=', 'facilities.facilities_id')
                    ->join('rooms', 'rooms.room_id', '=', 'facilities.room_id')
                    ->select('criterias.*')
                    ->where('criterias.criteria_id', $id)
                    ->first();
    }

    public static function ambil_report_student($id) {
        return DB::table('reports')
                    ->join('criterias', 'reports.facilities_id', '=', 'criterias.facilities_id')
                    ->join('facilities', 'reports.facilities_id', '=', 'facilities.facilities_id')
                    ->join('rooms', 'rooms.room_id', '=', 'facilities.room_id')
                    ->select('reports.*', 'facilities.facilities_name', 'facilities.room_id', 'rooms.room_name',
                    DB::raw('(CASE WHEN reports.criteria_1 > 1 THEN criterias.criteria_1 END) AS criteria_1'),
                    DB::raw('(CASE WHEN reports.criteria_2 > 1 THEN criterias.criteria_2 END) AS criteria_2'),
                    DB::raw('(CASE WHEN reports.criteria_3 > 1 THEN criterias.criteria_3 END) AS criteria_3'),
                    DB::raw('(CASE WHEN reports.criteria_4 > 1 THEN criterias.criteria_4 END) AS criteria_4'),
                    DB::raw('(CASE WHEN reports.criteria_5 > 1 THEN criterias.criteria_5 END) AS criteria_5')
                    )
                    ->where('reports.user_id', $id)
                    ->orderBy('reports.report_id', 'DESC')
                    ->get();
    }

    public static function ambil_rekap_laporan($tanggal_laporan_start, $tanggal_laporan_end, $status, $sort_by) {
        $query = DB::table('reports')
                    ->join('users', 'reports.user_id', '=', 'users.user_id')
                    ->join('criterias', 'reports.facilities_id', '=', 'criterias.facilities_id')
                    ->join('facilities', 'reports.facilities_id', '=', 'facilities.facilities_id')
                    ->join('rooms', 'rooms.room_id', '=', 'facilities.room_id')
                    ->select('reports.report_id', 'reports.created_at', 'reports.status', 'users.name', 'facilities.facilities_name', 'facilities.room_id', 'rooms.room_name',
                        DB::raw('(CASE WHEN reports.criteria_1 > 1 THEN criterias.criteria_1 END) AS criteria_1'),
                        DB::raw('(CASE WHEN reports.criteria_2 > 1 THEN criterias.criteria_2 END) AS criteria_2'),
                        DB::raw('(CASE WHEN reports.criteria_3 > 1 THEN criterias.criteria_3 END) AS criteria_3'),
                        DB::raw('(CASE WHEN reports.criteria_4 > 1 THEN criterias.criteria_4 END) AS criteria_4'),
                        DB::raw('(CASE WHEN reports.criteria_5 > 1 THEN criterias.criteria_5 END) AS criteria_5')
                    );
        if($status!==null&&$status!=='semua') {
            $query->where('status', $status);
        }
        $query->whereBetween('created_at', [$tanggal_laporan_start, $tanggal_laporan_end])
            ->orderBy('reports.created_at', $sort_by)
            ->get();
        return $query;
    }

    public static function ambil_laporan_by_tanggal($tanggal_laporan_start, $tanggal_laporan_end) {
        return DB::table('reports')
                    ->select('report_id', 'criteria_1', 'criteria_2', 'criteria_3', 'criteria_4', 'criteria_5')
                    ->whereBetween('created_at', [$tanggal_laporan_start, $tanggal_laporan_end])
                    ->whereIn('status', ['under_review'])
                    ->get();
    }

    public static function ambil_minmax_laporan_tanggal($tanggal_laporan_start, $tanggal_laporan_end) {
        return DB::table('reports')
                    ->select(
                        DB::raw('MAX(criteria_1) as max_criteria_1'),
                        DB::raw('MAX(criteria_2) as max_criteria_2'),
                        DB::raw('MAX(criteria_3) as max_criteria_3'),
                        DB::raw('MAX(criteria_4) as max_criteria_4'),
                        DB::raw('MAX(criteria_5) as max_criteria_5'),
                        DB::raw('MIN(criteria_1) as min_criteria_1'),
                        DB::raw('MIN(criteria_2) as min_criteria_2'),
                        DB::raw('MIN(criteria_3) as min_criteria_3'),
                        DB::raw('MIN(criteria_4) as min_criteria_4'),
                        DB::raw('MIN(criteria_5) as min_criteria_5')
                    )
                    ->whereBetween('created_at', [$tanggal_laporan_start, $tanggal_laporan_end])
                    ->whereIn('status', ['under_review'])
                    ->get();
    }

}