<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="Themesdesign" name="author" />
    <meta name="csrf-token" content="{{ csrf_token() }}" />
    {{-- <meta name="csrf-token" content="{{ csrf_token() }}" /> --}}

    {!! SEOMeta::generate() !!}
    <!-- App favicon -->
    <!-- jquery.vectormap css -->
    <link href="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css">
    <!-- DataTables -->
    <link href="{{ asset('assets/libs/datatables.net-bs4/css/dataTables.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('assets/libs/bootstrap-datepicker/css/bootstrap-datepicker.min.css')}}" rel="stylesheet">
    {{-- <link href="{{ asset('assets/libs/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css"> --}}
    <link href="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.css')}}" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <!-- Responsive datatable examples -->
    <link href="{{ asset('assets/libs/datatables.net-responsive-bs4/css/responsive.bootstrap4.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />
    <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
    <link type="text/css" href="{{ asset('assets/js/jquery.countdown.css')}}" rel="stylesheet">
    <script type="text/javascript" src="{{ asset('assets/js/jquery.countdown.min.js')}}"></script>
    <script type="text/javascript">
        $(function () {
            $.ajaxSetup({headers: {'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')}});
        });
    </script>
</head>
<body data-topbar="dark"  data-layout="horizontal">
    <!-- <body data-layout="horizontal" data-topbar="dark"> -->
        <!-- Begin page -->
        <div id="layout-wrapper">
            <header id="page-topbar">
                <div class="navbar-header">
                    <div class="d-flex">
                        <button type="button" class="btn btn-sm px-3 font-size-24 d-lg-none header-item" data-bs-toggle="collapse" data-bs-target="#topnav-menu-content">
                            <i class="ri-menu-line align-middle"></i>
                        </button>
                        <!-- LOGO -->
                        
                    </div>
    
                    <div class="d-flex">
                        <div class="dropdown d-inline-block user-dropdown">
                            <button type="button" class="btn header-item waves-effect" id="page-header-user-dropdown"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/account.png')}}"
                                    alt="Header Avatar">
                                <span class="d-none d-xl-inline-block ms-1">{{Auth::user()->name}}</span>
                                <i class="mdi mdi-chevron-down d-none d-xl-inline-block"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-end">
                                <!-- item-->
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item text-danger" href="{{ route('logout') }}"  onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                    <i class="ri-shut-down-line align-middle me-1 text-danger"></i>
                                    <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                        @csrf
                                    </form>
                                    Logout
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </header>
            <div class="main-content">

                <div class="page-content">
                    <div class="container-fluid">
                        @yield('content')
                    </div>

                </div>
                <!-- End Page-content -->

                <footer class="footer">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-12">
                                <script>document.write(new Date().getFullYear())</script> © Erajaya Quiz
                            </div>

                        </div>
                    </div>
                </footer>

            </div>
            <!-- end main content-->

        </div>
        <!-- END layout-wrapper -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{ asset('assets/libs/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}"></script>
        <!-- apexcharts -->
        {{-- <script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js')}}"></script> --}}
        <!-- jquery.vectormap map -->
        <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/jquery-jvectormap-1.2.2.min.js')}}"></script>
        <script src="{{ asset('assets/libs/admin-resources/jquery.vectormap/maps/jquery-jvectormap-us-merc-en.js')}}"></script>

        <!-- Required datatable js -->
        <script src="{{ asset('assets/libs/datatables.net/js/jquery.dataTables.min.js')}}"></script>
        <script src="{{ asset('assets/libs/datatables.net-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
        {{-- <script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script> --}}
        <script src="{{ asset('assets/libs/spectrum-colorpicker2/spectrum.min.js')}}"></script>
        <script src="{{ asset('assets/libs/bootstrap-touchspin/jquery.bootstrap-touchspin.min.js')}}"></script>
        <!-- Responsive examples -->
        <script src="{{ asset('assets/libs/datatables.net-responsive/js/dataTables.responsive.min.js')}}"></script>
        <script src="{{ asset('assets/libs/datatables.net-responsive-bs4/js/responsive.bootstrap4.min.js')}}"></script>
        <script src="{{ asset('assets/libs/select2/js/select2.min.js')}}"></script>

        {{-- <script src="{{ asset('assets/js/pages/dashboard.init.js')}}"></script> --}}
        {{-- <script src="{{ asset('assets/js/pages/form-advanced.init.js')}}"></script> --}}
        <!-- App js -->
        <script src="{{ asset('assets/js/app.js')}}"></script>

    </body>

</html>
