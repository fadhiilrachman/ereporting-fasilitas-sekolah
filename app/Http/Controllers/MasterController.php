<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Auth;
use App\User;
use App\Rooms;
use App\Facilities;
use App\Criterias;
use DataTables;
use Redirect,Response;

class MasterController extends Controller
{
    public function __construct()
    {
    }

    public function roomsViewJson()
    {
        if(request()->ajax()) {
            $q_rooms=Rooms::all();
            return Datatables::of($q_rooms)
                ->make(true);
        }
    }

    public function roomsEditJson($id)
    {
        $room  = Rooms::ambil($id);
        return Response::json($room);
    }

    public function roomsStoreJson(Request $request)
    {
        $room   = Rooms::updateOrCreate(
                    ['room_id' => $request->room_id],
                    ['room_name' => $request->room_name]
                );
        return Response::json($room);
    }

    public function roomsDestroyJson($id)
    {
        $room = Rooms::where('room_id',$id)->delete();
        return Response::json($room);
    }

    public function roomsView()
    {
        $data['role'] = Auth::user()->role;
        return view('master.rooms.view', $data);
    }

    public function facilitiesViewJson()
    {
        if(request()->ajax()) {
            $q_facilities=Facilities::semua();
            return Datatables::of($q_facilities)->make(true);
        }
    }

    public function facilitiesGetRoomsJson()
    {
        $facilities=Facilities::ambil_rooms();
        return Response::json($facilities);
    }

    public function facilitiesEditJson($id)
    {
        $facilities=Facilities::ambil($id);
        return Response::json($facilities);
    }

    public function facilitiesStoreJson(Request $request)
    {
        $facilities   = Facilities::updateOrCreate(
                    ['facilities_id' => $request->facilities_id],
                    ['room_id' => $request->room_id,
                    'facilities_name' => $request->facilities_name]
                );
        return Response::json($facilities);
    }

    public function facilitiesDestroyJson($id)
    {
        $facilities = Facilities::where('facilities_id',$id)->delete();
        return Response::json($facilities);
    }

    public function facilitiesView()
    {
        $data['role'] = Auth::user()->role;
        return view('master.facilities.view', $data);
    }

    public function criteriasViewJson()
    {
        $q_criterias=Criterias::semua();
        return Datatables::of($q_criterias)->make(true);
    }

    public function criteriasView()
    {
        $data['role'] = Auth::user()->role;
        return view('master.criterias.view', $data);
    }

    public function criteriasEditJson($id)
    {
        $criterias=Criterias::ambil($id);
        return Response::json($criterias);
    }

    public function criteriasStoreJson(Request $request)
    {
        $criterias   = Criterias::updateOrCreate(
                    ['criteria_id' => $request->criteria_id],
                    ['room_id' => $request->room_id,
                    'facilities_id' => $request->facilities_id,
                    'criteria_1' => $request->criteria_1,
                    'criteria_2' => $request->criteria_2,
                    'criteria_3' => $request->criteria_3,
                    'criteria_4' => $request->criteria_4,
                    'criteria_5' => $request->criteria_5]
                );
        return Response::json($criterias);
    }

    public function criteriasDestroyJson($id)
    {
        $criterias = Criterias::where('criteria_id',$id)->delete();
        return Response::json($criterias);
    }

    public function criteriasGetRoomsJson()
    {
        $criterias=Criterias::ambil_rooms();
        return Response::json($criterias);
    }

    public function criteriasGetRoomFacilitiesJson($id)
    {
        $criterias=Criterias::ambil_facilities_room($id);
        return Response::json($criterias);
    }

    public function studentViewJson()
    {
        return Datatables::of(User::student_all())->make(true);
    }

    public function studentView()
    {
        $data['role'] = Auth::user()->role;
        return view('master.student.view', $data);
    }

    public function studentEditJson($id)
    {
        $student=User::ambil($id);
        return Response::json($student);
    }

    public function studentStoreJson(Request $request)
    {
        $student   = User::updateOrCreate(
                    ['user_id' => $request->user_id],
                    ['role_id' => '2',
                    'name' => $request->name,
                    'email' => $request->email,
                    'password' => Hash::make($request->password),
                    ]
                );
        return Response::json($student);
    }

    public function studentDestroyJson($id)
    {
        $student = User::where('user_id',$id)->delete();
        return Response::json($student);
    }

}
