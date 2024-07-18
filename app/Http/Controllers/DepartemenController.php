<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class DepartemenController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()
                ->of(Departemen::select('*'))
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

        return view('master.departemen.index');
    }

    public function store(Request $request)
    {
        $departemen_id = $request->id;

        $departemen = Departemen::updateOrCreate(
            [
                'id' => $departemen_id,
            ],
            [
                'nama_departemen' => $request->nama_departemen,
            ],
        );

        return Response()->json($departemen);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $departemen = Departemen::where($where)->first();
        Alert::success('Berhasil!');
        return Response()->json($departemen);
    }

    public function destroy(Request $request)
    {
        $departemen = Departemen::where('id', $request->id)->delete();
        return Response()->json($departemen);
    }
}
