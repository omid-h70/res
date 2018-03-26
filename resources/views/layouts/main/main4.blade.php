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
    <script src="{{ asset( '/public/js/jquery/jquery-2.2.4.min.js') }}"></script>
    
    
    <!-- Includes -->
    @include('layouts.styles.bootstrap' )
    @include('layouts.styles.font-awesome')
    @include('layouts.styles.bootflat')


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
        
    <div id="wrapper">
        <nav class="navbar navbar-default navbar-static-top navbar-guest" role="navigation" style="margin-bottom: 0">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <a class="navbar-brand" href="index.html"></a>
                </div>
                <!-- /.navbar-header -->

                <ul class="nav navbar-top-links navbar-right">
                    <li class="dropdown">
                        <button type="button" class="btn btn-success btn-lg" data-toggle="dropdown">
                            Your Plate
                            <i class="fa fa-cutlery fa-fw"></i> 
                            <i class="fa fa-caret-down"></i> 
                            0
                        </button>
                        <ul class="dropdown-menu dropdown-user">                    
                            <li>
                                <a href="{{ url(App::getLocale().'/auth/logout') }}">
                                    <i class="fa fa-sign-out fa-fw"></i> Logout
                                </a>
                            </li>
                        </ul>
                        
                        
                         <!-- /.dropdown-messages -->
                    </li>

                    <!-- /.dropdown -->
                </ul>
            <!-- /.navbar-top-links -->
            @yield('sidebar')
        
        </nav>
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
<div class="wrapper row">
    <div class="row">
      <div class="col-md-12">
        <div class="footer">
          <div class="container">
            <div class="clearfix">
              <div class="footer-logo"><a href="#"><img src="img/footer-logo.png" />Bootflat</a></div>
              <dl class="footer-nav">
                <dt class="nav-title">PORTFOLIO</dt>
                <dd class="nav-item"><a href="#">Web Design</a></dd>
                <dd class="nav-item"><a href="#">Branding &amp; Identity</a></dd>
                <dd class="nav-item"><a href="#">Mobile Design</a></dd>
                <dd class="nav-item"><a href="#">Print</a></dd>
                <dd class="nav-item"><a href="#">User Interface</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">ABOUT</dt>
                <dd class="nav-item"><a href="#">The Company</a></dd>
                <dd class="nav-item"><a href="#">History</a></dd>
                <dd class="nav-item"><a href="#">Vision</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">GALLERY</dt>
                <dd class="nav-item"><a href="#">Flickr</a></dd>
                <dd class="nav-item"><a href="#">Picasa</a></dd>
                <dd class="nav-item"><a href="#">iStockPhoto</a></dd>
                <dd class="nav-item"><a href="#">PhotoDune</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">CONTACT</dt>
                <dd class="nav-item"><a href="#">Basic Info</a></dd>
                <dd class="nav-item"><a href="#">Map</a></dd>
                <dd class="nav-item"><a href="#">Conctact Form</a></dd>
              </dl>
            </div>
            <div class="footer-copyright text-center">Copyright &copy; 2014 Flathemes.All rights reserved.</div>
          </div>
        </div>
      </div>
    </div>
<!-- Scripts -->
</body>
</html>