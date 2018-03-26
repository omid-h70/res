<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $SITE_TITLE  }} </title>

    <!-- Locale CSS Style-->
    <?php Helper::loadStylesheet( App::getLocale() ); ?>
    
    <!-- jQuery -->
    <script src="{{ asset( '/public/js/jquery/jquery-2.2.4.min.js') }}"></script>
    
    
    <!-- Includes -->
    @include('layouts.styles.bootstrap' )
    @include('layouts.styles.font-awesome')


    <!-- Custom CSS -->
    @yield('extra-includes')
    @yield('locale-stylesheets')
    @yield('linked-stylesheets')
    
    <link href="{{ asset( '/public/admin_panel/dist/css/sb-admin-2.css') }}" rel="stylesheet">

    <link href="{{ asset( '/public/css/style.css') }}" rel="stylesheet">
    @include('layouts.styles.theme')
    
    <!-- Custom Theme JavaScript -->
    @yield('extra-scripts')
    @yield('extra-stylesheets')
    
    <!-- Local Fonts for overwriting default fonts-->
    <?php Helper::loadLocalFonts( App::getLocale() ); ?>
    
    
            
   
</head>
<body class="index-page" style="background-color:#434A54;">
    <nav class="navbar navbar-fixed-top navbar-color-on-scroll navbar-transparent" role="navigation">
        <div class="container">
            <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">{{ trans('public.toggle_navigation') }}</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
            
                <div class="dropdown">  
                    <a class="btn  btn-success drop-down-toggle" href="#" data-toggle="dropdown" >
                       <i class="fa fa-smile-o fa-fw" alt="basket"></i> 
                       1 &nbsp;
                       <b class="caret"></b>
                    </a>
                    <ul class="dropdown-menu dropdown-menu-right" id="plate">
                        <li class="dropdown-header">{{ trans('order.your_order') }}</li>
                        <li><a href="#">Action</a></li>
                        <li><a href="#">Another action x 1</a></li>
                        <li><a href="#">Something else here x 2</a></li>
                        <li class="divider"></li>
                        <li>
                            <a href="#" data-toggle="modal" data-target="#send-order">{{ trans('order.pay') }}
                            </a>
                        </li>
                    </ul>  
                </div>    
            </div>
          <div class="collapse navbar-collapse">
            <ul class="nav navbar-nav {{ (App::getLocale()=='fa')?'navbar-left':'navbar-right'}}">
                <li><a class="nav-link" href="getting-started.html">{{ trans('public.getting_started') }}</a></li>
                <li>
                  <a class="nav-link current" href="{{ url(App::getLocale().'/about') }}">
                     {{ trans('public.welcome') }} 
                  </a>
                </li>              
                
                @if(!auth()->check())
                    <li>
                        <a class="nav-link" href="{{ url(App::getLocale().'/auth/login#login-form') }}">
                            {{ trans('auth.login') }}
                        </a>
                    </li> 
                    <li>
                        <a class="nav-link" href="{{ url(App::getLocale().'/auth/register') }}">
                            {{ trans('auth.register') }}
                        </a>
                    </li>    
                @else
                    <li>
                        <a class="nav-link" href="{{ url(App::getLocale().'/auth/logout') }}">
                            {{ trans('auth.log_out') }}
                        </a>
                    </li>    
                @endif
                
            </ul>
          </div>
        </div>
    </nav>
    <div class="wrapper">
        <div class="header header-filter" style="background-image:url('{{ asset( '/public/images/header2.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="brand">
                            <h1>{{ $SITE_TITLE  }}</h1>
                            <h3>Slogan...</h3>
                        </div>    
                    </div>     
                </div>
            </div>
        </div>    
          <!--nav
          <nav class="navbar navbar-success navbar-custom" role="navigation">
            <div class="container">
              <div class="navbar-header">
                <button type="button" class="navbar-toggle" data-toggle="collapse" data-target=".navbar-collapse">
                  <span class="sr-only">{{ trans('public.toggle_navigation') }}</span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                  <span class="icon-bar"></span>
                </button>
                <a class="navbar-brand" href="#">
                    <img src="{{ asset( '/public/plugins/bootflat/img/footer-logo.png') }}"  height="40" />
                    {{ $SITE_TITLE  }}
                </a>
              </div>
              <div class="collapse navbar-collapse">
                <ul class="nav navbar-nav {{ (App::getLocale()=='fa')?'navbar-left':'navbar-right'}}">
                    <li><a class="nav-link" href="getting-started.html">{{ trans('public.getting_started') }}</a></li>
                    <li>
                      <a class="nav-link current" href="{{ url(App::getLocale().'/about') }}">
                         {{ trans('public.welcome') }} 
                      </a>
                    </li>              

                    @if(!auth()->check())
                        <li>
                            <a class="nav-link" href="{{ url(App::getLocale().'/auth/login') }}">
                                {{ trans('auth.login') }}
                            </a>
                        </li> 
                        <li>
                            <a class="nav-link" href="{{ url(App::getLocale().'/auth/register') }}">
                                {{ trans('auth.register') }}
                            </a>
                        </li>    
                    @else
                        <li>
                            <a class="nav-link" href="{{ url(App::getLocale().'/auth/logout') }}">
                                {{ trans('auth.log_out') }}
                            </a>
                        </li>    
                    @endif

                </ul>
              </div>
            </div>
          </nav>
          -->
          <!--header-->

    </div>  


<!-- content -->
<div class="wrapper row">
    <!-- ################################################################################################ -->
    @yield('content')
    <!-- ################################################################################################ -->
</div>
<!-- Footer -->

        <footer class="footer">
          <div class="container">
            <div class="clearfix">
              <div class="footer-logo">
                  <a href="#">
                      <img src="{{ asset( '/public/plugins/bootflat/img/footer-logo.png') }}" />
                      {{ $SITE_TITLE  }}
                  </a>
              </div>
              <dl class="footer-nav">
                <dt class="nav-title">{{ trans('public.portfolio') }}</dt>
                <dd class="nav-item"><a href="#">{{ trans('public.web_design') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.branding_and_identity') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.mobile_design') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.user_interface') }}</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">{{ trans('public.about') }}</dt>
                <dd class="nav-item"><a href="#">{{ trans('public.company') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.history') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.vision') }}</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">{{ trans('public.gallery') }}</dt>
                <dd class="nav-item"><a href="#">Flickr</a></dd>
                <dd class="nav-item"><a href="#">Picasa</a></dd>
                <dd class="nav-item"><a href="#">iStockPhoto</a></dd>
                <dd class="nav-item"><a href="#">PhotoDune</a></dd>
              </dl>
              <dl class="footer-nav">
                <dt class="nav-title">{{ trans('public.portfolio') }}</dt>
                <dd class="nav-item"><a href="#">{{ trans('public.basic_info') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.map') }}</a></dd>
                <dd class="nav-item"><a href="#">{{ trans('public.contact_form') }}</a></dd>
              </dl>
            </div>
            <div class="footer-copyright text-center">
                {{ trans('public.all_rights_reserved') }}
                <br>
                {{ trans('public.made_with') }} <i class="fa fa-heart heart" style="color:#FC6E51;" alt="love"></i> {{ trans('public.for_a_better_web') }} 
            </div>
          </footer>

<!-- Scripts -->
</body>
</html>