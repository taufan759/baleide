<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\File;
use Illuminate\Validation\Rules\Password;

class ProfileController extends Controller
{
    public function index()
    {
        return view('user.profile.index', [
            'user' => Auth::user(),
            'sb'   => 'Profile'
        ]);
    }

    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name'    => ['required', 'string', 'max:100'],
            'email'   => ['required', 'string', 'email', 'max:100', 'unique:users,email,' . $user->id],
            'phone'   => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string'],
            'avatar'  => ['nullable', 'image', 'mimes:jpg,jpeg,png', 'max:2048'],
        ]);

        $data = [
            'name'    => $request->name,
            'email'   => $request->email,
            'phone'   => $request->phone,
            'address' => $request->address,
        ];

        if ($request->hasFile('avatar')) {
            if ($user->avatar && File::exists(public_path('assets/avatar/' . $user->avatar))) {
                File::delete(public_path('assets/avatar/' . $user->avatar));
            }

            $file = $request->file('avatar');
            $avatarName = 'avatar_' . time() . '.' . $file->getClientOriginalExtension();
            $file->move(public_path('assets/avatar'), $avatarName);
            
            $data['avatar'] = $avatarName;
        }

        $user->update($data);

        return redirect()->back()->with('message', 'Profil berhasil diperbarui.');
    }

    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => ['required', 'current_password'],
            'password'         => ['required', 'confirmed', Password::defaults()],
        ]);

        Auth::user()->update([
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('message', 'Password berhasil diganti.');
    }
}