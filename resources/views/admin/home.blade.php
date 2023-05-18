@extends('_layouts.admin')
@section('css')

@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-title">
                    <p>Halo {{ $user->name }}</p>
                </div>
                <div class="card-body">
                    <h5>Pindah ke mode desktop?</h5>
                    <small>Anda bisa melihat beberapa data yang tidak ditampilkan disini jika beralih ke mode desktop</small>
                    <br>
                    <a href="{{route('admin.desktop.home')}}" class="btn btn-dark mt-2">Desktop Mode</a>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-title" style="margin-bottom:-20px">
                    <h5>Total Sales</h5>
                </div>
                <div class="card-body">
                    <span>{{\App\Models\User::where('role', 'sales')->count()}}</span>
                </div>
            </div>
        </div>
        <div class="col-sm-12">
            <div class="card">
                <div class="card-title" style="margin-bottom:-20px">
                    <h5>Total laporan sales</h5>
                </div>
                <div class="card-body">
                    <span>{{\App\Models\Absensi::count()}}</span>
                </div>
            </div>
        </div>
    </div>
@endsection
