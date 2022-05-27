<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ DB::table('tbl_website')->where('id', 1)->value('value') }} | @yield('title')</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    @include('admin.elemen.static_css')
    @yield('extra_css')
</head>
<body class="hold-transition skin-purple-light sidebar-mini">
    <div class="wrapper">
        <!-- Main Header -->
        <header class="main-header">

            <!-- Logo -->
            <a href="{{ route('beranda_admin') }}" class="logo">
            <!-- mini logo for sidebar mini 50x50 pixels -->
            <span class="logo-mini"><b>{{ getShortName(DB::table('tbl_website')->where('id', 1)->value('value')) }}</b></span>
            <!-- logo for regular state and mobile devices -->
            <span class="logo-lg"><b>{{ DB::table('tbl_website')->where('id', 1)->value('value') }}</b></span>
            </a>

            <!-- Header Navbar -->
            <nav class="navbar navbar-static-top" role="navigation">
            <!-- Sidebar toggle button-->
                <a href="#" class="sidebar-toggle" data-toggle="push-menu" role="button">
                    <span class="sr-only">Toggle navigation</span>
                </a>
                <!-- Navbar Right Menu -->
                <div class="navbar-custom-menu">
                    <ul class="nav navbar-nav">
                        <li class="dropdown user user-menu">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown">
                                <?php
                                    if (Storage::exists(public_path('storage/avatars/admin/' . session('foto_admin')))) {
                                ?>
                                    <img src="<?= public_path('storage/avatars/admin/' . session('foto_admin')) ?>" class="user-image" alt="<?= session('nama_admin') ?>">
                                <?php } else { ?>
                                    <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y" class="user-image" alt="Empty">
                                <?php } ?>
                                <span class="hidden-xs"><?= session('nama_admin') ?></span>
                            </a>
                            <ul class="dropdown-menu">

                                <li class="user-header">
                                <?php
                                    if (Storage::exists(public_path('storage/avatars/admin/' . session('foto_admin')))) {
                                ?>
                                    <img src="<?= public_path('storage/avatars/admin/' . session('foto_admin')) ?>" class="img-circle" alt="<?= session('nama_admin') ?>">
                                <?php } else { ?>
                                    <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y" class="img-circle" alt="Empty">
                                <?php } ?>
                                    <p>
                                        <?= session('nama_admin') ?>
                                    </p>
                                </li>

                                <li class="user-footer">
                                    <div class="pull-left">
                                        <a href="{{ route('profile_admin', [ 'id_admin' => session('id_admin')]) }}" class="btn btn-default btn-flat">Pengaturan</a>
                                    </div>
                                    <div class="pull-right">
                                        <a href="{{ route('logout_admin') }}" class="btn btn-default btn-flat">Keluar</a>
                                    </div>
                                </li>
                            </ul>
                        </li>
                    </ul>
                </div>
            </nav>
        </header>
        <!-- Left side column. contains the logo and sidebar -->
        <aside class="main-sidebar">

            <!-- sidebar: style can be found in sidebar.less -->
            <section class="sidebar">

                <!-- Sidebar user panel (optional) -->
                <div class="user-panel">
                    <div class="pull-left image">
                        <?php
                            if (Storage::exists(public_path('storage/avatars/admin/' . session('foto_admin')))) {
                        ?>
                            <img src="<?= public_path('storage/avatars/admin/' . session('foto_admin')) ?>" class="img-circle" alt="<?= session('nama_admin') ?>">
                        <?php } else { ?>
                            <img src="https://www.gravatar.com/avatar/205e460b479e2e5b48aec07710c08d50?f=y" class="img-circle" alt="Empty">
                        <?php } ?>
                    </div>
                    <div class="pull-left info">
                        <p><a href="{{ route('profile_admin', [ 'id_admin' => session('id_admin')]) }}">{{ session('nama_admin') }}</a></p>
                        <!-- Status -->

                        @if (session('superadmin') == true)
                            <span class="label bg-green">Super Admin</span>
                        @else
                            <span class="label bg-blue">Admin</span>
                        @endif
                    </div>
                </div>

                <!-- /.search form -->
                @include('admin.elemen.sidebar')
            </section>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <section class="content-header">
                @yield('content-header')
            </section>

            <!-- Main content -->
            <section class="@if(empty($invoice)) content container-fluid @else invoice @endif">
                @yield('content')
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        @yield('modal')

        <!-- Main Footer -->
        <footer class="main-footer">
            <!-- To the right -->
            <div class="pull-right hidden-xs">
             {{ DB::table('tbl_website')->where('id', 1)->value('value') }}
            </div>
            <!-- Default to the left -->
            <strong>Copyright &copy; {{ date('Y') }} <a href="{{ url('/admin') }}">{{ DB::table('tbl_website')->where('id', 1)->value('value') }}</a>.</strong>
        </footer>
    </div>
<!-- ./wrapper -->

<!-- REQUIRED JS SCRIPTS -->
@include('admin.elemen.static_js')
@yield('extra_js')
</body>
</html>
