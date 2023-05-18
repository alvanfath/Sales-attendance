@extends('_layouts.app')
@section('content')
    <div class="row mt-5">
        <div class="col-sm-12">
            <div class="card">
                <div class="card-title d-flex justify-content-between">
                    <h5>Absensi Sales</h5>
                    <h5>Masuk!!</h5>
                </div>
                <div class="card-body">
                    <form action="{{route('authenticate')}}" method="post">
                        @csrf
                        <div class="form-group">
                            <label for="email_username">Email / Username</label>
                            <input type="text" class="form-control @error('email_username')
                                is-invalid
                            @enderror" name="email_username" placeholder="jhondoe" value="{{old('email_username')}}">
                            @error('email_username')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <div class="form-group mb-2">
                            <label for="password">Password</label>
                            <input type="password" class="form-control @error('password')
                            is-invalid
                            @enderror" name="password" placeholder="*******">
                            @error('password')
                                <small class="text-danger">{{$message}}</small>
                            @enderror
                        </div>
                        <button class="btn btn-dark w-100">Masuk</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

