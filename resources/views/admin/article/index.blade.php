@extends('layouts.admin.main') 
@section('sidebar')
    @include('layouts.admin.sidebar',['_global_sidebar_array'=>$_global_sidebar_array]) 
@endsection 

@section('extra-includes')
    @parent
    <!-- include summernote css/js-->
    <link   href="{{ url('public/plugins/summer-note/dist/summernote.css') }}" rel="stylesheet">
    <script src="{{ url('public/plugins/summer-note/dist/summernote.min.js') }}"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        $('#summernote').summernote({
            height   : 300,                 // set editor height
            minHeight: 300,             // set minimum height of editor
            maxHeight: 300,             // set maximum height of editor
            toolbar: [
              // [groupName, [list of button]]
              ['style', ['bold', 'italic', 'underline', 'clear']],
              ['font', ['strikethrough', 'superscript', 'subscript']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['picture', ['picture']],
            ]
        });
        
        
    });
    //exp::
    var postForm = function() {
	var content = $('textarea[name="content"]').html($('#summernote').code());
    }
    </script>
@endsection 

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('article.add_new_article') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

<?php 
$article_title=''; 
$form_action='/admin/article/add-new'; 
?>

    <form id="add-article-form" role="form" method="post" action="{{ url(App::getLocale().$form_action ) }}" enctype="multipart/form-data" accept-charset="UTF-8">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        
        <!-- edit it dude -->
        <div class="row">
            <?php  Helper::showErrors( $errors ); ?>
        </div>
        <div class="row">
            @if( isset( $SuccessArray ))
                <?php  Helper::showSuccess( $SuccessArray ); ?>
            @endif
        </div>
        <!-- edit it dude -->
        
        
        <div class="row">
            <div class="form-group">
                <div class="col-sm-3">
                    <input name="article_title" placeholder="{{ trans('article.title') }}" type="text" class="form-control" value="{{ !empty(old('article_title'))?old('article_title'):(!empty($article_title)?$article_title:'')  }}">
                </div>
            </div>  
        </div>
        <br>
        <div class="row">
            <div class="form-group">
                <div class="col-md-12">
                    <textarea  class="input-block-level"  form="add-article-form" id="summernote" name="article_body" placeholder="test" ></textarea>
                </div>
            </div>
        </div>
        <div class="row" >
            <div class="col-sm-2">
               <button type="submit" value="submit" class="btn btn-success btn-block">{{ trans('food.save') }}</button>
            </div> 
            <div class="col-sm-1">
            </div>
            <div class="col-sm-2 col-sm-offset-1">
               <button type="reset" value="reset" class="btn btn-danger btn-block">{{ trans('food.reset') }}</button>
            </div> 
        </div>
        <br><br><br>
    </form>    
</div>
@endsection