<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SALADS</title>

    <link rel="stylesheet" href="{{ asset('template/css/main/app.css') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/img/fingerprint.png') }}" />
    <link rel="stylesheet" href="{{ asset('template/extensions/@fortawesome/fontawesome-free/css/all.min.css') }}">
    <link rel="stylesheet"
        href="{{ asset('template/extensions/datatables.net-bs5/css/dataTables.bootstrap5.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('template/css/pages/datatables.css') }}" />
    <style>
        .sidebar-wrapper .sidebar-header img {
            height: 4rem;
        }

        .sidebar-wrapper .menu {
            margin-top: .5rem;
        }

        .btn-dark {
            background-color: #333 !important;
            color: #fff !important;
        }

        .btn-dark:hover {
            background-color: #4d4b4b !important;
            transition: 0.4s;
        }

        .pagination a {
            color: #333;
        }

        .active>.page-link,
        .page-link.active {
            background-color: #3f3f3f !important;
            border-color: #333;
        }
    </style>
    @yield('css')
</head>

<body>
    <div id="app">
        <div id="sidebar" class="active">
            @include('_partials_admin.sidebar')
        </div>
        <div id="main">
            <header class="mb-3">
                <a href="#" class="burger-btn d-block d-xl-none">
                    <i class="bi bi-justify fs-3"></i>
                </a>
            </header>

            <div class="page-heading">
                <div class="page-title">
                    <div class="row">
                        <div class="col-12 order-md-1 order-last">
                            <h2>@yield('heading')</h2>
                        </div>
                    </div>
                </div>
                <section class="section">
                    @yield('content')
                </section>
            </div>

            <footer>
                <div class="footer clearfix mb-0 text-muted">
                    <div class="float-start">
                        <p>-</p>
                    </div>
                </div>
            </footer>
        </div>
    </div>
    @yield('modal')
    <form action="{{ route('logout') }}" method="post" id="logout-form" hidden>
        @csrf
    </form>
    <script src="{{ asset('template/extensions/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('template/js/bootstrap.js') }}"></script>
    <script src="{{ asset('template/js/app.js') }}"></script>
    <script src="https://cdn.datatables.net/v/bs5/dt-1.12.1/datatables.min.js"></script>
    <script src="{{ asset('template/js/pages/datatables.js') }}"></script>
    <script src="{{ asset('template/extensions/parsleyjs/parsley.min.js') }}"></script>
    <script src="{{ asset('template/js/pages/parsley.js') }}"></script>

    {{-- plugin --}}
    <script src="{{ asset('assets/modules/notflix/notiflix-notify-aio-3.2.5.min.js') }}"></script>
    <script src="{{ asset('assets/modules/notflix/notiflix-report-aio-3.2.5.min.js') }}"></script>
    <script src="{{ asset('assets/modules/notflix/notiflix-3.2.5.min.js') }}"></script>
    <script src="{{ asset('assets/modules/notflix/notiflix-aio-3.2.5.min.js') }}"></script>
    <script>
        @if (Session::has('success'))
            Notiflix.Report.success(
                '',
                '{{ Session::get('success') }}',
                'Tutup',
            );
        @endif

        @if (Session::has('error'))
            Notiflix.Report.failure(
                '',
                '{{ Session::get('error') }}',
                'Tutup',
            );
        @endif
    </script>
    <script>
        $('#logout').click(function() {
            $('#logout-form').submit()
        })
    </script>
    @yield('js')
</body>

</html>
