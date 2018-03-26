@extends('layouts.admin.main') 
@section('sidebar')
    @include('layouts.admin.sidebar',['_global_sidebar_array'=>$_global_sidebar_array]) 
@endsection 
@section('content')
    <div class="row">
        <div class="col-med-6">
            <div class="">
                <h1 class="page-header">{{ $article_array['article_title'] }}</h1>
            </div>
            <div class="">
                {!! $article_array['article_body'] !!}
            </div>
        </div>    
        <!-- /.col-lg-12 -->
    </div>

@endsection