<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class UserController extends Controller
{
    public function index()
    {
        $departemen = Departemen::all();
        $users = DB::table('users')->join('departemen', 'departemen.id', '=', 'users.departemen_id')->select('users.*', 'departemen.nama_departemen')->get();
        if (request()->ajax()) {
            return DataTables::of($users)
                ->addColumn(
                    'action',
                    '<div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu border">
                        <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="editFunc({{ $id }})">Edit</a></li>
                        <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="deleteFunc({{ $id }})">Delete</a>
                        </li>
                    </ul>
                </div>
                ',
                )
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('master.user.index', compact('departemen', 'users'));
    }

    public function store(Request $request)
    {
        $user_id = $request->id;

        $user = User::updateOrCreate(
            [
                'id' => $user_id,
            ],
            [
                'nama_user' => $request->nama_user,
                'departemen_id' => $request->departemen_id,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ],
        );

        return Response()->json($user);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $user = User::where($where)->first();
        Alert::success('Berhasil!');
        return Response()->json($user);
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->delete();

        return Response()->json($user);
    }
}
