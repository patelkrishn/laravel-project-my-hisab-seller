<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>Dashboard </title>

    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="{{ asset('plugins/fontawesome-free/css/all.min.css') }}">
    <!-- IonIcons -->
    <link rel="stylesheet" href="http://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css">
    <!-- DataTables -->
    <link rel="stylesheet" href="{{ asset('plugins/datatables-bs4/css/dataTables.bootstrap4.css') }}">
    <!-- Theme style -->
    <link rel="stylesheet" href="{{ asset('dist/css/adminlte.min.css') }}">
    <!-- summernote -->
    <link rel="stylesheet" href="{{ asset('plugins/summernote/summernote-bs4.css') }}">
    <!-- Google Font: Source Sans Pro -->
    <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">
    <!-- Toastr -->
    <link rel="stylesheet" href="{{ asset('plugins/toastr/toastr.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2/css/select2.min.css') }}">
    <link rel="stylesheet" href="{{ asset('plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css') }}">
    <style>
        #loader {
  font-size: 10px;
  margin: 50px auto;
  text-indent: -9999em;
  width: 11em;
  height: 11em;
  border-radius: 50%;
  background: #0080ff;
  background: -moz-linear-gradient(left, #0080ff 10%, rgba(0,128,255, 0) 42%);
  background: -webkit-linear-gradient(left, #0080ff 10%, rgba(0,128,255, 0) 42%);
  background: -o-linear-gradient(left, #0080ff 10%, rgba(0,128,255, 0) 42%);
  background: -ms-linear-gradient(left, #0080ff 10%, rgba(0,128,255, 0) 42%);
  background: linear-gradient(to right, #0080ff 10%, rgba(0,128,255, 0) 42%);
  position: relative;
  -webkit-animation: load3 1.4s infinite linear;
  animation: load3 1.4s infinite linear;
  -webkit-transform: translateZ(0);
  -ms-transform: translateZ(0);
  transform: translateZ(0);
}
#loader:before {
  width: 50%;
  height: 50%;
  background: #0080ff;
  border-radius: 100% 0 0 0;
  position: absolute;
  top: 0;
  left: 0;
  content: '';
}
#loader:after {
  background: #ffffff;
  width: 75%;
  height: 75%;
  border-radius: 50%;
  content: '';
  margin: auto;
  position: absolute;
  top: 0;
  left: 0;
  bottom: 0;
  right: 0;
}
@-webkit-keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}
@keyframes load3 {
  0% {
    -webkit-transform: rotate(0deg);
    transform: rotate(0deg);
  }
  100% {
    -webkit-transform: rotate(360deg);
    transform: rotate(360deg);
  }
}

    </style>
    {{-- <link href="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/css/select2.min.css" rel="stylesheet" />
<script src="https://cdn.jsdelivr.net/npm/select2@4.0.13/dist/js/select2.min.js"></script> --}}
</head>
@guestApi
    
@yield('login-content')
@guestElse
<!--
BODY TAG OPTIONS:
=================
Apply one or more of the following classes to to the body tag
to get the desired effect
|---------------------------------------------------------|
|LAYOUT OPTIONS | sidebar-collapse                        |
|               | sidebar-mini                            |
|---------------------------------------------------------|
-->
<body class="hold-transition sidebar-mini layout-navbar-fixed layout-fixed">
<div class="wrapper">
    <!-- Navbar -->
    <nav class="main-header navbar navbar-expand navbar-white navbar-light">
        <!-- Left navbar links -->
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link" data-widget="pushmenu" href="#"><i class="fas fa-bars"></i></a>
            </li>
            <li class="nav-item d-none d-sm-inline-block">
                <a href="" class="nav-link">@yield('nav_title')</a>
            </li>
        </ul>

    {{-- <!-- SEARCH FORM -->
    <form class="form-inline ml-3">
      <div class="input-group input-group-sm">
        <input class="form-control form-control-navbar" type="search" placeholder="Search" aria-label="Search">
        <div class="input-group-append">
          <button class="btn btn-navbar" type="submit">
            <i class="fas fa-search"></i>
          </button>
        </div>
      </div>
    </form> --}}

    <!-- Right navbar links -->
        <ul class="navbar-nav ml-auto">
            <!-- Notifications Dropdown Menu -->
            <li class="nav-item dropdown">
                <a class="nav-link" data-toggle="dropdown" href="#">
                    <i class="far fa-bell"></i>
                    {{-- @if ($notificationsCount!=NULL) --}}
                        <span class="badge badge-warning navbar-badge">5</span>
                    {{-- @endif --}}
                </a>
                <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <span class="dropdown-item dropdown-header">You have 5 Notifications</span>
                    <div class="dropdown-divider"></div>
                    {{-- @foreach ($notifications as $item) --}}
                            <a href="#" class="dropdown-item">
                                <i class="fas fa-envelope mr-2"></i> 5 new messages
                                <span class="float-right text-muted text-sm">3 mins</span>
                              </a>
                        <div class="dropdown-divider"></div>
                    {{-- @endforeach --}}


                    <a href="#" class="dropdown-item dropdown-footer">See All Notifications</a>
                </div>
            </li>
            <li class="nav-item dropdown user-menu">
                <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">
                    <img src="{{asset('/dist/img/user2-160x160.jpg')}}" class="user-image img-circle elevation-2" alt="User Image">
                    <span class="d-none d-md-inline">{{ AuthApi::name() }}</span>
                </a>
                <ul class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                    <!-- User image -->
                    <li class="user-header bg-primary">
                        <img src="{{asset('/dist/img/user2-160x160.jpg')}}" class="img-circle elevation-2" alt="User Image">

                        <p>
                            {{ AuthApi::name() }}
                        </p>
                    </li>
                <!-- Menu Footer-->
                    <li class="user-footer">
                        <a href="" class="btn btn-default btn-flat">Profile</a>
                        <a href="/logout" class="btn btn-default btn-flat float-right"
                           onclick="event.preventDefault();
                      document.getElementById('logout-form').submit();">Sign out</a>
                        <form id="logout-form" action="/logout" method="GET" style="display: none;">
                            @csrf
                        </form>
                    </li>
                </ul>
            </li>
        </ul>
    </nav>
    <!-- /.navbar -->

    <!-- Main Sidebar Container -->
    <aside class="main-sidebar sidebar-dark-primary elevation-4">
        <!-- Brand Logo -->
        <a href="/" class="brand-link">
            <img src="{{ asset('dist/img/AdminLTELogo.png') }}" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
                 style="opacity: .8">
            <span class="brand-text font-weight-light">My Hisab</span>
        </a>

        <!-- Sidebar -->
        <div class="sidebar">
        <!-- Sidebar Menu -->
            <nav class="mt-2">
                <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">
                    <!-- Add icons to the links using the .nav-icon class
                         with font-awesome or any other icon font library -->

                    <li class="nav-item">
                        <a href="/" class="nav-link {{ Request::path()=='home' ? 'active' : '' }}">
                            <i class="nav-icon fas fa-tachometer-alt"></i>
                            <p>
                                Dashboard
                            </p>
                        </a>
                    </li>
                    @if (Request::path()=='products' || Request::path()=='products/add')
                        <li class="nav-item has-treeview  menu-open">
                            <a href="#" class="nav-link active">
                    @else
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            @endif
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    My Products
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="/products" class="nav-link {{ Request::path()=='products' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>All Products</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        @if (Request::path()=='invoices' || Request::path()=='invoices/create')
                        <li class="nav-item has-treeview  menu-open">
                            <a href="#" class="nav-link active">
                    @else
                        <li class="nav-item has-treeview">
                            <a href="#" class="nav-link">
                            @endif
                                <i class="nav-icon fas fa-copy"></i>
                                <p>
                                    Invoices
                                    <i class="fas fa-angle-left right"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="{{route('invoices.create')}}" class="nav-link {{ Request::path()=='invoices/create' ? 'active' : '' }}">
                                        <i class="far fa-circle nav-icon"></i>
                                        <p>Create Invoices</p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                </ul>
            </nav>
            <!-- /.sidebar-menu -->
        </div>
        <!-- /.sidebar -->
    </aside>
    @endGuestApi
@yield('content')
<!-- Main content -->
</div>
<!-- /.content-wrapper -->


@guestApi

@guestElse

<!-- Main Footer -->
<footer class="main-footer">
    <strong>Copyright &copy; 2019-2020 <a href="https://myhisab.store">My Hisab</a>.</strong>
    All rights reserved.
</footer>
</div>

<!-- ./wrapper -->

<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="{{ asset('plugins/jquery/jquery.min.js') }}"></script>
<!-- Bootstrap -->
<script src="{{ asset('plugins/bootstrap/js/bootstrap.bundle.min.js') }}"></script>
<!-- AdminLTE -->
<script src="{{ asset('dist/js/adminlte.js') }}"></script>
<!-- Summernote -->
<script src="{{ asset('plugins/summernote/summernote-bs4.min.js') }}"></script>

<!-- OPTIONAL SCRIPTS -->
<script src="{{ asset('plugins/chart.js/Chart.min.js') }}"></script>
<script src="{{ asset('dist/js/demo.js') }}"></script>
<script src="{{ asset('dist/js/pages/dashboard3.js') }}"></script>
<!-- DataTables -->
<script src="{{ asset('plugins/datatables/jquery.dataTables.js') }}"></script>
<script src="{{ asset('plugins/datatables-bs4/js/dataTables.bootstrap4.js') }}"></script>
<!-- Toastr -->
<script src="{{ asset('plugins/toastr/toastr.min.js') }}"></script>
<script src="{{ asset('plugins/select2/js/select2.full.min.js') }}"></script>
{{-- <script src="{{ asset('js/app.js') }}"></script> --}}
@yield('extra-js')
@if(session()->has('success'))
    <script>
        $(document).ready(function(){
          toastr.success('{{ session()->get('success') }}')
        });
    </script>
    @endif
    @if(session()->has('error'))
    <script>
        $(document).ready(function(){
          toastr.error('{{ session()->get('error') }}')
        });
    </script>
    @endif
    @if(session()->has('warning'))
    <script>
        $(document).ready(function(){
          toastr.warning('{{ session()->get('warning') }}')
        });
    </script>
    @endif
</body>
</html>
@endGuestApi