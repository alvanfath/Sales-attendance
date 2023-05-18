<div class="bottom-appbar navbar-expand fixed-bottom px-lg-3 px-md-3 px-sm-0 col-lg-4 col-md-7 col-sm-8 col-12 mx-auto">
    <div class="tabs">
        <div class="tab tab--left">
            <div class="row">
                <a href="{{ route('home') }}" class="col d-flex flex-column justify-content-center align-items-center {{ Route::is('home') ? 'actived' : '' }}">
                    <i class="fa fa-home mb-1 {{ Route::is('home') ? 'actived' : 'text-dark' }}"></i>
                    <span>Home</span>
                </a>
            </div>
        </div>
        <div class="tab tab--fab">
            <div class="top">
                <a href="{{ route('absence') }}" title="Absen">
                    <div class="fab">
                        <img src="{{ asset('assets/img/fingerprint.png') }}" width="50px" height="50px"
                            alt="">
                    </div>
                </a>

            </div>
        </div>
        <div class="tab tab--right">
            <div class="row">
                <a href="{{route('my-profile')}}" class="col d-flex flex-column justify-content-center align-items-center {{ Route::is('my-profile') ? 'actived' : '' }}">
                    <i class="fa fa-user mb-1 {{ Route::is('my-profile') ? 'actived' : 'text-dark' }}"></i>
                    <span>Profile</span>
                </a>
            </div>

        </div>
    </div>
</div>
