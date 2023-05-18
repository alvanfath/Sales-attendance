<nav class="navbar navbar-dark bg-white navbar-expand fixed-bottom p-0 col-lg-4 col-md-7 col-sm-8 col-12 mx-auto">
    <div class="container px-sm-3">
        <div class="vl"></div>
        <div class="v2"></div>
        <ul class="navbar-nav nav-justified w-100">
            <li class="nav-item {{ Route::is('admin.home') ? 'active' : '' }}">
                <a href="{{ route('admin.home') }}" class="nav-link">
                    <!-- <i width="2em" height="1.5em" class="fa fa-home"></i> -->
                    <i class="fa fa-home"></i>
                    <small>Home</small>
                </a>
            </li>

            <li class="nav-item {{ Route::is('admin.sales') ? 'active' : '' }}">
                <a href="{{route('admin.sales')}}" class="nav-link">
                    <i class="fa fa-align-justify"></i>
                    <small>Data Sales</small>
                </a>
            </li>
                <li class="nav-item {{ Route::is('admin.profile') ? 'active' : '' }}">
                    <a href="{{route('admin.profile')}}" class="nav-link">
                        <!-- <i width="2em" height="1.5em" class="fa fa-user"></i> -->
                        <i class="fa fa-user"></i>
                        <small>Profile</small>
                    </a>
                </li>
        </ul>
    </div>
</nav>
