<!doctype html>
<html lang="en">

    <head>

        <meta charset="utf-8" />
        <title>Register Erajaya Quiz</title>
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta content="Premium Multipurpose Admin & Dashboard Template" name="description" />
        <meta content="Themesdesign" name="author" />
        <!-- App favicon -->
        <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico')}}">

        <!-- Bootstrap Css -->
        <link href="{{ asset('assets/css/bootstrap.min.css')}}" id="bootstrap-style" rel="stylesheet" type="text/css" />
        <!-- Icons Css -->
        <link href="{{ asset('assets/css/icons.min.css')}}" rel="stylesheet" type="text/css" />
        <!-- App Css-->
        <link href="{{ asset('assets/css/app.min.css')}}" id="app-style" rel="stylesheet" type="text/css" />

    </head>

    <body class="auth-body-bg">
        <div class="bg-overlay"></div>
        <div class="wrapper-page">
            <div class="container-fluid p-0">
                <div class="card">
                    <div class="card-body">

                        <div class="text-center mt-4">
                            <div class="mb-3">

                            </div>
                        </div>

                        <h4 class="text-muted text-center font-size-18"><b>Erajaya Quiz</b></h4>

                        <div class="p-3">
                            <form method="POST" class="form-horizontal mt-3" action="{{ route('register') }}">
                                @csrf
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control @error('name') is-invalid @enderror" value="{{old('name')}}" name="name"  type="text" placeholder="Name">
                                    </div>
                                </div>
                                @error('name')
                                    <div style="color: #f32f53;margin-bottom:15px;">
                                        {{ $message }}
                                   </div>
                                @enderror
                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control @error('email') is-invalid @enderror" value="{{old('email')}}" name="email"  type="email" placeholder="Email">
                                    </div>
                                </div>
                                @error('email')
                                    <div style="color: #f32f53;margin-bottom:15px;">
                                        {{ $message }}
                                   </div>
                                @enderror


                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password" placeholder="Password">
                                    </div>
                                </div>
                                @error('password')
                                    <div style="color: #f32f53;margin-bottom:15px;">
                                        {{ $message }}
                                    <div></div></div>
                                @enderror

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <input class="form-control @error('password') is-invalid @enderror" type="password" name="password_confirmation" placeholder="Konfirmasi Password">
                                    </div>
                                </div>

                                <div class="form-group mb-3 row">
                                    <div class="col-12">
                                        <select class="form-select @error('role') is-invalid @enderror" name="role_id" id="role_id">
                                            <option selected disabled value="">Pilih Role</option>
                                            <option value="Admin">Admin</option>
                                            <option value="User">User</option>
                                        </select>
                                    </div>
                                </div>
                                @error('role')
                                    <div style="color: #f32f53;margin-bottom:15px;">
                                        {{ $message }}
                                    <div></div></div>
                                @enderror


                                <div class="form-group mb-3 text-center row mt-3 pt-1">
                                    <div class="col-12">
                                        <button class="btn btn-dark w-100 waves-effect waves-light" type="submit">Log In</button>
                                    </div>
                                </div>
                                <div class="form-group mb-0 row mt-2 align-content-center justify-content-center">
                                    <div class="col-sm-8 mt-3">
                                        <a href="{{route('login')}}" class="text-muted"><i class="ri-logout-circle-r-line "></i> Sudah punya akun ? Login</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                        <!-- end -->
                    </div>
                    <!-- end cardbody -->
                </div>
                <!-- end card -->
            </div>
            <!-- end container -->
        </div>
        <!-- end -->

        <!-- JAVASCRIPT -->
        <script src="{{ asset('assets/libs/jquery/jquery.min.js')}}"></script>
        <script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
        <script src="{{ asset('assets/libs/metismenu/metisMenu.min.js')}}"></script>
        <script src="{{ asset('assets/libs/simplebar/simplebar.min.js')}}"></script>
        <script src="{{ asset('assets/libs/node-waves/waves.min.js')}}"></script>
        <script src="{{ asset('assets/js/app.js')}}"></script>
    </body>
</html>
