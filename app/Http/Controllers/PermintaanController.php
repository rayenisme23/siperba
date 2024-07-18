<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use App\Models\Permintaan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class PermintaanController extends Controller
{
    public function index()
    {
        $bahanbaku = Bahanbaku::all();
        $users = Auth::user()->id;
        $permintaan = DB::table('permintaan')->join('users', 'users.id', '=', 'permintaan.users_id')->join('bahanbaku', 'bahanbaku.id', 'permintaan.bahanbaku_id')->select('permintaan.*', 'users.nama_user', 'bahanbaku.nama_bahanbaku')->get();

        if (request()->ajax()) {
            return DataTables::of($permintaan)
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

        return view('manajemen.permintaan.index', compact('bahanbaku', 'permintaan', 'users'));
    }

    public function store(Request $request)
    {
        $permintaan_id = $request->id;

        $permintaan = Permintaan::updateOrCreate(
            [
                'id' => $permintaan_id,
            ],
            [
                'bahanbaku_id' => $request->bahanbaku_id,
                'users_id' => $request->users_id,
                'qty' => $request->qty,
            ],
        );

        return Response()->json($permintaan);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $permintaan = Permintaan::where($where)->first();

        return Response()->json($permintaan);
    }

    public function destroy(Request $request)
    {
        $permintaan = Permintaan::where('id', $request->id)->delete();

        return Response()->json($permintaan);
    }
}
