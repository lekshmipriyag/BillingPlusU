<!doctype html>
<html lang="en">
    
    <head>
        <!-- Required meta tags -->
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <title>BillingPlusU | @yield('title')</title>
        <!-- Bootstrap CSS -->
        <link rel="shortcut icon" type="image/x-icon" href="http://billingplus.com/wp-content/uploads/2017/05/logo-favicon-32x32.png">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/circular-std/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/fonts/fontawesome/css/fontawesome-all.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/notika-custom-icon.css') }}">
        
        @yield('head')
    </head>
    <body>
        <div class="dashboard-main-wrapper">
            <!-- ============================================================== -->
            <!-- navbar -->
            <!-- ============================================================== -->
            <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white fixed-top">
                    <div class="p-2 mr-auto">
                        <a href="{{ url('dashboard_personal') }}"><img src="http://billingplus.com/wp-content/uploads/2017/05/logo-blue-web-466x277.png" alt="BillingPlusU" width="75" height="50" /></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                        <div class="collapse navbar-collapse " id="navbarSupportedContent">
                        <ul class="navbar-nav ml-auto navbar-right-top">
                            <li class="nav-item">
                                <div id="custom-search" class="top-search-bar">
                                    <input class="form-control" type="text" placeholder="Search..">
                                </div>
                            </li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- ============================================================== -->
            <!-- end navbar -->
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- left sidebar -->
            <!-- ============================================================== -->
            <div class="nav-left-sidebar sidebar-dark" id="side-menu">
                <div class="menu-list">
                    <nav class="navbar navbar-expand-lg navbar-light">
                        <a class="d-xl-none d-lg-none" href="#"></a>
                        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                        </button>
                        <div class="collapse navbar-collapse" id="navbarNav">
                            <ul class="navbar-nav flex-column">
                                <li class="nav-divider">
                                    MENU
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ url('dashboard_personal') }}" data-target="#submenu-1" aria-controls="submenu-1"><i class="fab fa-wpforms" style="color:white"></i>Dashboard</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('data_analytics') }}" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-chart-bar" style="color:white"></i>Data Analytics</a>
                                </li>
                                <li class="nav-divider">
                                    <hr>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ url('change_password') }}" data-target="#submenu-3" aria-controls="submenu-3"><i class="fas fa-key" style="color:white"></i>Change Password</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('contact_us') }}" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-paper-plane" style="color:white"></i>Contact Us</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('logout') }}" data-target="#submenu-2" aria-controls="submenu-2"><i class="fas fa-power-off" style="color:white"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end left sidebar -->
            <!-- ============================================================== -->
            @section('body')
            @show
            <!-- ============================================================== -->
            <!-- ============================================================== -->
            <!-- footer -->
            <!-- ============================================================== -->
            <div class="footer">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                        </div>
                        <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-12">
                                <p>To see more of what we do, visit <a href="http://billingplus.com">BillingPlus</a></p>
                        </div>
                    </div>
                </div>
            </div>
            <!-- ============================================================== -->
            <!-- end footer -->
            <!-- ============================================================== -->
        </div>
        
        <!-- jquery
        ============================================ -->
        <script src="{{ URL::asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <!-- bootstrap JS
        ============================================ -->
        <script src="{{ URL::asset('js/bootstrap/bootstrap.bundle.js') }}"></script>
        @yield('foot')
    </body>
</html>
