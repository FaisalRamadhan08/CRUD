<?php

namespace App\Http\Controllers\Admin;

use App\Models\Role;
use App\Models\User;
use App\Http\Controllers\Controller;
use GuzzleHttp\Psr7\Response;
use Illuminate\Http\Request;

class UserController extends Controller
{
    public function indexPage()
    {
        $users = User::select('users.*', 'roles.name as role_name')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id');
        $roles = Role::all();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->editColumn('photo', function ($row) {
                    $url = asset('photo/' . $row->photo);
                    return '<img src="' . $url . '" width="50" height="50" style="object-fit:cover; border-radius:5px;" />';
                })
                ->addColumn('status_action', function ($row) {
                    $btnClass = $row->status ? 'btn-success' : 'btn-secondary';
                    $label = $row->status ? 'Active' : 'Inactive';

                    return '<button type="button" onclick="toggleStatus(' . $row->id . ')" class="btn ' . $btnClass . ' btn-sm">'
                        . $label .
                        '</button>';
                })
                ->addColumn('action', function ($row) {
                    return '
                        <div style="display: flex; gap: 5px; justify-content: center;">
                            <button onclick="editUser(' . $row->id . ')" class="btn btn-warning btn-sm">
                                <i class="fas fa-edit"></i>
                            </button>
                            <button onclick="deleteUser(' . $row->id . ')" class="btn btn-danger btn-sm">
                                <i class="fas fa-trash"></i>
                            </button>
                            <button onclick="detailUser(' . $row->id . ')" class="btn btn-info btn-sm">
                                <i class="fas fa-info-circle"></i>
                            </button>
                        </div>';
                })
                ->rawColumns(['photo', 'status_action', 'action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.user.index', [
            'user' => $users,
            'roles' => $roles,
        ]);
    }

    public function add()
    {
        return view('admin.pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'role_id' => 'required',
                'name' => 'required',
                'phone' => 'required|numeric',
                'email' => 'required',
                'address' => 'required',
                'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
            ],
            [
                'role_id.required' => 'Wajib memilih role',
                'name.required' => 'Nama wajib diisi',
                'phone.required' => 'No telepon wajib diisi',
                'phone.required' => 'No telepon wajib dalam angka',
                'email.required' => 'email wajib diisi',
                'alamat.required' => 'Alamat wajib diisi',
                'photo.required' => 'Silakan masukkan foto',
                'photo.mimes' => 'Hanya menerima file JPEG, JPG, & PNG'
            ]
        );

        // Handle upload seperti sebelumnya
        // if ($request->hasFile('photo')) {
        //     $photoPath = $request->file('photo')->store('photos', 'public');
        // } else {
        //     // Ambil data lama kalau update
        //     $photoPath = User::find($request->id)?->photo;
        // }

        $foto_file = $request->file('photo');
        $foto_ekstensi = $foto_file->extension();
        $foto_nama = date('ymdhis') . "." . $foto_ekstensi;
        $foto_file->move(public_path('photo'), $foto_nama);


        // $userId = $request->id;

        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'role_id' => $request->role_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'photo' => $foto_nama,
            ]
        );

        return Response()->json($user);
    }

    public function edit(Request $request)
    {
        $where = array('id' => $request->id);
        $user = User::where($where)->first();

        return Response()->json($user);
    }

    public function softDelete($id)
    {
        $user = User::find($id);
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        $user->delete(); // ini soft delete
        return response()->json(['message' => 'User deleted successfully']);
    }

    public function detail($id)
    {
        $user = User::with('role')->findOrFail($id);

        return view('admin.pages.user.detail-user', compact('user'));
    }

    public function toggleStatus($id)
    {
        $user = User::findOrFail($id);
        $user->status = !$user->status;  // Toggle status aktif/tidak aktif
        $user->save();

        return response()->json([
            'success' => true,
            'status' => $user->status ? 'Active' : 'Inactive'
        ]);
    }
}
