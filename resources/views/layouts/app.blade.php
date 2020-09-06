<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <meta http-equiv="Content-Language" content="en" />
        <meta name="msapplication-TileColor" content="#2d89ef">
        <meta name="theme-color" content="#4188c9">
        <meta name="apple-mobile-web-app-status-bar-style" content="black-translucent"/>
        <meta name="apple-mobile-web-app-capable" content="yes">
        <meta name="mobile-web-app-capable" content="yes">
        <meta name="HandheldFriendly" content="True">
        <meta name="MobileOptimized" content="320">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <title>{{ config('app.name') }}</title>
        <!--[if lt IE 9]>
            <script src="{{ asset('/js/vendors/reshtml5shivpond.min.js') }}"></script>
            <script src="{{ asset('/js/vendors/respond.min.js') }}"></script>
        <![endif]-->
        <link rel="stylesheet" href="{{ asset('/vendors/font-awesome/css/font-awesome.min.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/fonts.css') }}">
        <link rel="stylesheet" href="{{ asset('/css/jquery-ui.min.css') }}">
        <script src="{{ asset('/js/require.min.js') }}"></script>
        <script>
            requirejs.config({
                baseUrl: '{{ config('app.asset_url') }}'
            });
        </script>
        <link href="{{ asset('/vendors/DataTables/dataTables.bootstrap4.min.css') }}" rel="stylesheet" />
        <link href="{{ asset('/css/app.css') }}" rel="stylesheet" />
        <script src="{{ asset('/js/app.js') }}"></script>
    </head>
    <body>
        <div class="page">
            <div class="page-main">
                <div class="header py-4">
                    <div class="container">
                        <div class="d-flex">
                            <a class="header-brand" href="{{ url('/') }}">
                                <img src="{{ asset('/brand/logo.png') }}" class="header-brand-img" alt="{{ config('app.name') }}">
                            </a>
                            <div class="d-flex order-lg-2 ml-auto">
                                <div class="dropdown">
                                    <a href="javascript:;" class="nav-link pr-0 leading-none" data-toggle="dropdown">
                                        <span class="avatar" style="background-image: url({{ asset('/avatar/default-32x32.png') }})"></span>
                                        <span class="ml-2 d-none d-lg-block">
                                            <span class="text-default">{{ Auth::user()->name }}</span>
                                            <small class="text-muted d-block mt-1">
                                                {{ $role->role_name }}
                                            </small>
                                        </span>
                                    </a>
                                    <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
                                        <a class="dropdown-item{{ Request::segment(1) === 'settings' ? ' active' : null }}" href="{{ url('/settings') }}">
                                            <i class="dropdown-icon fe fe-settings"></i> Pengaturan
                                        </a>
                                        <div class="dropdown-divider"></div>
                                            <a class="dropdown-item" href="{{ url('/logout') }}" onclick="event.preventDefault();document.getElementById('logout-form').submit();">
                                                <i class="dropdown-icon fe fe-log-out"></i> Keluar<form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">@csrf</form>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                                <a href="javascript:;" class="header-toggler d-lg-none ml-3 ml-lg-0" data-toggle="collapse" data-target="#headerMenuCollapse">
                                    <span class="header-toggler-icon"></span>
                                </a>
                            </div>
                        </div>
                    </div>
                <div class="header collapse d-lg-flex p-0" id="headerMenuCollapse">
                    <div class="container">
                        <div class="row align-items-center">
                            <div class="col-lg order-lg-first">
                                <ul class="nav nav-tabs border-0 flex-column flex-lg-row">
                                    <li class="nav-item">
                                        <a href="{{ url('/dashboard') }}" class="nav-link{{ Request::segment(1) === 'dashboard' ? ' active' : null }}"><i class="fe fe-home"></i> Dashboard</a>
                                    </li>
                                    @if($role->role_id=='1')
                                    <li class="nav-item dropdown">
                                        <a href="javascript:;" class="nav-link {{ Request::segment(1) === 'master' ? ' active' : null }}" data-toggle="dropdown"><i class="fe fe-box"></i> Data Master</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">
                                            <a href="{{ url('/master/student') }}" class="dropdown-item{{ Request::segment(2) === 'student' ? ' active' : null }}">Data Siswa</a>
                                            <a href="{{ url('/master/rooms') }}" class="dropdown-item{{ Request::segment(2) === 'rooms' ? ' active' : null }}">Data Ruang</a>
                                            <a href="{{ url('/master/facilities') }}" class="dropdown-item{{ Request::segment(2) === 'facilities' ? ' active' : null }}">Data Fasilitas</a>
                                            <a href="{{ url('/master/criterias') }}" class="dropdown-item{{ Request::segment(2) === 'criterias' ? ' active' : null }}">Data Jenis Kerusakan</a>
                                        </div>
                                    </li>
                                    @endif
                                    @if($role->role_id=='1')
                                    <li class="nav-item dropdown">
                                        <a href="javascript:;" class="nav-link {{ Request::segment(1) === 'report' ? ' active' : null }}" data-toggle="dropdown"><i class="fe fe-file-text"></i> Laporan</a>
                                        <div class="dropdown-menu dropdown-menu-arrow">
                                            <a href="{{ url('/report/process') }}" class="dropdown-item{{ Request::segment(2) === 'process' ? ' active' : null }}">Proses Laporan</a>
                                            <a href="{{ url('/report/view') }}" class="dropdown-item{{ Request::segment(2) === 'view' ? ' active' : null }}">Rekap Laporan</a>
                                        </div>
                                    </li>
                                    @endif
                                    @if($role->role_id=='2')
                                    <li class="nav-item">
                                        <a href="{{ url('/report/create-new') }}" class="nav-link{{ Request::segment(1) === 'report' && Request::segment(2) === 'create-new' ? ' active' : null }}"><i class="fe fe-edit"></i> Lapor Kerusakan</a>
                                    </li>
                                    <li class="nav-item">
                                        <a href="{{ url('/report/history') }}" class="nav-link{{ Request::segment(1) === 'report' && Request::segment(2) === 'history' ? ' active' : null }}"><i class="fe fe-inbox"></i> Riwayat Lapor</a>
                                    </li>
                                    @endif
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="my-3 my-md-5">
                    <div class="container">
                        @yield('content')
                    </div>
                </div>
            </div>
            <footer class="footer">
                <div class="container">
                    <div class="row align-items-center flex-row-reverse">
                        <div class="col-12 mt-3 mt-lg-0 text-center">
                            © {{ date('Y') }} <a href="{{ url('/') }}">{{ config('app.name') }}</a>. Hak cipta dilindungi.
                        </div>
                    </div>
                </div>
            </footer>
        </div>
        @stack('scripts')
    </body>
</html>