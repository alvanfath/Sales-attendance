<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AttendanceController extends Controller
{
    public function createAttendance(){
        $user = Auth::user();
        $today = Carbon::today()->toDateString();
        $attendance = Absensi::where('sales_id', $user->id)->where('out_time', null)->whereDate('in_time', $today)->latest()->first();

        $exist = false;
        if ($attendance) {
            $in_time = Carbon::parse($attendance->in_time)->addHours(8);
            $out_time = Carbon::parse($attendance->in_time)->addHours(1);
            if (Carbon::now() > $in_time) {
                $attendance->update([
                    'out_time' => $out_time
                ]);
                return redirect()->route('absence');
            }
            $exist = true;
            return view('absence', compact('exist', 'attendance'));
        }
        return view('absence', compact('exist'));
    }
    public function storeAttendance(Request $request){
        $request->validate([
            'image' => 'required',
            'lat' => 'required',
            'long' => 'required',
            'place_name' => 'required'
        ],[
            'image.required' => 'Silakan ambil gambar terlebih dahulu',
            'lat.required' => 'Tidak bisa mengakses lokasi anda, Silakan refresh halaman ini lalu klik izinkan saat halaman ini meminta izin untuk mengakses lokasi anda',
            'long.required' => 'Tidak bisa mengakses lokasi anda, Silakan refresh halaman ini lalu klik izinkan saat halaman ini meminta izin untuk mengakses lokasi anda',
            'place_name' => 'Nama tempat wajib diisi'
        ]);
        $image = $this->getImage($request->image);
        $image_name = $this->imageName();
        \Storage::disk('public')->put('absence' . '/' . $image_name, $image);

        $location_link = 'https://maps.google.com/maps?q=' . $request->lat . ',' . $request->long;
        Absensi::create([
            'sales_id' => Auth::user()->id,
            'image' => $image_name,
            'location' => $location_link,
            'in_time' => now(),
            'place_name' => $request->place_name
        ]);

        return back()->with('success', 'Berhasil mengupload laporan');
    }

    public function getImage($imageSrc){
        $imageSrc = explode(';base64,', $imageSrc);
        $base64Image = $imageSrc[1];
        $image = base64_decode($base64Image);

        return $image;
    }

    public function imageName(){
        $user = Auth::user();
        $date = date("Ymd_his");
        $result = $user->id . '_' . $date . '.jpg';
        return $result;
    }

    public function getDetail($id){
        $data = Absensi::where('id', $id)->firstOrFail();
        return response()->json($data, 200);
    }

    public function update(Request $request, $id){
        $data = Absensi::where('id', $id)->firstOrFail();
        $location_link = 'https://maps.google.com/maps?q=' . $request->lat . ',' . $request->long;
        $timeToUpdate = Carbon::parse($data->in_time)->addHours(1);
        if (now() > $timeToUpdate) {
            $data->update([
                'last_location' => $location_link,
                'out_time' => now()
            ]);
            return back()->with('success', 'Berhasil input absen keluar');
        }
        return back()->with('error', 'Minimal jam kerja sales adalah 1 jam setelah input absen masuk');
    }
}
