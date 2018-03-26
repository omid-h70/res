<!DOCTYPE html>
<html>
<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('public.setup') }} </title>

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

    <div class="wrapper">
        <div class="header header-filter" style="background-image:url('{{ asset( '/public/images/header2.jpg')}}')">
            <div class="container">
                <div class="row">
                    <div class="col-md-8 col-md-offset-2">
                        <div class="brand">
                            <h1></h1>
                            <h3></h3>
                        </div>    
                    </div>     
                </div>
            </div>
        </div>    
        
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