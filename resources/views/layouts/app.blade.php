<!DOCTYPE html>
<html lang="{{ currentLocale() }}" data-layout="vertical" data-topbar="light" data-sidebar="dark" data-sidebar-size="lg" data-sidebar-image="none" data-preloader="enable">
<head>

    <meta charset="utf-8" />
    <title>{{ generalSetting('site_title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta content="თანამშრომლების აღრიცხვის პროგრამა" name="description" />
    <meta content="Asyasoftware" name="author" />
    <!-- App favicon -->
    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">

    <!-- Layout config Js -->
    <script src="{{ asset('assets/js/layout.js') }}"></script>
    <!-- Bootstrap Css -->
    <link href="{{ asset('assets/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- Icons Css -->
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- App Css-->
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" type="text/css" />
    <!-- custom Css-->
    <link href="{{ asset('assets/css/custom.min.css') }}" rel="stylesheet" type="text/css" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.6.1.min.js" integrity="sha256-o88AwQnZB+VDvE9tvIXrMQaPlFFSUTR+nldQm1LuPXQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    @stack('css')
</head>

<body>

<!-- Begin page -->
<div id="layout-wrapper">

    <header id="page-topbar">
        <div class="layout-width">
            <div class="navbar-header">
                <div class="d-flex">
                    <!-- LOGO -->
                    <div class="navbar-brand-box horizontal-logo">
                        <a href="{{ route('dashboard') }}" class="logo logo-dark">
                        <span class="logo-sm">
                            <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="17">
                        </span>
                        </a>

                        <a href="{{ route('dashboard') }}" class="logo logo-light">
                        <span class="logo-sm">
                            <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="22">
                        </span>
                            <span class="logo-lg">
                            <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="17">
                        </span>
                        </a>
                    </div>

                    <button type="button" class="btn btn-sm px-3 fs-16 header-item vertical-menu-btn topnav-hamburger"
                            id="topnav-hamburger-icon">
                    <span class="hamburger-icon">
                        <span></span>
                        <span></span>
                        <span></span>
                    </span>
                    </button>

                    <!-- App Search-->
                    <form class="app-search d-none d-md-block">
                        <div class="position-relative">
                            <p id="cTime" data-time="{{ Carbon\Carbon::now()->valueOf() }}" style="
    margin-bottom: 0;
    margin-top: 9px;
"></p>
                        </div>

                    </form>
                </div>

                <div class="d-flex align-items-center">

                    <div class="dropdown d-md-none topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                id="page-header-search-dropdown" data-bs-toggle="dropdown" aria-haspopup="true"
                                aria-expanded="false">
                            <i class="bx bx-search fs-22"></i>
                        </button>
                        <div class="dropdown-menu dropdown-menu-lg dropdown-menu-end p-0"
                             aria-labelledby="page-header-search-dropdown">
                            <form class="p-3">
                                <div class="form-group m-0">
                                    <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Search ..."
                                               aria-label="Recipient's username">
                                        <button class="btn btn-primary" type="submit"><i
                                                class="mdi mdi-magnify"></i></button>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>

                    <div class="dropdown ms-1 topbar-head-dropdown header-item">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            <img id="" src="{{ asset('assets/images/flags/'.currentLocale().'.jpg') }}" alt="Language" height="20"
                                 class="rounded">
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            @foreach($languages as $language)
                                <a href="{{ route('locale',$language->code) }}" class="dropdown-item notify-item language py-2" data-lang="en"
                                   title="English">
                                    <img src="{{ asset('assets/images/flags/'.$language->icon) }}" alt="user-image" class="me-2 rounded" height="18">
                                    <span class="align-middle">{{ $language->name }}</span>
                                </a>
                            @endforeach

                        </div>
                    </div>




                    <div class="ms-1 header-item d-none d-sm-flex">
                        <button type="button" class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle"
                                data-toggle="fullscreen">
                            <i class='bx bx-fullscreen fs-22'></i>
                        </button>
                    </div>

{{--                    <div class="ms-1 header-item d-none d-sm-flex">--}}
{{--                        <button type="button"--}}
{{--                                class="btn btn-icon btn-topbar btn-ghost-secondary rounded-circle light-dark-mode">--}}
{{--                            <i class='bx bx-moon fs-22'></i>--}}
{{--                        </button>--}}
{{--                    </div>--}}



                    <div class="dropdown ms-sm-3 header-item topbar-user">
                        <button type="button" class="btn" id="page-header-user-dropdown" data-bs-toggle="dropdown"
                                aria-haspopup="true" aria-expanded="false">
                        <span class="d-flex align-items-center">
                            <img class="rounded-circle header-profile-user" src="{{ asset('assets/images/users/user-dummy-img.jpg') }}"
                                 alt="Header Avatar">
                            <span class="text-start ms-xl-2">
                                <span class="d-none d-xl-inline-block ms-1 fw-medium user-name-text">{{ currentUser()->full_name }}</span>
                                <span class="d-none d-xl-block ms-1 fs-12 text-muted user-name-sub-text">{{ currentUser()->position->title ?? '' }}</span>
                            </span>
                        </span>
                        </button>
                        <div class="dropdown-menu dropdown-menu-end">
                            <!-- item-->
                            <h6 class="dropdown-header">@lang('hello') {{ currentUser()->name_ka }}!</h6>
{{--                            <a class="dropdown-item" href="pages-profile.html"><i--}}
{{--                                    class="mdi mdi-account-circle text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Profile</span></a>--}}
{{--                            <a class="dropdown-item" href="apps-chat.html"><i--}}
{{--                                    class="mdi mdi-message-text-outline text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Messages</span></a>--}}
{{--                            <a class="dropdown-item" href="apps-tasks-kanban.html"><i--}}
{{--                                    class="mdi mdi-calendar-check-outline text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Taskboard</span></a>--}}
{{--                            <a class="dropdown-item" href="pages-faqs.html"><i--}}
{{--                                    class="mdi mdi-lifebuoy text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Help</span></a>--}}
{{--                            <div class="dropdown-divider"></div>--}}
{{--                            <a class="dropdown-item" href="pages-profile.html"><i--}}
{{--                                    class="mdi mdi-wallet text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Balance : <b>$5971.67</b></span></a>--}}
                            <a class="dropdown-item" href="{{ route('change.password') }}"><i
                                    class="mdi mdi-key text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle">@lang('change_password')</span></a>
{{--                            <a class="dropdown-item" href="auth-lockscreen-basic.html"><i--}}
{{--                                    class="mdi mdi-lock text-muted fs-16 align-middle me-1"></i> <span--}}
{{--                                    class="align-middle">Lock screen</span></a>--}}
                            <a class="dropdown-item" href="{{ route('logout') }}" onclick="event.preventDefault();
                                                     document.getElementById('logout-form').submit();"><i
                                    class="mdi mdi-logout text-muted fs-16 align-middle me-1"></i> <span
                                    class="align-middle" data-key="t-logout">@lang('logout')</span></a>
                            <form id="logout-form" action="{{ route('logout') }}" method="POST" class="d-none">
                                @csrf
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </header>
    <!-- ========== App Menu ========== -->
    <div class="app-menu navbar-menu">
        <!-- LOGO -->
        <div class="navbar-brand-box">
            <!-- Dark Logo-->
            <a href="{{ route('dashboard') }}" class="logo logo-dark">
                    <span class="logo-sm">
                        <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="22">
                    </span>
                <span class="logo-lg">
                        <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="17">
                    </span>
            </a>
            <!-- Light Logo-->
            <a href="{{ route('dashboard') }}" class="logo logo-light">
                    <span class="logo-sm">
                        <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="30">
                    </span>
                <span class="logo-lg">
                        <img src="https://www.batumiview.com/assets/v4/images/logo.png" alt="" height="50">
                    </span>
            </a>
            <button type="button" class="btn btn-sm p-0 fs-20 header-item float-end btn-vertical-sm-hover" id="vertical-hover">
                <i class="ri-record-circle-line"></i>
            </button>
        </div>

        @include('partials.sidebar')

        <div class="sidebar-background"></div>
    </div>
    <!-- Left Sidebar End -->
    <!-- Vertical Overlay-->
    <div class="vertical-overlay"></div>

    @yield('content')
    <footer class="footer">
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-6">
                    <script>document.write(new Date().getFullYear())</script> © HRMS.
                </div>
{{--                <div class="col-sm-6">--}}
{{--                    <div class="text-sm-end d-none d-sm-block">--}}
{{--                    </div>--}}
{{--                </div>--}}
            </div>
        </div>
    </footer>

<!-- end main content-->

</div>
<!-- END layout-wrapper -->



<!--start back-to-top-->
<button onclick="topFunction()" class="btn btn-danger btn-icon" id="back-to-top">
    <i class="ri-arrow-up-line"></i>
</button>
<!--end back-to-top-->

<!--preloader-->
<div id="preloader">
    <div id="status">
        <div class="spinner-border text-primary avatar-sm" role="status">
            <span class="visually-hidden">Loading...</span>
        </div>
    </div>
</div>

{{--<div class="customizer-setting d-none d-md-block">--}}
{{--    <div class="btn-info btn-rounded shadow-lg btn btn-icon btn-lg p-2" data-bs-toggle="offcanvas" data-bs-target="#theme-settings-offcanvas" aria-controls="theme-settings-offcanvas">--}}
{{--        <i class='mdi mdi-spin mdi-cog-outline fs-22'></i>--}}
{{--    </div>--}}
{{--</div>--}}

<!-- Theme Settings -->

<!-- JAVASCRIPT -->
<script src="{{ asset('assets/libs/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<script src="{{ asset('assets/libs/simplebar/simplebar.min.js') }}"></script>
<script src="{{ asset('assets/libs/node-waves/waves.min.js') }}"></script>
<script src="{{ asset('assets/libs/feather-icons/feather.min.js') }}"></script>
<script src="{{ asset('assets/js/pages/plugins/lord-icon-2.1.0.js') }}"></script>
<script src="{{ asset('assets/js/plugins.js') }}"></script>

<!-- apexcharts -->
<script src="{{ asset('assets/libs/apexcharts/apexcharts.min.js') }}"></script>

<!-- Dashboard init -->
<script src="{{ asset('assets/js/pages/dashboard-crm.init.js') }}"></script>

<!-- App js -->
<script src="{{ asset('assets/js/app.js') }}"></script>
@stack('js')
<script src="{{ asset('assets/js/jqClock.min.js') }}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.inputmask/3.3.4/jquery.inputmask.bundle.min.js"></script>
<script>
    $(document).ready(function()
    {
        cts = parseInt($("#cTime").data("time"));
        $("#cTime").clock({"calendar":"false", "format":"24","langSet":"ka","timestamp":cts});
    });
</script>
</body>
</html>
