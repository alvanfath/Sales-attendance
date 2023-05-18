<div class="sidebar-wrapper active">
    <div class="sidebar-header position-relative">
        <div class="align-items-center">
            <div class="logo text-center">
                <a href="#">
                    <img src="{{ asset('assets/img/fingerprint.png') }}" alt="Logo">
                    <span class="text-white">SALADS</span>
                </a>
            </div>
            <div class="theme-toggle d-flex gap-2  align-items-center mt-2 d-none">
                <div class="form-check form-switch fs-6">
                    <input class="form-check-input  me-0" type="checkbox" id="toggle-dark">
                </div>
            </div>
            <div class="sidebar-toggler  x">
                <a href="#" class="sidebar-hide d-xl-none d-block"><i class="bi bi-x bi-middle"></i></a>
            </div>
        </div>
    </div>
    <div class="sidebar-menu">
        <ul class="menu">
            <li class="sidebar-item  {{ Route::is('admin.desktop.home') ? 'active' : '' }}">
                <a href="{{route('admin.desktop.home')}}" class='sidebar-link'>
                    <i class="bi bi-grid-fill"></i>
                    <span>Dashboard</span>
                </a>
            </li>
            <li class="sidebar-item  {{ Route::is('admin.desktop.sales') ? 'active' : '' }}">
                <a href="{{route('admin.desktop.sales')}}" class='sidebar-link'>
                    <i class="bi bi-people-fill"></i>
                    <span>Sales</span>
                </a>
            </li>
            <li class="sidebar-item  {{ Route::is('admin.desktop.my-profile') ? 'active' : '' }}">
                <a href="{{route('admin.desktop.my-profile')}}" class='sidebar-link'>
                    <i class="bi bi-person-fill"></i>
                    <span>Profil</span>
                </a>
            </li>
            <li class="sidebar-item">
                <a href="{{route('admin.home')}}" class='sidebar-link'>
                    <i class="bi bi-phone-fill"></i>
                    <span>Mobile Mode</span>
                </a>
            </li>
            <li class="sidebar-item  ">
                <a href="#" id="logout" class='sidebar-link'>
                    <i class="bi bi-arrow-left-circle-fill"></i>
                    <span>Keluar</span>
                </a>
            </li>
        </ul>
    </div>
</div>
