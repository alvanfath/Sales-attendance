<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\Admin\HomeController;

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

    public function monthly($id){
        $user = User::where('id', $id)->where('role', 'sales')->firstOrFail();
        $absence = Absensi::where('sales_id', $id)->select(DB::raw('DATE(in_time) as date'), DB::raw('COUNT(*) as total'))->groupBy(DB::raw('DATE(in_time)'))->get();
        $currentMonth = Carbon::now()->month;
        $currentYear = Carbon::now()->year;
        $totalDays = Carbon::create($currentYear, $currentMonth)->daysInMonth;
        $dates = [];
        for ($day = 1; $day <= $totalDays; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
            $dates[] = $date;
        }
        $result = [];
        foreach ($dates as $item) {
            $total = 0;
            foreach ($absence as $row) {
                if ($row->date == $item) {
                    $total = $row->total;
                }
            }
            $result[] = [
                'date' => $item,
                'total' => $total
            ];
        }
        $get_month = new  HomeController;
        $month = $get_month->month();
        return view('admin.desktop.monthly', compact('result', 'user', 'month', 'currentMonth'));
    }

    public function getMonthly(Request $request){
        $request->validate([
            'id' => 'required',
            'month' => 'required'
        ]);
        $user = User::where('id', $request->id)->where('role', 'sales')->firstOrFail();
        $absence = Absensi::where('sales_id', $request->id)->select(DB::raw('DATE(in_time) as date'), DB::raw('COUNT(*) as total'))->groupBy(DB::raw('DATE(in_time)'))->get();
        $currentMonth = $request->month;
        $currentYear = Carbon::now()->year;
        $totalDays = Carbon::create($currentYear, $currentMonth)->daysInMonth;
        $dates = [];
        for ($day = 1; $day <= $totalDays; $day++) {
            $date = Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
            $dates[] = $date;
        }
        $result = [];
        foreach ($dates as $item) {
            $total = 0;
            foreach ($absence as $row) {
                if ($row->date == $item) {
                    $total = $row->total;
                }
            }
            $result[] = [
                'date' => date('d F Y', strtotime($item)),
                'total' => $total
            ];
        }

        return $result;
    }
}
