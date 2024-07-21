<?php

namespace App\Http\Controllers;

use App\Models\Bahanbaku;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Illuminate\Support\Str;

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
        $validator = Validator::make(
            $request->all(),
            [
                'nama_bahanbaku' => 'required|string|max:255',
                'harga' => 'required|numeric|min:0',
                'satuan' => 'required|string|max:50',
                'stok' => 'required|integer|min:0',
                'tgl_exp' => 'nullable|date',
                'foto_bahanbaku' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'nama_bahanbaku.required' => 'Nama bahan baku harus diisi.',
                'nama_bahanbaku.string' => 'Nama bahan baku harus berupa teks.',
                'nama_bahanbaku.max' => 'Nama bahan baku tidak boleh lebih dari :max karakter.',
                'harga.required' => 'Harga bahan baku harus diisi.',
                'harga.numeric' => 'Harga harus berupa angka.',
                'harga.min' => 'Harga tidak boleh kurang dari :min.',
                'satuan.required' => 'Satuan harus diisi.',
                'satuan.string' => 'Satuan harus berupa teks.',
                'satuan.max' => 'Satuan tidak boleh lebih dari :max karakter.',
                'stok.required' => 'Stok harus diisi.',
                'stok.integer' => 'Stok harus berupa angka bulat.',
                'stok.min' => 'Stok tidak boleh kurang dari :min.',
                'tgl_exp.date' => 'Tanggal expired tidak valid.',
                'foto_bahanbaku.required' => 'Foto bahan baku harus diunggah.',
                'foto_bahanbaku.image' => 'File yang diunggah harus berupa gambar.',
                'foto_bahanbaku.mimes' => 'Foto bahan baku harus berformat jpeg, png, atau jpg.',
                'foto_bahanbaku.max' => 'Ukuran foto bahan baku tidak boleh lebih dari :max kilobyte.',
            ],
        );

        if ($validator->fails()) {
            return response()->json(
                [
                    'errors' => $validator->errors(),
                ],
                422,
            );
        }

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

        if ($request->hasFile('foto_bahanbaku')) {
            $nama_foto = Str::slug($request->nama_bahanbaku, '_');
            $extension = $request->file('foto_bahanbaku')->getClientOriginalExtension();
            $fileName = $nama_foto . '.' . $extension;
            $bahanbaku->foto_bahanbaku = $fileName;
            $request->file('foto_bahanbaku')->move(public_path('build/images/bahanbaku'), $fileName);
        }

        $bahanbaku->save();
        return Response()->json($bahanbaku);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $bahanbaku = Bahanbaku::where($where)->first();

        if ($bahanbaku) {
            // If there's a new file upload, handle it
            if ($request->hasFile('image')) {
                // Delete old image
                $oldImage = $bahanbaku->foto_bahanbaku;
                $oldImagePath = public_path('build/images/bahanbaku/') . $oldImage;
                if (file_exists($oldImagePath) && $oldImage !== 'default.jpg') {
                    unlink($oldImagePath);
                }

                // Upload new image
                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('build/images/bahanbaku/'), $imageName);

                // Update image data in database
                $bahanbaku->foto_bahanbaku = $imageName;
            }

            $data = [
                'id' => $bahanbaku->id,
                'nama_bahanbaku' => $bahanbaku->nama_bahanbaku,
                'foto_bahanbaku' => $bahanbaku->foto_bahanbaku,
                'harga' => $bahanbaku->harga,
                'stok' => $bahanbaku->stok,
                'tgl_exp' => $bahanbaku->tgl_exp,
                'satuan' => $bahanbaku->satuan
            ];

            return response()->json($data);
        } else {
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $bahanbaku = Bahanbaku::where('id', $request->id)->first();

        if ($bahanbaku) {
            // Simpan nama file foto
            $fotoBahanbaku = $bahanbaku->foto_bahanbaku;

            // Hapus data bahan baku
            $bahanbaku->delete();

            // Hapus file foto dari sistem file
            $imagePath = public_path('build/images/bahanbaku/') . $fotoBahanbaku;
            if (file_exists($imagePath)) {
                unlink($imagePath);
            }

            return response()->json($bahanbaku);
        }
    }
}
