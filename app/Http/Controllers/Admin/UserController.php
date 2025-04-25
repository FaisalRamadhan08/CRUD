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
        // $users = User::select('*');
        $users = User::select('users.*', 'roles.name as role_name')
            ->leftJoin('roles', 'users.role_id', '=', 'roles.id');
        $roles = Role::all();

        if (request()->ajax()) {
            return datatables()->of($users)
                ->addColumn('action', function ($row) {
                    return '
    <div style="display: flex; gap: 5px; justify-content: center;">
        <button onclick="editUser(' . $row->id . ')" class="btn btn-warning btn-sm">
            <i class="fas fa-edit"></i>
        </button>
        <button onclick="deleteUser(' . $row->id . ')" class="btn btn-danger btn-sm">
            <i class="fas fa-trash"></i>
        </button>
    </div>';
                })
                ->rawColumns(['action'])
                ->addIndexColumn()
                ->make(true);
        }

        return view('admin.pages.user.index', [
            'user' => $users,
            'roles' => $roles, // Meneruskan data roles ke view
        ]);
    }

    public function add()
    {
        return view('admin.pages.user.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'role_id' => 'required',
            'name' => 'required',
            'phone' => 'required',
            'email' => 'required',
            'address' => 'required',
            'photo' => 'required|file|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // Handle upload seperti sebelumnya
        if ($request->hasFile('photo')) {
            $photoPath = $request->file('photo')->store('photos', 'public');
        } else {
            // Ambil data lama kalau update
            $photoPath = User::find($request->id)?->photo;
        }


        // $userId = $request->id;

        $user = User::updateOrCreate(
            ['id' => $request->id],
            [
                'role_id' => $request->role_id,
                'name' => $request->name,
                'phone' => $request->phone,
                'email' => $request->email,
                'address' => $request->address,
                'photo' => $photoPath,
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
}
