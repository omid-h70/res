<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">

    <title>{{ trans('home.title') }} </title>

    <!-- Locale CSS Style-->
    <?php Helper::loadStylesheet( App::getLocale() ); ?>
    
    <!-- Local Fonts-->
    <?php Helper::loadLocalFonts( App::getLocale() ); ?>
    
    <link href="{{ asset( '/public/css/style.css') }}" rel="stylesheet">
    
        
    <!-- jQuery -->
    <script src="{{ asset( '/public/js/jquery/jquery-2.1.4.min.js') }}"></script>
    
    
    <!-- Includes -->
    @include('layouts.styles.bootstrap' )
    @include('layouts.styles.font-awesome' )
    @include('layouts.styles.gsdk' )


    <!-- Custom CSS -->
    @yield('extra-includes')
    @yield('locale-stylesheets')
    @yield('linked-stylesheets')
    
    <link href="{{ asset( '/public/admin_panel/dist/css/sb-admin-2.css') }}" rel="stylesheet">

            
    <!-- Custom Theme JavaScript -->
    @yield('extra-scripts')
    @yield('extra-stylesheets')
   
</head>
<body class="">
    <div id="navbar-full">
        <div class="container">
            <nav class="navbar navbar-ct-blue navbar-transparent navbar-fixed-top" role="navigation">
                <div class="alert alert-success">
                    <div class="container">
                        <b>Alert !!!</b> Hey Dude I'm a Notification !
                    </div>
                </div>

                <div class="container">
                    <!-- Brand and toggle get grouped for better mobile display -->
                    <div class="navbar-header">
                        <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                            <span class="sr-only">Toggle navigation</span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                            <span class="icon-bar"></span>
                        </button>
                        <a href="http://creative-tim.com">
                             <div class="logo-container">
                                <div class="logo">
                                    <img src="{{ asset('public/plugins/gsdk/assets/img/new_logo.png') }}">
                                </div>
                                <div class="brand">
                                    Creative Tim
                                </div>
                            </div>
                        </a>
                    </div>

                    <!-- Collect the nav links, forms, and other content for toggling -->
                    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                        <ul class="nav navbar-nav navbar-right">
                            <li><a href="components.html">Components</a></li>
                            <li><a href="http://www.creative-tim.com/product/get-shit-done-kit" class="btn btn-round btn-default">Download</a></li>
                        </ul>
                    </div><!-- /.navbar-collapse -->
                  </div><!-- /.container-fluid -->
            </nav>
        </div><!--  end container-->

        <div class='blurred-container'>
            <div class="motto">
                <div>Get</div>
                <div class="border no-right-border">Sh</div><div class="border">it</div>
                <div>Done</div>
            </div>
            <div class="img-src" style="background-image: url('{{ asset('public/plugins/gsdk/assets/img/cover_4.jpg')}} ')"></div>
            <div class="img-src blur" style="background-image: url('{{ asset('public/plugins/gsdk/assets/img/cover_4_blur.jpg')}} ')"></div>
        </div>
    
    </div> 
</div>

<!-- content -->
<div class="row">
  <div id="container">
    <!-- ################################################################################################ -->
    @yield('content')
    <!-- ################################################################################################ -->
    <div class="clear"></div>
  </div>
</div>
<!-- Footer -->
<
<div class="footer">
    <div class="overlayer">
        <div class="container">
            <div class="row support">
                <div class="col-sm-3">

                </div>
                <div class="col-sm-3">

                </div>
                <div class="col-sm-4">

                </div>
                <div class="col-sm-2">

                </div>
            </div>
            <div class="row">
                <div class="credits">
                    &copy; 2016 Toucan Design, made with <i class="fa fa-heart heart" alt="love"></i> for a better web
                </div>
            </div>
        </div>
    </div>
</div>
</body>
</html>