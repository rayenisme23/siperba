<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use App\Models\Departemen;
use App\Models\Permintaan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
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
                        @role("Gudang")
                            <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="detailFunc({{ $id }})">Detail</a></li>
                        @endrole
                        @role("Produksi")
                        <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="editFunc({{ $id }})">Edit</a></li> 
                        <li><a class="dropdown-item d-flex align-items-center text-sm" href="javascript:void(0);" onClick="deleteFunc({{ $id }})">Delete</a>
                        </li>
                        @endrole
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
        $validator = Validator::make($request->all(), [
            'bahanbaku_id' => 'required|integer|exists:bahanbaku,id',
            'qty' => 'required|integer|min:1',
        ], [
            'bahanbaku_id.required' => 'Bahan baku harus dipilih.',
            'qty.required' => 'Kuantitas harus diisi.',
            'qty.integer' => 'Kuantitas harus berupa angka.',
            'qty.min' => 'Kuantitas harus minimal 1.',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors()
            ], 422);
        }

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

        if ($permintaan) {
            // Cek apakah status permintaan bukan 1
            if ($permintaan->status != 1) {
                return response()->json(['error' => 'Permintaan ini tidak dapat diedit.'], 403);
            }

            return response()->json($permintaan);
        } else {
            return response()->json(['error' => 'Permintaan tidak ditemukan.'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $permintaan = Permintaan::where('id', $request->id)->first();

        if ($permintaan) {

            if (in_array($permintaan->status, [2, 3])) {

                Alert::error('Gagal!', 'Permintaan dengan status "Diterima" atau "Ditolak" tidak dapat dihapus.');
                return response()->json(['error' => 'Permintaan dengan status "Diterima" atau "Ditolak" tidak dapat dihapus.'], 403);
            }

            $permintaan->delete();

            Alert::success('Berhasil!', 'Permintaan berhasil dihapus.');
            return response()->json(['message' => 'Permintaan berhasil dihapus.']);
        } else {
            Alert::error('Gagal!', 'Permintaan tidak ditemukan.');
            return response()->json(['error' => 'Permintaan tidak ditemukan.'], 404);
        }
    }

    public function detail(Request $request)
    {
        $where = ['id' => $request->id];
        $permintaan = Permintaan::where($where)
            ->with(['bahanbaku', 'user'])
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

    public function terimastatus(Request $request)
    {
        $permintaan = Permintaan::find($request->id);
        if ($permintaan) {
            // Validasi jika stok bahan baku kurang dari 50
            if ($request->status == 2) {
                $bahanbaku = Bahanbaku::find($permintaan->bahanbaku_id);
                $newStok = $bahanbaku->stok - $permintaan->qty;

                if ($newStok < 50) {
                    return response()->json(['warning' => 'Stok bahan baku kurang dari 50, tidak dapat diterima.'], 200);
                }
            }

            $permintaan->status = $request->status;
            $permintaan->save();

            // Jika status = 2, kurangi stok bahan baku
            if ($request->status == 2) {
                $bahanbaku->stok -= $permintaan->qty;
                $bahanbaku->save();
            }

            return response()->json(['success' => 'Status permintaan berhasil diperbarui.']);
        } else {
            return response()->json(['error' => 'Permintaan tidak ditemukan.'], 404);
        }
    }

    public function tolakstatus(Request $request)
    {
        $permintaan = Permintaan::find($request->id);

        if ($permintaan) {
            $permintaan->status = 3;
            $permintaan->save();

            return response()->json(['success' => 'Status permintaan berhasil diperbarui menjadi Ditolak.']);
        } else {
            return response()->json(['error' => 'Permintaan tidak ditemukan.'], 404);
        }
    }
}
