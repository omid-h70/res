@extends('layouts.main.main')
@section('linked-stylesheets')
    @parent
    
@endsection

@section('extra-stylesheets')
    @parent
    <style type="text/css">

    </style>
@endsection

@section('content')
<div class="main main-raised" style="background:#EEEEEE;">
    <div class="section section-tabs container" >
        <div class="container documents">
            <div class="row">
                <?php //dd($article_array); ?>
                @if( !empty($article_array) )  
                    @foreach( $article_array as $article)  
                        <div class="col-md-4">
                            <div class="jumbotron" style="background:#fff;">
                                <div class="jumbotron-photo">
                                  @if( !empty($article['img_array']) && count($article['img_array'])==1 )  
                                    <img class="img-rounded img-raised img-responsive img-custom" src="{{ $article['img_array'][0]  }}" />
                                  @elseif( !empty($article['img_array']) )
                                    <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
                                        <ol class="carousel-indicators">
                                            @foreach( $article['img_array'] as $key => $img )
                                                <li data-target="#carousel-example-generic" data-slide-to="{{ $key }}" class="{{ ($key==0)?'active':'' }}">

                                                </li>
                                            @endforeach
                                        </ol>
                                        <div class="carousel-inner">
                                            @foreach( $article['img_array'] as $key => $img )
                                                <div class="item {{ ($key==0)?'active':'' }} custom-container">
                                                    <img class="img-rounded img-raised img-responsive img-custom" src="{{ $img }}" >
                                                </div>
                                            @endforeach
                                        </div>

                                        <a class="left carousel-control" href="#carousel-example-generic" data-slide="prev">
                                          <i class="fa fa-angle-left fa-fw"></i>
                                        </a>
                                        <a class="right carousel-control" href="#carousel-example-generic" data-slide="next">
                                          <i class="fa fa-angle-right fa-fw"></i>
                                        </a>
                                    </div>
                                  @endif
                                </div>
                                <div class="jumbotron-contents">
                                    <h3>
                                        {{ $article['article_title'] }}
                                    </h3>
                                    <p>
                                        {{ $article['article_summary'] }}
                                    </p>
                                    <div class="row">
                                        <a href="{{ url(App::getLocale().'/article/show?id='.$article['article_id']) }}" class="col-md-6 btn btn-success">
                                            {{ trans('article.read_more')}}...
                                        </a>
                                    </div>        
                                </div>
                            </div>                
                        </div>

                    @endforeach 
                @endif  
            </div>
            @if(!empty($food_array))    
                <hr class="dashed">      
                <div class="example">
                    <div class="row">
                        <?php //dd($food_picture_array); ?>
                        @foreach( $food_array as $food )
                            <div class="col-sm-4 col-md-3">
                              <div class="thumbnail">
                                <img class="img-rounded" src="{{ Helper::createImageUrl( $food_picture_array[$food['food_id']][0] ) }}" >
                                <div class="caption text-center">
                                    <h3>{{ $food['food_title'] }}</h3>
                                    @if(!empty($food_tag_array))
                                        <p>
                                            @foreach( $food_tag_array[$food['food_id']] as $tag )
                                                <span class="label label-warning">{{ $tag['tag_title'] }}</span>
                                            @endforeach
                                        </p>
                                    @endif
                                    <p>
                                        <a href="#" class="btn btn-success btn-price"  title="{{trans('order.order')}}" data-toggle="modal" data-target="#add-new-order">
                                            {{ number_format($food['food_price']) }} {{ trans('public.toman') }}
                                            <i class="fa fa-plus-circle fa-fw fa-2x"></i>
                                        </a>
                                    </p>    
                                </div>
                              </div>
                            </div>
                        @endforeach 
                    </div>
                </div>
            @endif  
        </div> 
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="add-new-order" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{ trans('order.submit_order') }}</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('food.close') }} </button>
              <button id="save-category-btn" type="button" class="btn btn-primary">{{ trans('food.save') }} </button>
            </div>
        </div>
    </div>
</div>
<!-- End Of Modal -->
<!-- Modal -->
<div class="modal fade" id="send-order" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">{{ trans('order.send_order') }}</h4>
            </div>
            <div class="modal-footer">
              <button type="button" class="btn btn-default" data-dismiss="modal">{{ trans('food.close') }} </button>
              <button id="save-category-btn" type="button" class="btn btn-primary">{{ trans('food.save') }} </button>
            </div>
        </div>
    </div>
</div>
<!-- End Of Modal -->



@endsection