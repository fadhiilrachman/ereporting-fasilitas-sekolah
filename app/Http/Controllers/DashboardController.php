<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Report;
use Auth;
use Response;

class DashboardController extends Controller
{
    public function __construct()
    {
    }

    public function index()
    {
        $data['role'] = Auth::user()->role;
        if($data['role']->role_name == 'Tata Usaha') {
            $data['total_laporan_masuk'] = Report::tu_total_laporan_masuk();
            $data['total_laporan_diproses'] = Report::tu_total_laporan_diproses();
            $data['total_laporan_belum_diproses'] = Report::tu_total_laporan_belum_diproses();
        }
        if($data['role']->role_name == 'Siswa') {
            $data['total_laporan_dibuat'] = Report::siswa_total_laporan_dibuat(Auth::user()->user_id);
            $data['total_laporan_ditinjau'] = Report::siswa_total_laporan_ditinjau(Auth::user()->user_id);
            $data['total_laporan_diterima'] = Report::siswa_total_laporan_diterima(Auth::user()->user_id);
            $data['total_laporan_ditolak'] = Report::siswa_total_laporan_ditolak(Auth::user()->user_id);
        }
        return view('dashboard', $data);
    }

    public function live_ajax() {
        $role = Auth::user()->role;
        if($role->role_name == 'Tata Usaha') {
            $data['total_laporan_masuk'] = Report::tu_total_laporan_masuk();
            $data['total_laporan_diproses'] = Report::tu_total_laporan_diproses();
            $data['total_laporan_belum_diproses'] = Report::tu_total_laporan_belum_diproses();
        } else if($role->role_name == 'Siswa') {
            $data['total_laporan_dibuat'] = Report::siswa_total_laporan_dibuat(Auth::user()->user_id);
            $data['total_laporan_ditinjau'] = Report::siswa_total_laporan_ditinjau(Auth::user()->user_id);
            $data['total_laporan_diterima'] = Report::siswa_total_laporan_diterima(Auth::user()->user_id);
            $data['total_laporan_ditolak'] = Report::siswa_total_laporan_ditolak(Auth::user()->user_id);
        }
        return Response::json($data);
    }
}
