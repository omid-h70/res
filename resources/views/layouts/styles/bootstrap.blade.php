
@if( App::getLocale()== config('site.fa_lang'))
    <link href="{{ asset('public/plugins/bootstrap/css/rtl/bootstrap.min.css')}}" rel="stylesheet">
@elseif (App::getLocale() == config('site.en_lang'))
    <link href="{{ asset('public/plugins/bootstrap/css/ltr/bootstrap.min.css')}}" rel="stylesheet">   
@endif

    <!-- Bootstrap Core JavaScript -->
    <script src="{{ asset( '/public/plugins/bootstrap/js/bootstrap.min.js') }}"></script>

