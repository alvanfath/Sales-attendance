<!DOCTYPE html>
<html lang="en">

<head>
    @include('_partials.head')
    @yield('css')
</head>

<body class="col-lg-4 col-md-7 col-sm-12 mx-auto">
    <div class="main-wrapper " style="position: relative">
        <div class="vl d-none d-md-block" id="v1"></div>
        <div class="v2 d-none d-md-block" id="v2"></div>
        <div class="container px-sm-3" id="container" style="height: 100vh;">
            <div class="card shadow-none p-0" style="border-radius: 0;">

                <div class="d-flex flex-column justify-content-between" id="content-card" style="height: 100%;">
                    <div class="navbar navbar-expand fixed-top navbar-top flex-row col-lg-4 col-md-7 col-sm-8 col-12 mx-auto bg-white px-4 py-2">
                        <div class="vl d-none d-md-block"></div>
                        <div class="v2 d-none d-md-block"></div>
                        <div class="container px-sm-3">
                            <a class="navbar-brand" href="{{ route('home') }}">
                                <img src="{{ asset('assets/img/fingerprint.png') }}" width="50px" height="auto"
                                    alt="logo">
                            </a>
                            <h5>SALADS</h5>
                        </div>
                    </div>
                    @yield('header-img')
                    <div class="border">
                        <div class="conteiner line"></div>
                    </div>
                    <div class="card-body" id="content" style="position: relative; background-color: #F0F0F0;">
                        <div class="mt-5 px-0 pt-4 pb-4" style="margin-bottom: 70px">
                            @yield('content')
                        </div>
                        @if(Auth::check())
                        @include('_partials.nav2')
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    @yield('modal')
    <!-- Bootstrap core JS-->
    @include('_partials.js')
    @yield('js')
</body>

</html>
