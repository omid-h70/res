@extends('layouts.main.main')
@section('linked-stylesheets')
    @parent
   
@endsection

@section('content')
    <div class="main main-raised">
        <div class="container documents">
            <div class="row">
                <div class="col-md-8 col-md-offset-2">
                    <h2 class="text-center">{{ $article_array['article_title'] }}</h2>
                    <div class="text-center description">
                        {!! $article_array['article_body'] !!}
                    </div>
                </div>    
            </div>
            <div class="row">
                <div class="col-md-4 col-md-offset-4 text-center">
                    <a class="btn  btn-info drop-down-toggle" href="#">
                        <i class="fa fa-clock-o fa-fw fa-2x"></i>
                        {{ $article_array['created_at'] }}
                    </a>
                
                    <a class="btn  btn-success drop-down-toggle" href="#">
                        <i class="fa fa-comment-o fa-fw fa-2x"></i>
                        
                    </a>
                </div>
            </div>    
        </div>    
    </div>    
@endsection