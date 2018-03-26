
@section('extra-scripts')
    @parent
    <script type="text/javascript">
        $( document ).ready(function() {  
            
            $('.update-food-btn').click(function () {
                
                var food_id = $(this).data('food-id');
                var temp = 'select[name="food_status"][data-food-id="'+food_id+'"]';
                var status_select = '', status = '' ;
                
                if( $(temp).length >0 ){
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
                        'action'     :'update_food',
                        'food_id'    : food_id,
                        'food_status': status,
                    },
                    dataType: 'json',

                    type: "POST",
                    url: "{{ url(App::getLocale().'/admin/food/edit') }}",
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
            
            $('.del-food-btn').click(function () {
                var food_id = $(this).data('food-id');
                var status = "{{ $DELETED_STATUS }}" ;

                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'action'     :'update_food',
                        'food_id'    : food_id,
                        'food_status': status,
                    },
                    dataType: 'json',
                    type: "POST",
                    url: "{{ url(App::getLocale().'/admin/food/edit') }}",
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
            
            $('.recover-food-btn').click(function () {
                var food_id = $(this).data('food-id');
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
                        'action'     :'update_food',
                        'food_id'    : food_id,
                        'food_status': status,
                    },
                    dataType: 'json',
                    type: "POST",
                    url: "{{ url(App::getLocale().'/admin/food/edit') }}",
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
        <h1 class="page-header">{{ trans('food.available_foods_list') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div><!-- /.row -->
@include('layouts.main.modals.loading-spinner',[
    'action'  => 'save',
])

<div class="table-responsive dataTable_wrapper">
    @if( !empty($food_array) )
    <table class="table  table-striped table-bordered table-hover" id="dataTable-article">
        <thead>
            <tr>
                <th>{{ trans('food.id') }}</th>
                <th>{{ trans('food.title') }}</th>
                <th>{{ trans('food.tags') }}</th>
                <th>{{ trans('food.status') }}</th>
                <th>{{ trans('food.picture')}}</th>
                <th>{{ trans('food.created_at')}}</th>
                <th>{{ trans('food.action')}}</th>
            </tr>
        </thead>
        <tbody>
        
            @foreach( $food_array as $food )
                <tr>
                    <td>{{ $food['food_id'] }}</td>
                    <td>{{ $food['food_title'] }}</td>
                    <td>
                        @if(!empty( $food_tag_array[$food['food_id']] ))
                            @foreach( $food_tag_array[$food['food_id']]  as $key => $tag_array)
                                @foreach( $tag_array as $tag)
                                    <span class="btn btn-success btn-xs">{{ $tag['tag_title'] }}</span>
                                @endforeach
                            @endforeach
                        @endif
                    </td>
                    <td>
                        @if($food['food_status'] != $DELETED_STATUS )
                            <select autocomplete="off" class="form-control" data-food-id="{{ $food['food_id'] }}" data-type="status" name="food_status">
                                <option value="{{ $NORMAL_STATUS }}" {{ $food['food_status'] == $NORMAL_STATUS ?'selected':'' }}>
                                    {{ trans('food.normal')}}
                                </option>
                                <option value="{{ $DEACTIVE_STATUS }}" {{ $food['food_status'] == $DEACTIVE_STATUS ?'selected':'' }}>
                                    {{ trans('food.deactive')}}
                                </option>
                            </select>
                        @elseif( $food['food_status'] == $DELETED_STATUS )
                            <s><p class="text-danger"> {{ trans('food.deleted')}} ! </p></s>
                        @endif

                    </td>
                    <td>
                        @if( !empty( $food_picture_array[$food['food_id']]) )
                            <?php $picture_array = $food_picture_array[$food['food_id']] ; ?>
                            @foreach( $picture_array as $picture )
                                <img src="{{ url('public/images/thumbs/'.$picture['picture_id'].'_'.$food['food_id'].'_thumb.'.$picture['picture_ext'] ) }}" class="img-thumbnail" alt="{{ $picture['picture_title'] }}" > 
                            @endforeach
                        @endif
                    </td>
                    <td>{{ $food['created_at'] }}</td>

                    <td>
                        <div class="btn-group">

                            <a class="btn btn-primary edit-food-btn" data-food-id="{{ $food['food_id'] }}" href="{{ url(App::getLocale().'/admin/food/edit?id='.$food['food_id'] ) }}" >
                                <i class="fa fa-pencil-square-o fa-fw " title="{{ trans('food.edit') }}" aria-hidden="true" ></i>
                                <span class="sr-only">{{ trans('food.edit') }}</span>
                            </a>

                            <a  class="btn btn-success update-food-btn" href="#" data-food-id="{{ $food['food_id'] }}">
                                <i class="fa fa-check fa-fw " title="{{ trans('food.save') }}" aria-hidden="true" ></i>
                                <span class="sr-only">{{ trans('food.save') }}</span>
                            </a>
                            @if( $food['food_status'] != $DELETED_STATUS )
                                <a aria-controls="" class="btn btn-default btn-danger del-food-btn" href="#" data-toggle="modal" data-target="#del-food" 
                                        data-food-id="{{ $food['food_id'] }}">
                                    <i class="fa fa-trash-o fa-fw" title="{{ trans('food.delete') }}" aria-hidden="true" ></i>
                                    <span class="sr-only">{{ trans('food.delete') }}</span>
                                </a>
                            @else
                                <a aria-controls="" class="btn btn-default btn-warning recover-food-btn" href="#" data-toggle="modal" data-target="#del-food" 
                                        data-food-id="{{ $food['food_id'] }}">
                                    <i class="fa fa-reply fa-fw" title="{{ trans('food.recover') }}" aria-hidden="true" ></i>
                                    <span class="sr-only">{{ trans('food.recover') }}</span>
                                </a>      
                            @endif
                        </div>    

                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
    @else
        <div class="col-lg-6">
            <div class="panel panel-warning">
                <div class="panel-heading">{{ trans('admin.notice')}}</div>
                <div class="panel-body">
                    <h4>{{ trans('admin.nothing_found')}}</h4>
                </div>
            </div>  
        </div>    
    @endif

</div>
<!-- dataTable_wrapper -->


