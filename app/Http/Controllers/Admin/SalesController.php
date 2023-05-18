<?php

namespace App\Http\Controllers\Admin;

use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;

class SalesController extends Controller
{
    public function index(){
        $data = User::where('role', 'sales')->paginate(5);
        $total = User::where('role', 'sales')->count();
        return view('admin.desktop.sales', compact('data', 'total'));
    }

    public function store(Request $request){
        $request->validate([
            'name' =>  'required',
            'email' => 'required|unique:users,email',
            'username' => 'required|unique:users,username',
            'phone_number' => 'required|numeric|unique:users,phone_number',
            'password' => 'required'
        ],[
            'name.required' => 'Nama wajib diisi.',
            'email.required' => 'Email wajib diisi.',
            'username.required' => 'Username wajib diisi.',
            'password.required' => 'Password wajib diisi.',
            'phone_number.required' => 'No telepon wajib diisi.',
            'email.unique' => 'Email tidak tersedia.',
            'username.unique' => 'Username tidak tersedia.',
            'phone_number.unique' => 'No Telepon tidak tersedia.',
            'phone_number.numeric' => 'No Telepon harus berupa angka.',
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'username' => $request->username,
            'phone_number' => $request->phone_number,
            'password' => Hash::make($request->password),
            'role' => 'sales'
        ]);

        return back()->with('success', 'Berhasil menambah sales');
    }

    public function absence($id){
        $data = Absensi::with('sales')->where('sales_id', $id)->get();
        $user = User::where('id', $id)->first();
        return response()->json([
            'data' => $data,
            'name' => $user->name
        ], 200);
    }

    public function destroy($id){
        $data = User::where('id', $id)->first();
        if ($data) {
            $absence = Absensi::where('sales_id', $id)->get();
            foreach ($absence as $item) {
                $path = 'absence/' . $item->image;
                if (Storage::disk('public')->exists($path)) {
                    Storage::disk('public')->delete($path);
                }
            }
            Absensi::where('sales_id', $id)->delete();
            $data->delete();
            return back()->with('success', 'Berhasil menghapus');
        }
        return back()->with('error', 'Data tidak ditemukan');
    }
}
