<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!--  <link rel="icon"  href="{{url('assets/icon/icon_baju.png')}}"> -->
    <title>LTE By. NS</title>
    <!-- {{url('')}} -->
    <!-- Global stylesheets -->
    <link href="{{ url('assets/css/googleapis.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/icons/icomoon/styles.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/icons/fontawesome/styles.min.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/bootstrap.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/core.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/components.css')}}" rel="stylesheet" type="text/css">
    <link href="{{url('assets/css/colors.css')}}" rel="stylesheet" type="text/css">
    <!-- /global stylesheets -->
    <style type="text/css">
        .row{
            margin: 0px;
            padding: 3px;
        }
    </style>
    <!-- Core JS files -->
    <script type="text/javascript" src="{{url('assets/js/plugins/loaders/pace.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/core/libraries/jquery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/core/libraries/bootstrap.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/loaders/blockui.min.js')}}"></script>
    <!-- /core JS files -->

    <!-- Theme JS files -->
    <script type="text/javascript" src="{{url('assets/js/plugins/visualization/d3/d3.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/visualization/d3/d3_tooltip.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/switchery.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/styling/uniform.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/bootstrap_multiselect.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/ui/moment/moment.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/daterangepicker.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/notifications/bootbox.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/core/libraries/jquery_ui/interactions.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/select2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/bootstrap_select.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/datatables.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/tables/datatables/extensions/responsive.min.js')}}"></script>

    
    <script type="text/javascript" src="{{url('assets/js/plugins/forms/selects/select2.min.js')}}"></script>

    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/anytime.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/pickadate/picker.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/pickadate/picker.date.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/pickadate/picker.time.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/pickers/pickadate/legacy.js')}}"></script>

    <script type="text/javascript" src="{{url('assets/js/pages/picker_date.js')}}"></script>

    <script type="text/javascript" src="{{url('assets/js/core/app.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/form_inputs.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/form_select2.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/form_select2.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/plugins/ui/ripple.min.js')}}"></script>
    


    

    <!-- /theme JS files -->
    <script type="text/javascript" src="{{url('assets/swal/sweetalert2.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/swal/bootbox.min.js')}}"></script>
    <script type="text/javascript" src="{{url('assets/js/pages/components_modals.js')}}"></script>




    <script type="text/javascript">
        function alert(code,text) {
             if (code==200) {
             
                Swal.fire({
                  icon: 'success',
                  title: 'Good Job . . .',
                  text: text,
                  showConfirmButton: false,
                  timer: 1500,
                  width: '50rem'
                });
             }else if (code==422){
                Swal.fire({
                  icon: 'error',
                  title: 'Oopsss . . .',
                  text: text,
                  showConfirmButton: true,
                  width: '50rem'
                });
             }else if (code==500){
                Swal.fire({
                  icon: 'error',
                  title: 'Oopsss . . .',
                  text: text,
                  showConfirmButton: true,
                  width: '50rem'
                });
             }

        }

        function loading(){
            $.blockUI({ 
                message: '<i class="icon-spinner4 spinner"></i>',
                overlayCSS: {
                    backgroundColor: '#1b2024',
                    opacity: 0.8,
                    cursor: 'wait'
                },
                css: {
                    border: 0,
                    color: '#fff',
                    padding: 0,
                    backgroundColor: 'transparent'
                }
            });
        }
    </script>
   

</head>

<body>

    <!-- Main navbar -->
    <div class="navbar navbar-inverse bg-indigo">
        <div class="navbar-header">
            <a class="navbar-brand" href="#"></a>
            <h4>
                LTE by. NS
            </h4>
        </div>

        <div class="navbar-collapse collapse" id="navbar-mobile">
            <ul class="nav navbar-nav">
                <li><a class="sidebar-control sidebar-main-toggle"><i class="icon-paragraph-justify3"></i></a></li>
            </ul>
        </div>
    </div>
    <!-- /main navbar -->


    <!-- Page container -->
    <div class="page-container">

        <!-- Page content -->
        <div class="page-content">

            <!-- Main sidebar -->
            <div class="sidebar sidebar-main sidebar-default">
                <div class="sidebar-content">

                    <!-- User menu -->
                    @include('layouts.user_menu')
                    <!-- /user menu -->


                    <!-- Main navigation -->
                    <div class="sidebar-category sidebar-category-visible">
                        <!-- <div class="category-content no-padding"> -->
                            @include('layouts.menu')
                        <!-- </div> -->
                    </div>
                    <!-- /main navigation -->

                </div>
            </div>
            <!-- /main sidebar -->


            <!-- Main content -->
            <div class="content-wrapper">

                <!-- Page header -->
                    @yield('header')
                <!-- /page header -->

                

                  
                    @yield('content')
                    
          
            </div>
            <!-- /main content -->

        </div>
        <!-- /page content -->

    </div>
    <!-- /page container -->
@yield('modal')
@yield('js')
</body>
</html>
