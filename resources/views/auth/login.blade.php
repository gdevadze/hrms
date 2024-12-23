<!DOCTYPE html>
<html lang="{{ currentLocale() }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable">
<head>

    <meta charset="utf-8" />
    <title>HRMS</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="თანამშრომლების აღრიცხვის პროგრამა" name="description" />
    <meta content="Asya Software" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="assets/js/layout.js"></script>
    <!-- Bootstrap Css -->
    <link href="assets/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="assets/css/icons.min.css" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="assets/css/app.min.css" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="assets/css/custom.min.css" rel="stylesheet" type="text/css" />

</head>

<body>

<div class="auth-page-wrapper pt-5">
    <!-- auth page bg -->
    <div class="auth-one-bg-position auth-one-bg" id="auth-particles">
        <div class="bg-overlay"></div>

        <div class="shape">
            <svg xmlns="http://www.w3.org/2000/svg" version="1.1" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 1440 120">
                <path d="M 0,36 C 144,53.6 432,123.2 720,124 C 1008,124.8 1296,56.8 1440,40L1440 140L0 140z"></path>
            </svg>
        </div>
    </div>

    <!-- auth page content -->
    <div class="auth-page-content">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center mt-sm-5 mb-4 text-white-50">
                        <div>
                            <a href="{{ route('index') }}" class="d-inline-block auth-logo">
                                <img src="https://giftoy.ge/assets/images/logo_white.png" alt="" height="70">
                            </a>
                        </div>
{{--                        <p class="mt-3 fs-15 fw-medium">თანამშრომლების აღრიცხვის პროგრამა</p>--}}
                    </div>
                </div>
            </div>
            <!-- end row -->

            <div class="row justify-content-center">
                <div class="col-md-8 col-lg-6 col-xl-5">
                    <div class="card mt-4">

                        <div class="card-body p-4">
                            <div class="text-center mt-2">
                                <h5 class="text-primary">@lang('login_system')</h5>
                                <p class="text-muted">@lang('employee_attendance_program')</p>
                            </div>
                            <div class="p-2 mt-4">
                                <form action="{{ route('login') }}" method="POST">
                                    @csrf
                                    <div class="mb-3">
                                        <label for="email" class="form-label">@lang('email_or_personal')</label>
                                        <input type="text" name="email" class="form-control" required value="{{ old('email') }}" id="email" placeholder="@lang('email_or_personal')">
                                        @error('personal_num')
                                        <span class="invalid-feedback" style="display: block" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                        @error('email')
                                        <span class="invalid-feedback" style="display: block" role="alert">
                                                <strong>{{ $message }}</strong>
                                        </span>
                                        @enderror
                                    </div>

                                    <div class="mb-3">

                                        <label class="form-label" for="password-input">@lang('password')</label>
                                        <div class="position-relative auth-pass-inputgroup mb-3">
                                            <input type="password" name="password" required class="form-control pe-5 password-input" placeholder="@lang('password')" id="password-input">
                                            <button class="btn btn-link position-absolute end-0 top-0 text-decoration-none text-muted password-addon" type="button" id="password-addon"><i class="ri-eye-fill align-middle"></i></button>
                                        </div>
                                    </div>

                                    <div class="mt-4">
                                        <button class="btn btn-success w-100" type="submit">@lang('login')</button>
                                    </div>
                                    <div class="mt-4 text-center">
                                        <div class="d-flex">
                                            @foreach($languages as $language)
                                                <a href="{{ route('locale',$language->code) }}" class="dropdown-item notify-item language py-2" data-lang="en"
                                                   title="{{ $language->name }}">
                                                    <img src="{{ asset('assets/images/flags/'.$language->icon) }}" alt="user-image" class="me-2 rounded" height="18">
                                                    <span class="align-middle">{{ $language->name }}</span>
                                                </a>
                                            @endforeach

                                        </div>
                                    </div>

                                </form>
                            </div>
                        </div>
                        <!-- end card body -->
                    </div>
                    <!-- end card -->

                </div>
            </div>
            <!-- end row -->
        </div>
        <!-- end container -->
    </div>
    <!-- end auth page content -->

    <!-- footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="text-center">
                        <p class="mb-0 text-muted">&copy;
                            <script>document.write(new Date().getFullYear())</script> HRMS
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </footer>
    <!-- end Footer -->
</div>
<!-- end auth-page-wrapper -->

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- particles js -->
<script src="{{ asset('assets/libs/particles.js/particles.js') }}"></script>
<!-- particles app js -->
<script src="{{ asset('assets/js/pages/particles.app.js') }}"></script>
<!-- password-addon init -->
<script src="{{ asset('assets/js/pages/password-addon.init.js') }}"></script>
</body>
</html>
