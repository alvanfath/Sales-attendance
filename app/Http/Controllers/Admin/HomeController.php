<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Absensi;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    public function home(){
        $user = Auth::user();
        $sales = User::where('role', 'sales')->paginate(5);
        return view('admin.home', compact('user', 'sales'));
    }

    public function homeDesktop(){
        $user = Auth::user();
        $sales = User::where('role', 'sales')->count();
        $absensi = Absensi::count();
        $absensiGraph = $this->graph();
        $salesGraph = $this->salesGraph();
        $topSales = Absensi::with('sales')->selectRaw('count(id) as total, sales_id')->groupBy('sales_id')->having('total', '>', 0)->orderBy('total', 'desc')->limit(5)->get();

        return view('admin.desktop.home', compact('user', 'sales', 'absensi', 'absensiGraph', 'topSales', 'salesGraph'));
    }

    protected function graph(){
        $data = Absensi::groupBy(DB::raw('MONTH(in_time)'))->whereYear('in_time', now()->year)->select(DB::raw('MONTH(in_time) as month'), DB::raw('COUNT(*) as total'))->get();
        $month = $this->month();
        $result = [];
        foreach ($month as $item) {
            $total = 0;
            foreach ($data as $row) {
                if ($item['value'] == $row->month) {
                    $total = $row->total;
                }
            }
            $result[] = [
                'label' => $item['month'],
                'total' => $total
            ];
        }
        return $result;
    }

    protected function salesGraph(){
        $data = Absensi::groupBy('sales_id')->select('sales_id as sales', DB::raw('count(*) as total'))->get();
        $sales = User::where('role', 'sales')->get();
        $result = [];
        foreach ($sales as $item) {
            $total = 0;
            foreach ($data as $row) {
                if ($item->id == $row->sales) {
                    $total = $row->total;
                }
            }
            $result[] = [
                'name' => $item->name,
                'total' => $total
            ];
        }
        return $result;

    }

    public function graphVal(Request $request){
        if ($request->has('option')) {
            $option = $request->option;
            $result = [];
            if ($option == 'month') {
                $month = $this->month();
                $data = Absensi::groupBy(DB::raw('MONTH(in_time)'))->whereYear('in_time', now()->year)->select(DB::raw('MONTH(in_time) as month'), DB::raw('COUNT(*) as total'))->get();
                foreach ($month as $item) {
                    $total = 0;
                    foreach ($data as $row) {
                        if ($item['value'] == $row->month) {
                            $total = $row->total;
                        }
                    }
                    $result[] = [
                        'label' => $item['month'],
                        'total' => $total
                    ];
                }
            } elseif ($option == 'day') {
                $data = Absensi::groupBy(DB::raw('DATE(in_time)'))->whereMonth('in_time', now()->month)->select(DB::raw('DATE(in_time) as date'), DB::raw('COUNT(*) as total'))->get();
                $currentMonth = Carbon::now()->month;
                $currentYear = Carbon::now()->year;
                $totalDays = Carbon::create($currentYear, $currentMonth)->daysInMonth;
                $dates = [];
                for ($day = 1; $day <= $totalDays; $day++) {
                    $date = Carbon::create($currentYear, $currentMonth, $day)->format('Y-m-d');
                    $dates[] = $date;
                }
                foreach ($dates as $item) {
                    $total = 0;
                    foreach ($data as $row) {
                        if ($row->date == $item) {
                            $total = $row->total;
                        }
                    }
                    $result[] = [
                        'label' => $item,
                        'total' => $total
                    ];
                }
            } elseif($option == 'year') {
                $data = Absensi::groupBy(DB::raw('YEAR(in_time)'))->select(DB::raw('YEAR(in_time) as year'), DB::raw('COUNT(*) as total'))->get();
                $currentYear = Carbon::now()->year;
                $previousYears = [];

                for ($i = 0; $i < 12; $i++) {
                    $year = $currentYear - $i;
                    $previousYears[] = $year;
                }

                $year = array_reverse($previousYears);
                foreach ($year as $item) {
                    $total = 0;
                    foreach ($data as $row) {
                        if ($row->year == $item) {
                            $total = $row->total;
                        }
                    }
                    $result[] = [
                        'label' => $item,
                        'total' => $total
                    ];
                }
            }
            return response()->json($result);

        }
    }



    public function sales(){
        $sales = User::where('role', 'sales')->paginate(5);
        return view('admin.sales', compact('sales'));
    }

    public function month(){
        $month = [
            [
                'value' => '1',
                'month' => 'Januari'
             ],
            [
                'value' => '2',
                'month' => 'Februari'
             ],
            [
                'value' => '3',
                'month' => 'Maret'
             ],
             [
                'value' => '4',
                'month' => 'April'
             ],
            [
                'value' => '5',
                'month' => 'Mei'
             ],
            [
                'value' => '6',
                'month' => 'Juni'
             ],
            [
                'value' => '7',
                'month' => 'Juli'
             ],
            [
                'value' => '8',
                'month' => 'Agustus'
             ],
            [
                'value' => '9',
                'month' => 'September'
             ],
            [
                'value' => '10',
                'month' => 'Oktober'
             ],
            [
                'value' => '11',
                'month' => 'November'
             ],
            [
                'value' => '12',
                'month' => 'Desember'
             ]
        ];

        return $month;
    }
}
