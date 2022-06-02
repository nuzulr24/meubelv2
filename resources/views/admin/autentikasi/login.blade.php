<!DOCTYPE html>

<html>

    <head>

        <meta charset="utf-8">

        <meta http-equiv="X-UA-Compatible" content="IE=edge">

        <title><?= getContact()['title'] ?> | Log in</title>

        <!-- Tell the browser to be responsive to screen width -->
        <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
        @include('admin.elemen.static_css')
        <style>
        .login-page {
            background-image: url({{ asset('admin_assets/dist/img/boxed-bg.jpg') }});
        }
        </style>
        <!-- Google Font -->
        <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

   </head>

    <body class="hold-transition login-page">

        <div class="login-box">

            @if (session()->has('fail'))
                <div class="alert alert-danger alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-ban"></i> ERROR!</h4>
                    {{ session('fail') }}
                </div>
            @elseif (session()->has('success'))
                <div class="alert alert-success alert-dismissible">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h4><i class="icon fa fa-check"></i> Success!</h4>
                    {{ session('success') }}
                </div>
            @endif

            <div class="login-box-body">

                <div class="login-logo"><a href="{{ route('login_admin') }}">

                    <i class="fa fa-cubes"></i> <b><?= getShortName(getContact()['title']) ?></b>Admin</a>

                </div>

                <h3 class="text-center">Login Administator</h3><hr style="border:0.5px solid #d2d6de;">

                {!! Form::open(['route' => 'proses_login_admin']) !!}
                    @csrf

                    <div class="form-group has-feedback {{ session()->has('fail') ? 'has-error' : '' }}">
                        {!! Form::email('email', null, ['class' => 'form-control', 'placeholder' => 'Enter Email']) !!}
                        <span class="fa fa-user form-control-feedback"></span>
                        @if(session()->has('fail')) <span clas="help-block">Masukan Email</span> @endif
                    </div>

                    <div class="form-group has-feedback {{ session()->has('fail') ? 'has-error' : '' }}">
                        {!! Form::password('password', ['class' => 'form-control', 'placeholder' => 'Enter Password']) !!}
                        <span class="fa fa-lock form-control-feedback"></span>
                        @if(session()->has('fail')) <span clas="help-block">Masukan Password</span> @endif
                    </div>

                    <div class="row">

                        <!-- /.col -->
                        <div class="col-xs-12">

                            <button type="submit" name="simpan" value="true" class="btn btn-primary btn-block btn-flat">Masuk</button>

                        </div>

                        <!-- /.col -->
                    </div>

                {!! Form::close() !!}

            </div>
            <!-- /.login-box-body -->

            <p class="text-center" style="margin-top: 50px;">
                Copyright &copy; <?= date('Y') ?> <b><?= getContact()['title'] ?></b>. All rights reserved.
            </p>

        </div>
        <!-- /.login-box -->

        @include('admin.elemen.static_js')
    </body>
</html>
