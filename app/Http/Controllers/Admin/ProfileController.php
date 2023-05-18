<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ProfileController extends Controller
{
    public function update(Request $request){
        $user = Auth::user();
        $request->validate([
            'name' =>  'required',
            'email' => 'required|unique:users,email,'.$user->id,
            'username' => 'required|unique:users,username,'.$user->id,
            'phone_number' => 'required|numeric|unique:users,phone_number,'.$user->id,
        ],[
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'phone_number.required' => 'No telepon wajib diisi.',
            'email.unique' => 'Email tidak tersedia.',
            'username.unique' => 'Username tidak tersedia.',
            'phone_number.unique' => 'No Telepon tidak tersedia.',
            'phone_number.numeric' => 'No Telepon harus berupa angka.',
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
        ]);
        return back()->with('success', 'Ubah profil berhasil');
    }

    public function profile(){
        $user = Auth::user();
        return view('admin.profile', compact('user'));
    }

    public function profileDesktop(){
        $user = Auth::user();
        return view('admin.desktop.profile', compact('user'));
    }
}
