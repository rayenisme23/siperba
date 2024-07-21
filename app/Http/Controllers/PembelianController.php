<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use App\Models\Pembelian;
use App\Models\Relation_pembelian;
use App\Models\Supplier;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Facades\DataTables;

class PembelianController extends Controller
{
    public function index()
    {
        $purchase = Pembelian::latest()->first();
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
        $users = Auth::user();

        $pembelian = Pembelian::with('user', 'supplier');

        if (request()->ajax()) {
            return DataTables::of($pembelian)
                ->addColumn(
                    'action',
                    '<div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
                        Aksi
                    </button>
                    <ul class="dropdown-menu border">
                        <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="detailFunc({{ $id }})">Detail</a></li>
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
        $bahanbaku_id = $request->bahanbaku_id;
        $qty = $request->qty;
        $harga = $request->harga;
        $total = $request->total;

        $pembelian = Pembelian::create([
            'no_po' => $request->no_po,
            'supplier_id' => $request->supplier_id,
            'users_id' => Auth::user()->id,
            'subtotal' => $request->subtotal,
        ]);
        // dd($pembelian);
        for ($i = 0; $i < count($bahanbaku_id); $i++) {
            $data = new Relation_pembelian();
            $data->bahanbaku_id = $bahanbaku_id[$i];
            $data->pembelian_id = $pembelian->id;
            $data->harga = $harga[$i];
            $data->qty = $qty[$i];
            $data->total = $total[$i];
            $data->save();
        }
        return Response()->json($pembelian);
    }

    public function detail(Request $request)
    {
        $where = ['id' => $request->id];
        $permintaan = Pembelian::where($where)
            ->with(['bahanbaku', 'user', 'supplier'])
            ->first();

        if ($permintaan) {
            $data = [
                'id' => $permintaan->id,
                'nama_user' => $permintaan->user->nama_user ?? 'Tidak ditemukan',
                'nama_bahanbaku' => $permintaan->bahanbaku->nama_bahanbaku ?? 'Tidak ditemukan',
                'qty' => $permintaan->qty,
                'status' => $permintaan->status,
                'bb_stok' => $permintaan->bahanbaku->stok,
                'created_at' => $permintaan->created_at->format('d-m-Y'),
            ];
            return response()->json($data);
        } else {
            return response()->json(['error' => 'Permintaan tidak ditemukan'], 404);
        }
    }

    public function edit(Request $request)
    {
        $pembelian = Pembelian::with('user', 'supplier')
            ->where('id', $request->id)
            ->first();

        if ($pembelian) {
            // Cek apakah status pembelian memungkinkan untuk diedit
            if ($pembelian->status != 1) {
                return response()->json(['error' => 'Pembelian ini tidak dapat diedit.'], 403);
            }

            // Ambil item terkait dengan pembelian
            $items = Relation_pembelian::with('pembelian.supplier', 'pembelian.user')->where('pembelian_id', $pembelian->id)->get();
            $response = [
                'id' => $pembelian->id,
                'no_po' => $pembelian->no_po,
                'users_id' => $pembelian->users_id,
                'supplier_id' => $pembelian->supplier_id,
                'subtotal' => $pembelian->subtotal,
                'items' => $items->map(function ($item) {
                    return [
                        'bahanbaku_id' => $item->bahanbaku_id,
                        'nama_bahanbaku' => BahanBaku::find($item->bahanbaku_id)->nama_bahanbaku,
                        'qty' => $item->qty,
                        'harga' => BahanBaku::find($item->bahanbaku_id)->harga,
                        'total' => $item->total,
                    ];
                }),
            ];

            return response()->json($response);
        } else {
            return response()->json(['error' => 'Pembelian tidak ditemukan.'], 404);
        }
    }
}
