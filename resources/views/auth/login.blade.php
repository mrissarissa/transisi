<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- <link rel="icon"  href="{{url('assets/icon/icon_baju.png')}}"> -->
    <title>Test</title>

    <!-- Global stylesheets -->
    <link href="{{ url('assets/css/googleapis.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->

    <!-- Core JS files -->
    <script type="text/javascript" src="{{url('assets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>

    <script type="text/javascript" src="{{url('assets/js/core/app.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/login.js')}}"></script>

    <script type="text/javascript" src="{{url('assets/js/plugins/ui/ripple.min.js')}}"></script>
    
    <!-- /theme JS files -->
    
</head>

<body class="login-container" class="login-container" style="background-image: url('assets/icon/windows.jpg'); background-position: center; background-repeat: no-repeat; height: 100%;  background-size: cover; ">



    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Content area -->
                <div class="content">

                    <!-- Advanced login -->
                    <form action="{{route('login')}}" id="form-login" method="POST">
                         @csrf
                        <div class="panel panel-body login-form">
                            <div class="text-center">
                                <h3>Transisi</h3>
                            </div>
                            <div class="text-center">
                                <!-- <div class="icon-object border-slate-300 text-slate-300"><i class="icon-reading"></i></div> -->
                                <img src="{{url('assets/icon/icon_w10.png')}}" width="150">
                                <h5 class="content-group">Login to your account</h5>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="text" class="form-control {{ $errors->has('email') ? ' is-invalid' : '' }}" placeholder="email" id="email" name="email" value="{{ old('email') }}" required="" autofocus >
                                @if ($errors->has('email'))
                                    <span class="invalid-feedback">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                @endif
                                <div class="form-control-feedback">
                                    <i class="icon-user text-muted"></i>
                                </div>
                            </div>

                            <div class="form-group has-feedback has-feedback-left">
                                <input type="password" class="form-control{{ $errors->has('password') ? ' is-invalid' : '' }}" placeholder="Password" id="password" name="password" required="">
                                @if ($errors->has('password'))
                                    <div class="alert alert-danger fade in">
                                        <strong>{{ $errors->first('password') }}</strong>
                                    </div>
                                @endif
                                <br>
                                <div class="form-control-feedback">
                                    <i class="icon-lock2 text-muted"></i>
                                </div>
                            </div>


                            <div class="form-group">
                                <button type="submit" class="btn bg-pink-400 btn-block" id="btn-login">Login <i class="icon-arrow-right14 position-right"></i></button>
                            </div>
                        </div>
                    </form>
                    <!-- /advanced login -->


                    

                </div>
                <!-- /content area -->

            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->


</body>
</html>
