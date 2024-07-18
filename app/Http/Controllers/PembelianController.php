<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use App\Models\Pembelian;
use App\Models\PurchaseOrder;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index()
    {
        $tanggal = $purchase = Pembelian::latest()->first();
        $first = 'PO';
        $tahun = date('mY');
        if ($purchase == null) {
            $nomor = '0001';
        } else {
            $nomor = substr($purchase->no_po, 8, 4) + 1;
            $nomor = str_pad($nomor, 4, '0', STR_PAD_LEFT);
        }
        $no_po = $first . $tahun . $nomor;
        $bahanbaku = Bahanbaku::all();
        $supplier = Supplier::all();
        $users = Auth::user()->id;

        $pembelian = DB::table('pembelian')->join('users', 'users.id', '=', 'pembelian.users_id')->join('bahanbaku', 'bahanbaku.id', 'pembelian.bahanbaku_id')->join('supplier', 'supplier.id', 'pembelian.supplier_id')->select('pembelian.*', 'users.nama_user', 'bahanbaku.nama_bahanbaku', 'bahanbaku.harga', 'supplier.nama_supplier')->get();

        if (request()->ajax()) {
            return DataTables::of($pembelian)
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

        return view('manajemen.pembelian.index', compact('bahanbaku', 'pembelian', 'users', 'supplier', 'no_po'));
    }

    public function store(Request $request)
    {
        $pembelian_id = $request->id;

        $pembelian = Pembelian::updateOrCreate(
            [
                'id' => $pembelian_id,
            ],
            [
                'no_po' => $request->no_po,
                'bahanbaku_id' => $request->bahanbaku_id,
                'supplier_id' => $request->supplier_id,
                'users_id' => $request->users_id,
                'qty' => $request->qty,
                'subtotal' => $request->subtotal,
            ],
        );

        return Response()->json($pembelian);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $pembelian = Pembelian::where($where)->first();

        return Response()->json($pembelian);
    }

    public function destroy(Request $request)
    {
        $pembelian = Pembelian::where('id', $request->id)->delete();
        return Response()->json($pembelian);
    }

    public function bahanBaku($id)
    {
        $bahanbaku = Bahanbaku::where('id', $id)->get();
        return Response()->json($bahanbaku);
    }

    public function supplier($id)
    {
        $supplier = Supplier::where('id', $id)->get();
        return Response()->json($supplier);
    }

    public function simpan(Request $request)
    {
        $no_po = $request->no_po;
        $bahanbaku_id = $request->bahanbaku_id;
        $supplier_id = $request->supplier_id;
        $qty = $request->qty;
        $harga = $request->harga;
        $subtotal = $request->subtotal;
        $users_id = $request->users_id;

        for ($i = 0; $i < count($bahanbaku_id); $i++) {
            $data = new Pembelian();
            $data->no_po = $no_po;
            $data->users_id = $users_id;
            $data->bahanbaku_id = $bahanbaku_id[$i];
            $data->supplier_id = $supplier_id[$i];
            $data->qty = $qty[$i];
            $data->harga = $harga[$i];
            $data->subtotal = $subtotal[$i];
            $data->purchaseorder()->saveMany($data->no_po);
        }
        $success = Alert::success('Success Title', 'Success Message');
        return Response()->json($success);
    }

    public function create()
    {
        $tanggal = $purchase = Pembelian::latest()->first();
        $first = 'PO';
        $tahun = date('mY');
        if ($purchase == null) {
            $nomor = '0001';
        } else {
            $nomor = substr($purchase->no_po, 8, 4) + 1;
            $nomor = str_pad($nomor, 4, '0', STR_PAD_LEFT);
        }
        $no_po = $first . $tahun . $nomor;
        $bahanbaku = Bahanbaku::all();
        $supplier = Supplier::all();
        $users = Auth::user()->id;

        $pembelian = DB::table('pembelian')->join('users', 'users.id', '=', 'pembelian.users_id')->join('bahanbaku', 'bahanbaku.id', 'pembelian.bahanbaku_id')->join('supplier', 'supplier.id', 'pembelian.supplier_id')->select('pembelian.*', 'users.nama_user', 'bahanbaku.nama_bahanbaku', 'bahanbaku.harga', 'supplier.nama_supplier')->get();

        return view('manajemen.pembelian.create', compact('no_po', 'bahanbaku', 'supplier', 'users', 'pembelian'));
    }
}
