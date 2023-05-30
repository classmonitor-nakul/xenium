<!DOCTYPE html>
<html lang="en">

<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<title>{{ env('APP_NAME') }}</title>
<!-- Tell the browser to be responsive to screen width -->
<meta name="viewport" content="width=device-width, initial-scale=1">
<meta name="csrf-token" content="{{ csrf_token() }}">
<!-- Favicon -->
<link rel="icon" type="image/png" sizes="16x16" href="{{ asset('assets/images/icon.png') }}">

<!-- Google Font -->
<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700" rel="stylesheet">

<!-- v4.0.0 -->
<link rel="stylesheet" href="{{ asset('assets/bootstrap/css/bootstrap.min.css') }}">

<!-- Theme style -->
<link rel="stylesheet" href="{{ asset('assets/css/style.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/fontawesome/css/all.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/et-line-font/et-line-font.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/themify-icons/themify-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/simple-lineicon/simple-line-icons.css') }}">
<link rel="stylesheet" href="{{ asset('assets/css/custom.css') }}">
<!-- jQuery 3 --> 
<script src="{{ asset('assets/js/jquery.min.js') }}"></script>

<!-- v4.0.0-alpha.6 -->
<script src="{{ asset('assets/bootstrap/js/bootstrap.bundle.min.js') }}"></script>

<!-- template --> 
<script src="{{ asset('assets/js/adminkit.js') }}"></script>

<!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
<!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
<!--[if lt IE 9]>
  <script src="https://oss.maxcdn.com/html5shiv/3.7.3/html5shiv.min.js"></script>
  <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
<![endif]-->
@yield('styles')
</head>
<body class="sidebar-mini sidebar-collapse">
<div class="wrapper boxed-wrapper">
  <header class="main-header"> 
    <!-- Logo --> 
    <a href="{{ route('dashboard') }}" class="logo blue-bg"> 
    <!-- mini logo for sidebar mini 50x50 pixels --> 
    <span class="logo-mini"><img src="{{ asset('assets/images/icon.png') }}" alt=""></span> 
    <!-- logo for regular state and mobile devices --> 
    <span class="logo-lg"><img src="{{ asset('assets/images/logo-white.png') }}" alt=""></span> </a> 
    <!-- Header Navbar -->
    <nav class="navbar blue-bg navbar-static-top"> 
      <!-- Sidebar toggle button-->
      <ul class="nav navbar-nav pull-left">
        <li><a class="sidebar-toggle" data-toggle="push-menu" href="#"></a> </li>
      </ul>
      <div class="navbar-custom-menu">
        <ul class="nav navbar-nav">
          <!-- Messages -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa-light fa-envelope"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">You have 0 new messages</li>
              <li>
                <ul class="menu">
                </ul>
              </li>
              <li class="footer"><a href="#">View All Messages</a></li>
            </ul>
          </li>
          <!-- Notifications  -->
          <li class="dropdown messages-menu"> <a href="#" class="dropdown-toggle" data-toggle="dropdown"> <i class="fa-light fa-bell"></i>
            <div class="notify"> <span class="heartbit"></span> <span class="point"></span> </div>
            </a>
            <ul class="dropdown-menu">
              <li class="header">Notifications</li>
              <li>
                <ul class="menu">
                </ul>
              </li>
              <li class="footer"><a href="#">Check all Notifications</a></li>
            </ul>
          </li>
          <!-- User Account  -->
          <li class="dropdown user user-menu p-ph-res"> 
            <a href="#" class="dropdown-toggle" data-toggle="dropdown"> 
              <img src="{{ asset('assets/img/23804676.jpeg') }}" class="user-image" alt="User Image"> 
              <span class="hidden-xs">{{ Auth::user()->name }}</span> 
            </a>
            <ul class="dropdown-menu">
              <li class="user-header">
                <p class="text-left">{{ Auth::user()->name }} <small>{{ Auth::user()->email }}</small> </p>
              </li>
              <li><a href="{{route('profile.edit')}}"><i class="fa-light fa-user mr-3"></i>Profile</a></li>
              <li role="separator" class="divider"></li>
              <li><a href="route('logout')"><i class="fa-light fa-power-off mr-3"></i>Logout
                
                <form method="POST" action="{{ route('logout') }}" onclick="event.preventDefault();this.closest('form').submit();">
                @csrf
                </form>  
              </a></li>
            </ul>
          </li>
        </ul>
      </div>
    </nav>
  </header>
  <!-- Left side column. contains the logo and sidebar -->
  @include('layouts.pos.partials.sidemenu')
  <!-- Content Wrapper. Contains page content -->
  <div class="content-wrapper"> 
    <!-- Content Header (Page header) -->
    <div class="content-header sty-one">
      <h1>{{ $title }}</h1>
      <ol class="breadcrumb">
        <li><a href="#">Dashboard</a></li>
        <li><i class="fa fa-angle-right mx-1"></i> {{ $module }}</li>
        <li><i class="fa fa-angle-right mx-1"></i> {{ $title }}</li>
      </ol>
    </div>
    
    <!-- Main content -->
    <div class="content">
      @yield('content')
    </div>
    <!-- /.content --> 
  </div>
  <!-- /.content-wrapper -->
  <footer class="main-footer">
    <div class="pull-right hidden-xs">Version 1.0</div>
    Copyright © 2023 Cubotrix Technologies. All rights reserved.</footer>
</div>
<!-- ./wrapper --> 
@yield('scripts')
</body>

<!-- Mirrored from uxliner.com/adminkit/demo/minisidebar/ltr/pages-blank.html by HTTrack Website Copier/3.x [XR&CO'2014], Fri, 14 May 2021 18:47:41 GMT -->
</html>
