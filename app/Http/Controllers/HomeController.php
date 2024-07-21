<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    // public function __construct()
    // {
    //     $this->middleware('auth');
    // }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('index');
    }

    public function profile()
    {
        $departemen = Departemen::all();
        $users_id = Auth::user()->id;
        $users = DB::table('users')->join('departemen', 'departemen.id', '=', 'users.departemen_id')->select('users.*', 'departemen.nama_departemen')->where('users.id', $users_id)->first();
        return view('user-profile', compact('departemen', 'users'));
    }

    public function root(Request $request)
    {
        if (view()->exists($request->path())) {
            return view($request->path());
        } else {
            return abort(404);
        }
    }
}
