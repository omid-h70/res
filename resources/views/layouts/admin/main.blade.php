<!DOCTYPE html>
<html >

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('admin.panel_title') }}</title>
    
    <!-- Local Fonts-->
    <?php Helper::loadLocalFonts( App::getLocale() ); ?>
    
    <!-- Style CSS -->
    <link href="{{ asset( '/public/css/style.css') }}" rel="stylesheet">
    
    <!-- Timeline CSS -->
    <link href="{{ asset( '/public/admin_panel/dist/css/timeline.css') }}" rel="stylesheet">

    <!-- Custom CSS -->
    @section('linked-stylesheets')@show
    @section('locale-stylesheets')@show
   
    <!-- jQuery -->
    <script src="{{ asset( '/public/js/jquery/jquery-2.2.4.min.js') }}"></script>
    
    <!-- Includes -->
    @include('layouts.styles.bootstrap' )
    @include('layouts.styles.font-awesome')

    <!-- Locale CSS Style-->
    <?php Helper::loadStylesheet( App::getLocale() ); ?>
    
    <!-- Local Fonts-->
    <?php Helper::loadLocalFonts( App::getLocale() ); ?>
    
    <!-- MetisMenu CSS -->
    <link href="{{ asset( '/public/admin_panel/bower_components/metisMenu/dist/metisMenu.min.css') }}" rel="stylesheet">
    
    <!-- Metis Menu-->
    <script src="{{ asset( '/public/admin_panel/bower_components/metisMenu/dist/metisMenu.min.js') }}"></script>
    
    @section('extra-includes') @show
    
    <!-- Custom Theme JavaScript -->
    <script src="{{ asset( '/public/js/helper.js') }}"></script>
    
    <script src="{{ asset( '/public/admin_panel/dist/js/sb-admin-2.js') }}"></script>

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
        <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->  
    @section('extra-scripts') @show
 
    <style type="text/css">
        .absolute-center {
            position:absolute;
            left:0px;
            right:0px; 
            padding:10px;
            width:300px;
            z-index:500;
         }
         .success-text{
             color:green;
             
         }
         .alert-text{
             color:red;
             border:1px solid red;
         }
    </style>  
    @section('extra-stylesheets') @show
</head>
<body>

    <div id="wrapper">

        <!-- Navigation -->
        <nav class="navbar navbar-default navbar-static-top" role="navigation" style="margin-bottom: 0">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                    <span class="sr-only">Toggle navigation</span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                    <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="index.html">{{ trans('admin.panel_title') }}</a>
            </div>
            <!-- /.navbar-header -->

            <ul class="nav navbar-top-links navbar-right">
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-envelope fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-messages">
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a href="#">
                                <div>
                                    <strong>John Smith</strong>
                                    <span class="pull-right text-muted">
                                        <em>Yesterday</em>
                                    </span>
                                </div>
                                <div>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Pellentesque eleifend...</div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        <li>
                            <a class="text-center" href="#">
                                <strong>Read All Messages</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-messages -->
                </li>
                <!-- /.dropdown -->

                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-bell fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-alerts">
                    @if( !empty($_global_notification_array) )
                        @foreach ( $_global_notification_array as $key => $notify )
                        <li>
                            <a href="#">
                                <div>
                                    <i class="fa fa-info-circle fa-fw"></i> {{ $notify['notification_title'] }}
                                    <span class="pull-right text-muted small">{{ $notify['created_at'] }}</span>
                                </div>
                            </a>
                        </li>
                        <li class="divider"></li>
                        @endforeach
                    @endif
                    <li>
                            <a class="text-center" href="#">
                                <strong>See All Alerts</strong>
                                <i class="fa fa-angle-right"></i>
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-alerts -->
                </li>
                <!-- /.dropdown -->
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="#">
                        <i class="fa fa-user fa-fw"></i>  <i class="fa fa-caret-down"></i>
                    </a>
                    <ul class="dropdown-menu dropdown-user">                    
                        <li>
                            <a href="{{ url(App::getLocale().'/auth/logout') }}">
                                <i class="fa fa-sign-out fa-fw"></i> 
                                {{ trans('auth.log_out') }}
                            </a>
                        </li>
                    </ul>
                    <!-- /.dropdown-user -->
                </li>
                <!-- /.dropdown -->
            </ul>
            <!-- /.navbar-top-links -->
            @yield('sidebar')
        </nav>
        <div id="page-wrapper">
            @include('layouts.main.absolute-message-box',[
                'user_role'    => 'super_user',
            ])   
            
            @yield('content')
        </div>
    </div><!-- #weapper -->
 
   
    @yield('end_page_scripts')
</body>

</html>      