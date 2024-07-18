<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use RealRashid\SweetAlert\Facades\Alert;

class AuthController extends Controller
{
    public function login()
    {
        return view('auth.login');
    }

    public function register()
    {
        return view('auth.register');
    }

    public function registerPost(Request $request)
    {
        $user = new User();
        $user->nama_user = $request->nama_user;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();
        Alert::success('Register Berhasil', 'Silahkan Login');
        return redirect('login');
    }
}
