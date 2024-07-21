<?php

namespace App\Http\Controllers;

use App\Models\Departemen;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use RealRashid\SweetAlert\Facades\Alert;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Str;

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
        $validator = Validator::make(
            $request->all(),
            [
                'nama_user' => 'required|string|max:75',
                'departemen_id' => 'required|integer|exists:departemen,id',
                'email' => 'required|email|unique:users,email,' . $request->id,
                'no_hp' => 'required|string|min:10|max:20',
                'alamat' => 'required|string|max:150',
                'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'nama_user.required' => 'Nama user tidak boleh kosong.',
                'nama_user.max' => 'Nama user tidak boleh lebih dari 75 digit.',
                'departemen_id.required' => 'Departemen harus dipilih.',
                'email.required' => 'Email tidak boleh kosong.',
                'email.email' => 'Format email tidak valid.',
                'email.unique' => 'Email sudah digunakan.',
                'no_hp.required' => 'Nomor HP tidak boleh kosong.',
                'no_hp.min' => 'Nomor HP harus memiliki minimal 10 digit.',
                'no_hp.max' => 'Nomor HP tidak boleh lebih dari 20 digit.',
                'alamat.required' => 'Alamat tidak boleh kosong.',
                'alamat.max' => 'Alamat tidak boleh lebih dari 150 digit.',
                'foto.image' => 'File yang diunggah harus berupa gambar.',
                'foto.mimes' => 'Gambar harus berformat jpeg, png, atau jpg.',
                'foto.max' => 'Ukuran gambar tidak boleh lebih dari :max kilobyte.',
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

        if ($request->hasFile('foto')) {
            $nama_foto = Str::slug($request->nama_user, '_');
            $extension = $request->file('foto')->getClientOriginalExtension();
            $fileName = $nama_foto . '.' . $extension;
            $user->foto = $fileName;
            $request->file('foto')->move(public_path('build/images/users'), $fileName);
        }
        $user->save();
        return Response()->json($user);
    }

    public function edit(Request $request)
    {
        $where = ['id' => $request->id];
        $user = User::where($where)->first();
        if ($user) {
            if ($request->hasFile('image')) {
                $oldImage = $user->foto;
                $defaultImage = 'default.jpg';
                $oldImagePath = public_path('build/images/users/') . $oldImage;

                if ($oldImage !== $defaultImage && file_exists($oldImagePath)) {
                    $oldImagePath;
                }

                $image = $request->file('image');
                $imageName = time() . '.' . $image->extension();
                $image->move(public_path('build/images/users/'), $imageName);

                $user->foto = $imageName;
            }

            Alert::success('Berhasil!', 'Data berhasil diubah');
            return response()->json($user);
        } else {
            Alert::error('Gagal!', 'Data tidak ditemukan');
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }

    public function destroy(Request $request)
    {
        $user = User::where('id', $request->id)->first();

        if ($user) {
            $defaultImage = 'default.jpg';
            $oldImage = $user->foto;
            $oldImagePath = public_path('build/images/users/') . $oldImage;

            if ($oldImage !== $defaultImage && file_exists($oldImagePath)) {
                unlink($oldImagePath);
            }

            $user->delete();

            Alert::success('Berhasil!', 'Data berhasil dihapus');
            return response()->json(['message' => 'Data berhasil dihapus']);
        } else {
            Alert::error('Gagal!', 'Data tidak ditemukan');
            return response()->json(['error' => 'Data tidak ditemukan'], 404);
        }
    }
}
