<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Auth;

class SettingsController extends Controller
{
    public function __construct() {
    }
    
    public function index()
    {
        $data['role'] = Auth::user()->role;
        $data['user'] = Auth::user();
        return view('settings', $data);
    }

    public function updateEmail(Request $request)
    {
        Validator::validate($request->all(), [
            'email' => ['required', 'email', 'min:5']
        ]);

        if(strcmp($request->get('email'), Auth::user()->email) == 0){
            return redirect()->back()->with("error", "Alamat email baru tidak boleh sama dengan alamat email anda sekarang");
        }

        $user = Auth::user();
        $user->email = $request->get('email');
        $user->save();

        return redirect()->back()->with("success", "Alamat email berhasil diperbarui");

    }

    public function updatePassword(Request $request)
    {
        Validator::validate($request->all(), [
            'password' => ['required', 'string', 'min:8'],
            'new_password' => ['required', 'string', 'min:8'],
            'new_password_confirm' => ['required', 'string', 'min:8', 'same:new_password']
        ]);

        if (!(Hash::check($request->get('password'), Auth::user()->password))) {
            return redirect()->back()->with("error", "Password anda sekarang tidak sama dengan password yang akan diperbarui");
        }
        
        if(strcmp($request->get('password'), $request->get('new_password')) == 0){
            return redirect()->back()->with("error", "Password baru tidak boleh sama dengan password anda sekarang");
        }

        if(!(strcmp($request->get('new_password'), $request->get('new_password_confirm'))) == 0){
            return redirect()->back()->with("error", "Password baru harus sama dengan konfirmasi password baru anda");
        }
        
        $user = Auth::user();
        $user->password = bcrypt($request->get('new_password'));
        $user->save();
            
        return redirect()->back()->with("success", "Password berhasil diperbarui");
    }

}
