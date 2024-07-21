<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class ProfileController extends Controller
{
    public function edit(Request $request)
    {
        $users_id = Auth::user()->id;
        $where = ['id' => $request->$users_id];
        $user = User::where($where)->first();
        Alert::success('Berhasil!');
        return Response()->json($user);
    }
}
