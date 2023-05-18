<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Rules\MatchOldPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function authenticate(Request $request){
        $request->validate([
            'email_username' => 'required',
            'password' => 'required'
        ]);
        $email_or_us = filter_var($request->input('email_username'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $user = User::where($email_or_us, $request->email_username)->first();
        if ($user) {
            $password = Hash::check($request->password, $user->password);
            if ($password) {
                Auth::login($user);
                if ($user->role == 'admin') {
                    return redirect()->route('admin.home');
                }else{
                    return redirect()->route('home');
                }
            }
            return redirect()->back()->withErrors([
                'email_username' => $email_or_us . ' atau password salah'
            ])->withInput();
        }
        return redirect()->back()->withErrors([
            'email_username' => $email_or_us . ' atau password salah'
        ])->withInput();
    }

    public function logout(Request $request){
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect()->route('login');
    }

    public function updatePassword(Request $request){
        $user = Auth::user();
        $validate = $request->validate([
            'current_password' => ['required', new MatchOldPassword],
            'new_password' => ['required'],
            'confirm_password' => ['required', 'same:new_password']
        ],[
            'current_password.required' => 'Password saat ini wajib diisi',
            'new_password.required' => 'Password baru wajib diisi',
            'confirm_password.required' => 'Konfirmasi password wajib diisi',
            'confirm_password.same' => 'Konfirmasi password tidak sesuai',
        ]);

        $user->update([
            'password' => Hash::make($request->new_password)
        ]);
        return back()->with('success', 'Ubah password berhasil');
    }

    public function updateSalesProfile(Request $request){
        $user = Auth::user();
        $request->validate([
            'name' =>  'required',
            'username' => 'required|unique:users,username,'.$user->id,
        ],[
            'name.required' => 'Nama wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'username.unique' => 'Username tidak tersedia.',
        ]);
        $user->update([
            'name' => $request->name,
            'username' => $request->username
        ]);
        return back()->with('success', 'Ubah profil berhasil');
    }
}
