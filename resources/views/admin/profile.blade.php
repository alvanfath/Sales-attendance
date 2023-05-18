@extends('_layouts.admin')
@section('css')
    <style>
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }

        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
@endsection
@section('content')
    <div class="row">
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-title" style="margin-bottom: -20px">
                    <p>Form Profil</p>
                </div>
                <div class="card-body mt-0">
                    <form action="{{route('admin.update-profile')}}" method="post">
                        @method('put')
                        @csrf
                        <div class="form-group">
                            <label for="name">Nama</label>
                            <input type="text" class="form-control @error('name')
                            is-invalid
                            @enderror" name="name" value="{{ $user->name }}">
                            @error('name')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control @error('email')
                            is-invalid
                            @enderror" name="email" value="{{ $user->email }}">
                            @error('email')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group">
                            <label for="username">Username</label>
                            <input type="text" class="form-control @error('username')
                            is-invalid
                            @enderror" name="username" value="{{ $user->username }}">
                            @error('username')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-3">
                            <label for="phone_number">No Telepon</label>
                            <input type="number" class="form-control @error('phone_number')
                                is-invalid
                            @enderror" name="phone_number"
                                value="{{ $user->phone_number }}">
                            @error('phone_number')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark w-100">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-sm-12 mb-3">
            <div class="card">
                <div class="card-title" style="margin-bottom: -20px">
                    <p>Form Ubah Password</p>
                </div>
                <div class="card-body mt-0">
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
        <div class="col-sm-12">
            <button id="logout" class="btn btn-dark w-100"><i class="fa fa-arrow-left"></i> Logout</button>
            <form action="{{route('logout')}}" method="post" id="logout-form" hidden>
            @csrf
            </form>
        </div>

    </div>
@endsection
