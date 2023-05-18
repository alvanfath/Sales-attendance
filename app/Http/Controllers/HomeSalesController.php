<?php

namespace App\Http\Controllers;

use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeSalesController extends Controller
{
    public function home(){
        $user = Auth::user();
        $data = Absensi::with('sales')->where('sales_id', $user->id)->paginate(5);
        $total = Absensi::where('sales_id', $user->id)->count();
        return view('home', compact('user','data','total'));
    }
}
