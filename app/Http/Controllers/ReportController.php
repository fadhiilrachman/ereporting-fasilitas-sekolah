<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Report;
use Auth;
use DataTables;
use Redirect,Response,Session,DateTime;

class ReportController extends Controller
{
    public function processReport() {
        $data['role'] = Auth::user()->role;
        return view('report.tatausaha.process', $data);
    }

    public function processSelectReport(Request $request) {
        Validator::validate($request->all(), [
            'tanggal_laporan_start' => ['required', 'date'],
            'tanggal_laporan_end' => ['required', 'date'],
        ]);
        $start = date("Y-m-d", strtotime($request->input('tanggal_laporan_start')));
        $end = date("Y-m-d", strtotime($request->input('tanggal_laporan_end') . " +1 day"));
        $total_laporan = Report::whereBetween('created_at', [$start, $end])->count();
        if($total_laporan === 0) {
            return redirect()->back()->with("error", "Laporan pada tanggal {$start} sampai {$request->input('tanggal_laporan_end')} masih kosong");
            exit;
        }
        $cek_laporan = Report::whereIn('status', ['under_review'])->whereBetween('created_at', [$start, $end])->count();
        if($cek_laporan == 0) {
            return redirect()->back()->with("error", "Laporan pada tanggal {$start} sampai {$request->input('tanggal_laporan_end')} sudah pernah diproses");
            exit;
        }
        // Bobot tiap kriteria
        // Sangat rendah: 10%
        // Rendah       : 15%
        // Sedang       : 20%
        // Tinggi       : 25%
        // Sangat tinggi: 30%
        $bobot = array(0.10, 0.15, 0.20, 0.25, 0.30);
        $laporans = Report::ambil_laporan_by_tanggal($start, $end);
        $minMax = Report::ambil_minmax_laporan_tanggal($start, $end)[0];
        $normalisasi_all = array();
        foreach ($laporans as $laporan) {
            $report_id = $laporan->report_id;
            $criteria_1 = $laporan->criteria_1;
            $criteria_2 = $laporan->criteria_2;
            $criteria_3 = $laporan->criteria_3;
            $criteria_4 = $laporan->criteria_4;
            $criteria_5 = $laporan->criteria_5;
            // Melakukan normalisasi tiap laporan
            // Rumus Normalisasi: (Yang digunakan adalah Benefit)
            // - Benefit: $criteria_x / $minMax->max_criteria_x;
            // - Cost: $minMax->min_criteria_x / $criteria_x;
            $n_criteria_1 = $criteria_1 / $minMax->max_criteria_1;
            $n_criteria_2 = $criteria_2 / $minMax->max_criteria_2;
            $n_criteria_3 = $criteria_3 / $minMax->max_criteria_3;
            $n_criteria_4 = $criteria_4 / $minMax->max_criteria_4;
            $n_criteria_5 = $criteria_5 / $minMax->max_criteria_5;
            // Rumus: (normalisasi * bobot)
            $saw_point = round(
                ($n_criteria_1*$bobot[0]+
                $n_criteria_2*$bobot[1]+
                $n_criteria_3*$bobot[2]+
                $n_criteria_4*$bobot[3]+
                $n_criteria_5*$bobot[4])
            , 3);
            $data = array(
                'report_id' => $report_id,
                'point' => round($saw_point, 3),
                'criteria' => array(
                    'criteria_1' => $criteria_1,
                    'criteria_2' => $criteria_2,
                    'criteria_3' => $criteria_3,
                    'criteria_4' => $criteria_4,
                    'criteria_5' => $criteria_5,
                ),
                'minMax' => array(
                    'criteria_1' => $minMax->max_criteria_1,
                    'criteria_2' => $minMax->max_criteria_2,
                    'criteria_3' => $minMax->max_criteria_3,
                    'criteria_4' => $minMax->max_criteria_4,
                    'criteria_5' => $minMax->max_criteria_5,
                ),
                'bobot' => array(
                    'criteria_1' => $bobot[0],
                    'criteria_2' => $bobot[1],
                    'criteria_3' => $bobot[2],
                    'criteria_4' => $bobot[3],
                    'criteria_5' => $bobot[4],
                ),
                'normalisasi' => array(
                    'criteria_1' => $n_criteria_1,
                    'criteria_2' => $n_criteria_2,
                    'criteria_3' => $n_criteria_3,
                    'criteria_4' => $n_criteria_4,
                    'criteria_5' => $n_criteria_5,
                ),
                'ranking' => array(
                    'criteria_1' => round($n_criteria_1*($bobot[0]), 3),
                    'criteria_2' => round($n_criteria_2*($bobot[1]), 3),
                    'criteria_3' => round($n_criteria_3*($bobot[2]), 3),
                    'criteria_4' => round($n_criteria_4*($bobot[3]), 3),
                    'criteria_5' => round($n_criteria_5*($bobot[4]), 3),
                )
            );
            $normalisasi_all[] = $data;
        }
        $normalisasi_all = collect($normalisasi_all)->sortByDesc('point')->toArray();
        $nomor = 1;
        foreach ($normalisasi_all as $key => $value) {
            if($nomor === 1) {
                Report::where('report_id', $value['report_id'])->update(array('status' => 'accepted'));
            } else {
                Report::where('report_id', $value['report_id'])->update(array('status' => 'rejected'));
            }
            $nomor++;
        }
        return redirect()->back()->with("success", "Laporan pada tanggal {$start} sampai {$request->input('tanggal_laporan_end')} berhasil diproses");
    }

    public function viewReport() {
        $data['role'] = Auth::user()->role;
        return view('report.tatausaha.rekap', $data);
    }

    public function createNewView() {
        $data['role'] = Auth::user()->role;
        return view('report.student.create_new', $data);
    }

    public function historyView() {
        $data['role'] = Auth::user()->role;
        return view('report.student.history', $data);
    }

    public function revokeReportJson($id) {
        $report = Report::where('report_id', $id)->delete();
        Session::flash('success', 'Laporan anda berhasil dicabut');
        return Response::json($report);
    }

    public function createNewReport(Request $request) {
        Validator::validate($request->all(), [
            'room_id' => ['required', 'string'],
            'facilities_id' => ['required', 'string'],
            'criteria'    => ['required', 'array'],
            "criteria.*" => ['required', 'integer', 'min:1', 'in:10,40,50'],
        ]);
        // inisialisasi
        date_default_timezone_set('Asia/Jakarta');
        $dateTime = new DateTime();
        $weekdayStartTime = new DateTime('05:00');
        $weekdayEndTime = new DateTime('16:00');
        $dayOfTheWeek = intval($dateTime->format('N'));
        // cek hari senin - jum'at
        // 1-5 = Senin - jum'at
        // 6-7 = Sabtu, minggu
        if ($dayOfTheWeek === 6 || $dayOfTheWeek === 7) {
            return redirect()->back()->with("error", "Lapor kerusakan hanya dapat diakses pada hari Senin - Jumat");
            exit;
        }
        // cek jam 5.00 - 16.00 WIB
        $isOpen = $dateTime > $weekdayStartTime && $dateTime < $weekdayEndTime;
        if (!$isOpen) {
            return redirect()->back()->with("error", "Lapor kerusakan sudah ditutup pada hari ini, kembali dibuka pada jam 05.00 - 16.00 WIB");
            exit;
        }
        $criteria = $request->input('criteria');
        $data=array();
        $data['user_id']=Auth::user()->user_id;
        $data['facilities_id']=$request->input('facilities_id');
        for ($i=0; $i < 5; $i++) { 
            $data['criteria_' . ($i+1)] = '1';
            if ( isset($criteria[$i]) ) {
                $data['criteria_' . ($i+1)] = $criteria[$i];
            }
        }
        $data['status']='under_review';
        Report::create($data);
        return redirect()->back()->with("success", "Laporan anda berhasil dibuat dan segera ditinjau oleh Tata Usaha Sekolah");
    }

    public function getStudentReportsJson() {
        $reports=Report::ambil_report_student( Auth::user()->user_id );
        return Datatables::of($reports)->make(true);
    }

    public function getRekapReportsJson(Request $request) {
        $status = $request->input('status');
        $dt = new DateTime();
        $tanggal_laporan_start = $request->input('tanggal_laporan_start');
        $tanggal_laporan_end = $request->input('tanggal_laporan_end');
        $sort_by = $request->input('sort_by');
        if($request->input('tanggal_laporan_start') == '') {
            $tanggal_laporan_start = $dt->format('Y-m-d');
        }
        if($request->input('tanggal_laporan_end') == '') {
            $tanggal_laporan_end = $dt->format('Y-m-d');
        }
        if($request->input('sort_by') == '') {
            $sort_by = 'desc';
        }
        $start = date("Y-m-d", strtotime($tanggal_laporan_start));
        $end = date("Y-m-d", strtotime($tanggal_laporan_end . " +1 day"));
        $reports=Report::ambil_rekap_laporan($start, $end, $status, $sort_by);
        return Datatables::of($reports)->make(true);
    }
    
    public function reportGetRoomsJson()
    {
        $report=Report::ambil_rooms();
        return Response::json($report);
    }

    public function reportGetRoomFacilitiesJson($id)
    {
        $report=Report::ambil_facilities_room($id);
        return Response::json($report);
    }

    public function reportGetCriteriasFacilitiesJson($id)
    {
        $report=Report::ambil_criterias_facilities($id);
        return Response::json($report);
    }
}
