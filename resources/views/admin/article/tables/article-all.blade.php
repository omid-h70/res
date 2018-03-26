@section('extra-scripts')
    @parent
    <script type="text/javascript">
        $( document ).ready(function() {  
            var url ="{{ url(App::getLocale().'/admin/article/edit') }}";
            $('.update-article-btn').click(function() {
                var article_id = $(this).data('article-id');
                var temp = 'select[name="article_status"][data-article-id="'+article_id+'"]';
                var status_select = '', status = '' ;
                
                if( $(temp).length>0 ){
                    status_select = $(temp);
                    status = status_select.children(':selected').val();
                }else{
                    status = "{{ $DELETED_STATUS }}" ;
                };
                
                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'request'        :'update_article',
                        'article_id'    : article_id,
                        'article_status': status,
                    },
                    dataType: 'json',
                    type: "POST",
                    url: url,
                    success: function(data){
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        if( typeof data['no-error'] !== 'undefined' ){
                            var success = $("div#absolute-message-box > p#message");
                            success.removeClass('hidden');
                            success.css('border','1px solid green')
                                .addClass("text-success bg-success alert")
                                .append(data['no-error']+'<br>' );

                        }
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true); 
                    }
                });

            });/****** End Of Click Event**********/
            
            $('.del-article-btn').click(function () {
                var article_id = $(this).data('article-id');
                var status = "{{ $DELETED_STATUS }}" ;

                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'request'       :'update_article',
                        'article_id'    : article_id,
                        'article_status': status,
                    },
                    dataType: 'json',
                    type: "POST",
                    url: url,
                    success: function(data){
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        if( typeof data['no-error'] !== 'undefined' ){
                            var success = $("div#absolute-message-box > p#message");
                            success.removeClass('hidden');
                            success.css('border','1px solid green')
                                .addClass("text-success bg-success alert")
                                .append(data['no-error']+'<br>' );

                        }
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true);
                        
                    }
                });

            });/****** End Of Click Event**********/
            
            $('.recover-article-btn').click(function () {
                var article_id = $(this).data('article-id');
                var status = "{{ $DEACTIVE_STATUS }}" ;

                $.ajax({
                    beforeSend:function(){
                        $("div#absolute-message-box").css('display','none');
                        $("div#absolute-message-box > p#loading-spinner")
                            .css('border','1px solid orange')
                            .removeClass('hidden');
                        $("div#absolute-message-box > p#message").addClass('hidden');
                        $("div#absolute-message-box > p#message").empty();
                        $("div#absolute-message-box").fadeIn(500);
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'request'       :'update_article',
                        'article_id'    : article_id,
                        'article_status': status,
                    },
                    dataType: 'json',
                    type: "POST",
                    url: url,
                    success: function(data){
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        if( typeof data['no-error'] !== 'undefined' ){
                            var success = $("div#absolute-message-box > p#message");
                            success.removeClass('hidden');
                            success.css('border','1px solid green')
                                .addClass("text-success bg-success alert")
                                .append(data['no-error']+'<br>' );

                        }
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true); 
                    }
                });

            });/****** End Of Click Event**********/
            
        }); /****** End Of Document.Ready**********/   
    </script>
@endsection  
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('article.available_articles') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
 </div>
 <!-- /.row -->
 <div class="row">
     <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{ trans('article.articles_list') }}
            </div>
            <!-- /.panel-heading -->
             <div class="dataTable_wrapper">
                <table class="table table-striped table-bordered table-hover" id="dataTable-article">
                    <thead>
                        <tr>
                            <th>{{ trans('article.id') }}</th>
                            <th>{{ trans('article.user') }}</th>
                            <th>{{ trans('article.title') }}</th>
                            <th>{{ trans('article.summary') }}</th>
                            <th>{{ trans('article.status') }}</th>
                            <th>{{ trans('article.created_at') }}</th>
                            <th>{{ trans('article.updated_at') }}</th>
                            <th>{{ trans('article.action') }}</th>
                        </tr>
                   </thead>
                   <tbody>
                        @foreach( $article_array as $article)

                            <tr>
                                <td>{{ $article['article_id'] }}</td>
                                <td>{{ $article['user_id'] }}</td>
                                <td>{{ $article['article_title'] }}</td>
                                <td class="col-md-1">
                                    <a href="{{ url(App::getLocale().'/admin/article/show?id='.$article['article_id']) }}">
                                        {{ $article['article_summary'] }} 
                                    </a>
                                </td>
                                <td>
                                    @if($article['article_status'] != $DELETED_STATUS )
                                        <select autocomplete="off" class="form-control" data-article-id="{{ $article['article_id'] }}" data-type="status" name="article_status">
                                            <option value="{{ $NORMAL_STATUS }}" {{ $article['article_status'] == $NORMAL_STATUS ?'selected':'' }}>
                                                {{ trans('article.normal')}}
                                            </option>
                                            <option value="{{ $DEACTIVE_STATUS }}" {{ $article['article_status'] == $DEACTIVE_STATUS ?'selected':'' }}>
                                                {{ trans('article.deactive')}}
                                            </option>
                                        </select>
                                    @elseif( $article['article_status'] == $DELETED_STATUS )
                                        <s><p class="text-danger"> {{ trans('article.deleted')}} ! </p></s>
                                    @endif
                                </td>
                                <td>{{ $article['created_at'] }}</td>
                                <td>{{ $article['updated_at'] }}</td>
                                <td>
                                    <div class="btn-group">
                                        @if( Helper::userHasPermission('admin_edit_article') )
                                            @if($article['article_status']!=$DELETED_STATUS)
                                                <a class="btn btn-primary edit-article-btn" data-article-id="{{ $article['article_id'] }}" href="{{ url(App::getLocale().'/admin/article/edit?id='.$article['article_id'] ) }}" >
                                                    <i class="fa fa-pencil-square-o fa-fw " title="{{ trans('article.edit') }}" aria-hidden="true" ></i>
                                                    <span class="sr-only">{{ trans('article.edit') }}</span>
                                                </a>
                                                <a  class="btn btn-success update-article-btn" href="#" data-article-id="{{ $article['article_id'] }}">
                                                    <i class="fa fa-check fa-fw " title="{{ trans('article.save') }}" aria-hidden="true" ></i>
                                                    <span class="sr-only">{{ trans('article.save') }}</span>
                                                </a>
                                                <a aria-controls="" class="btn btn-default btn-danger del-article-btn" href="#" data-toggle="modal" data-target="#del-article" 
                                                        data-article-id="{{ $article['article_id'] }}">
                                                    <i class="fa fa-trash-o fa-fw" title="{{ trans('article.delete') }}" aria-hidden="true" ></i>
                                                    <span class="sr-only">{{ trans('article.delete') }}</span>
                                                </a>
                                            @else
                                                <a aria-controls="" class="btn btn-default btn-warning recover-article-btn" href="#" data-toggle="modal" data-target="#del-article" 
                                                        data-article-id="{{ $article['article_id'] }}">
                                                    <i class="fa fa-reply fa-fw" title="{{ trans('article.recover') }}" aria-hidden="true" ></i>
                                                    <span class="sr-only">{{ trans('article.recover') }}</span>
                                                </a>      
                                            @endif
                                        
                                        @endif
                                        
                                    </div>
                                </td>
                            </tr>

                        @endforeach

                   </tbody>
                </table>

            </div>    
        </div><!-- /.panel-default -->
    </div><!-- /.col-lg-12 -->        
</div><!-- /.row -->        


