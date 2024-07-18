<?php

namespace App\Http\Controllers;

use App\Models\Supplier;
use Illuminate\Http\Request;
use RealRashid\SweetAlert\Facades\Alert;

class SupplierController extends Controller
{
    public function index()
    {

        if (request()->ajax()) {
            return datatables()
                ->of(Supplier::select('*'))
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

        return view('master.supplier.index');
    }

    public function store(Request $request)
    {
        $supplier_id = $request->id;

        $supplier = Supplier::updateOrCreate(
            [
                'id' => $supplier_id,
            ],
            [
                'nama_supplier' => $request->nama_supplier,
                'supplier_id' => $request->supplier_id,
                'email' => $request->email,
                'no_hp' => $request->no_hp,
                'alamat' => $request->alamat,
            ],
        );

        return Response()->json($supplier);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $supplier = Supplier::where($where)->first();
        Alert::success('Berhasil!');
        return Response()->json($supplier);
    }

    public function destroy(Request $request)
    {
        $supplier = Supplier::where('id', $request->id)->delete();

        return Response()->json($supplier);
    }
}
