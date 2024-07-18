<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class BahanbakuController extends Controller
{
    public function index()
    {
        if (request()->ajax()) {
            return datatables()
                ->of(Bahanbaku::select('*'))
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

        return view('master.bahanbaku.index');
    }

    public function store(Request $request)
    {
        $bahanbaku_id = $request->id;

        $bahanbaku = Bahanbaku::updateOrCreate(
            [
                'id' => $bahanbaku_id,
            ],
            [
                'nama_bahanbaku' => $request->nama_bahanbaku,
                'harga' => $request->harga,
                'satuan' => $request->satuan,
                'stok' => $request->stok,
                'tgl_exp' => $request->tgl_exp,
            ],
        );

        return Response()->json($bahanbaku);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $bahanbaku = Bahanbaku::where($where)->first();
        Alert::success('Berhasil!');
        return Response()->json($bahanbaku);
    }

    public function destroy(Request $request)
    {
        $bahanbaku = Bahanbaku::where('id', $request->id)->delete();

        return Response()->json($bahanbaku);
    }
}
