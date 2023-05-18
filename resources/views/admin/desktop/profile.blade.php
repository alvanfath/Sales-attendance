@extends('_layouts.desktop')
@section('css')
    <style>
        .color {
            color: #6ccfcb
        }
    </style>
@endsection
@section('heading', 'Halaman Profil')
@section('content')
    <div class="row">
        <div class="col-sm-6">
            <div class="card">
                <div class="card-header">
                    <h4>Form Profil</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.update-profile') }}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text"
                                class="form-control @error('name')
                            is-invalid
                            @enderror"
                                name="name" value="{{ $user->name }}">
                            @error('name')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text"
                                class="form-control @error('email')
                            is-invalid
                            @enderror"
                                name="email" value="{{ $user->email }}">
                            @error('email')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text"
                                class="form-control @error('username')
                            is-invalid
                            @enderror"
                                name="username" value="{{ $user->username }}">
                            @error('username')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number">No Telepon</label>
                            <input type="number"
                                class="form-control @error('phone_number')
                                is-invalid
                            @enderror"
                                name="phone_number" value="{{ $user->phone_number }}">
                            @error('phone_number')
                                <small class="text-danger">{{ $message }}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-sm-6 mb-3">
            <div class="card">
                <div class="card-header">
                    <h4>Form Ubah Password</h4>
                </div>
                <div class="card-body">
                    <form action="{{route('update-password')}}" method="post">
                        @csrf
                        @method('put')
                        <div class="form-group">
                            <label for="current_password">Password saat ini</label>
                            <input type="password" class="form-control @error('current_password')
                                is-invalid
                            @enderror" name="current_password">
                            @error('current_password')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="new_password">Password baru</label>
                            <input type="password" class="form-control @error('new_password')
                            is-invalid
                            @enderror" name="new_password">
                            @error('new_password')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="confirm_password">Konfirmasi password baru</label>
                            <input type="password" class="form-control @error('confirm_password')
                            is-invalid
                            @enderror" name="confirm_password">
                            @error('confirm_password')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark w-100">Ubah Password</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('js')

@endsection
