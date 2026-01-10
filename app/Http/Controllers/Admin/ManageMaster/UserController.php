<?php

namespace App\Http\Controllers\Admin\ManageMaster;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;
use File;

class UserController extends Controller
{
    public function index()
    {
        return view('admin.manage_master.users.index')->with('sb', 'User');
    }

    public function getall(Request $request)
    {
        $query = User::select('id', 'name', 'email', 'role', 'phone', 'avatar', 'created_at')
                ->orderBy('created_at', 'DESC')
                ->get();

        return DataTables::of($query)
            ->addIndexColumn()
            ->editColumn('created_at', function ($user) {
                return $user->created_at->format('d-m-Y H:i');
            })
            ->addColumn('action', function (User $user) {
                return '
                <div class="dropdown d-inline dropleft">
                    <button type="button" class="btn btn-primary btn-sm dropdown-toggle" aria-haspopup="true" data-toggle="dropdown">
                        Action
                    </button>
                    <ul class="dropdown-menu">
                        <li><a data-id="' . $user->id . '" class="dropdown-item edit" style="cursor:pointer">Edit</a></li>
                        <li><a data-id="' . $user->id . '" class="dropdown-item hapus" href="#" style="cursor:pointer">Hapus</a></li>
                    </ul>
                </div>
                ';
            })
            ->rawColumns(['action'])
            ->make(true);
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:100|unique:users,email',
            'password' => 'required|string|min:3',
            'role'     => 'required|in:admin,user',
            'phone'    => 'nullable|string|max:20',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        $avatarName = null;
        if ($request->hasFile('avatar')) {
            $file = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/avatar'), $avatarName);
        }

        User::create([
            'name'     => $request->name,
            'email'    => $request->email,
            'password' => Hash::make($request->password),
            'role'     => $request->role,
            'phone'    => $request->phone,
            'address'  => $request->address,
            'avatar'   => $avatarName,
        ]);

        return redirect()->back()->with('message', 'User berhasil ditambahkan');
    }

    public function get(Request $request)
    {
        return response()->json(User::findOrFail($request->id), 200);
    }

    public function update(Request $request)
    {
        $user = User::findOrFail($request->id);

        $validator = Validator::make($request->all(), [
            'name'     => 'required|string|max:100',
            'email'    => 'required|string|email|max:100|unique:users,email,' . $user->id,
            'role'     => 'required|in:admin,user',
            'avatar'   => 'nullable|image|mimes:jpg,jpeg,png|max:2048'
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        }

        if ($request->hasFile('avatar')) {
            if ($user->avatar && file_exists(public_path('assets/avatar/' . $user->avatar))) {
                unlink(public_path('assets/avatar/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/avatar'), $avatarName);
            $user->avatar = $avatarName;
        }

        $user->name    = $request->name;
        $user->email   = $request->email;
        $user->role    = $request->role;
        $user->phone   = $request->phone;
        $user->address = $request->address;

        if ($request->filled('password')) {
            $user->password = Hash::make($request->password);
        }

        $user->save();

        return redirect()->back()->with('message', 'Data user berhasil diupdate');
    }

    public function delete(Request $request)
    {
        $user = User::findOrFail($request->id);
        
        if ($user->avatar && file_exists(public_path('assets/avatar/' . $user->avatar))) {
            unlink(public_path('assets/avatar/' . $user->avatar));
        }

        $user->delete();
        return response()->json(['message' => 'Data user berhasil dihapus'], 200);
    }
}