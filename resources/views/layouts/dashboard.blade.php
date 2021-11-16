<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1,user-scalable=0"/>
        <title>BillingPlusU | @yield('title')</title>
        <link rel="shortcut icon" type="image/x-icon" href="{{ URL::asset('images/logo-favicon-32x32.png') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/bootstrap.min.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/circular-std/style.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/fonts/fontawesome/css/fontawesome-all.css') }}">
        <link rel="stylesheet" href="{{ URL::asset('css/style.css') }}">
        @yield('head')
    </head>
    <body>
        <div class="dashboard-main-wrapper">
            <div class="dashboard-header">
                <nav class="navbar navbar-expand-lg bg-white fixed-top">
                    <div class="p-2 mr-auto">
                        <a href="{{ url('index') }}"><img src="{{ URL::asset('images/logo-blue-web-466x277.png') }}" alt="BillingPlusU" width="75" height="50" /></a>
                    </div>
                    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                </nav>
            </div>
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
                                @if ($user_type == "personal")
                                    <li class="nav-item ">
                                        <a class="nav-link" href="{{ url('dashboard_personal') }}"><i class="fab fa-wpforms" style="color:white"></i>Dashboard</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('data_analytics_personal') }}"><i class="fas fa-chart-bar" style="color:white"></i>Data Analytics</a>
                                    </li>
                                @elseif ($user_type == "processor")
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard_processor') }}"><i class="fas fa-users" style="color:white"></i>Manage Specialists<span class="badge badge-success">6</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('data_analytics_processor') }}"><i class="fas fa-chart-bar" style="color:white"></i>Data Analytics</a>
                                    </li>
                                @elseif ($user_type == "admin")
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('dashboard_admin') }}"><i class="fas fa-chart-line" style="color:white"></i>Overview<span class="badge badge-success">6</span></a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('manage_claim_admin') }}"><i class="fas fa-file-medical" style="color:white"></i>Manage Claims</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('manage_user_admin') }}"><i class="fas fa-users" style="color:white"></i>Manage Users</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('manage_feedback_admin') }}"><i class="fas fa-newspaper" style="color:white"></i>Manage Feedbacks</a>
                                    </li>
                                @endif
                                <li class="nav-divider">
                                    <hr>
                                </li>
                                <li class="nav-item ">
                                    <a class="nav-link" href="{{ url('change_password') }}"><i class="fas fa-key" style="color:white"></i>Change Password</a>
                                </li>
                                @if ($user_type != "admin")
                                    <li class="nav-item">
                                        <a class="nav-link" href="{{ url('contact_us') }}"><i class="fas fa-paper-plane" style="color:white"></i>Contact Us</a>
                                    </li>
                                @endif
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ url('logout') }}"><i class="fas fa-power-off" style="color:white"></i>Logout</a>
                                </li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>
            @section('body')
            @show
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
        </div>
        <script src="{{ URL::asset('js/jquery/jquery-3.3.1.min.js') }}"></script>
        <script src="{{ URL::asset('js/bootstrap/bootstrap.bundle.js') }}"></script>
        @yield('foot')
    </body>
</html>
