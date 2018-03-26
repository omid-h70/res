@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection
@section('extra-scripts')
<script type="text/javascript">
    $( document ).ready(function() {
        
    	console.log( "ready!" );
        
        $('.update-sidebar-btn').click(function () {
            var sidebar_id = $(this).data('sidebar-id');
            var role_select = $('select[name="sidebar_role"][data-sidebar-id="'+sidebar_id+'"');
            
            var temp = 'select[name="sidebar_status"][data-sidebar-id="'+sidebar_id+'"';
            var status_select = '', status = '' ;
            if( $(temp).length >0 ){
                status_select = $(temp);
                status = status_select.children(':selected').attr("data-value");
            }else{
                status = "$DELETED_STATUS" ;
            };
            
            var role = '';
            var temp = role_select.children(':selected').attr("data-value");
            if( temp!='--none--' || temp.length>0 )    
                role = temp;
            
            
            //alert ( role );
            
            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                }, 
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action'        :'update_sidebar',
                    'sidebar_id'    : sidebar_id,
                    'sidebar_status': status,
                    'sidebar_role'  : role
                },
                dataType: 'json',
                type: "POST",
                url: "{{ url(App::getLocale().'/admin/sidebar/edit') }}",
                success: function(data){
                    $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                    $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
       
                    if( typeof data['sidebar_role'] !== 'undefined' ){
                        
                        var error = $("div#absolute-message-box > p#message");
                        error.removeClass('hidden');
                        error.addClass("text-danger bg-danger alert")
                            .append(data['sidebar_role'] +'<br>' );


                    }else if( typeof data['no-error'] !== 'undefined' ){
                            
                        var success = $("div#absolute-message-box > p#message");
                        success.removeClass('hidden');
                        success.css('border','1px solid green')
                            .addClass("text-success bg-success alert")
                            .append(data['no-error']+'<br>' );

                    }
                    $("div#absolute-message-box").fadeOut(1000);
                    //if( typeof success !== 'undefined' )
                        location.reload(true);
                }
            });
		
	});/****** End Of Click Event**********/

        $('.del-sidebar-btn').click(function () {

            var sidebar_id = $(this).data('sidebar-id');
            var status = "$DELETED_STATUS";

            //alert ( sidebar_id+role+status);

            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                }, 
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action'        :'update_sidebar',
                    'sidebar_id'    : sidebar_id,
                    'sidebar_status': status,
                },
                dataType: 'json',

                type: "POST",
                url: "{{ url(App::getLocale().'/admin/sidebar/edit') }}",
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
        });
        
        $('.recover-sidebar-btn').click(function () {

            var sidebar_id = $(this).data('sidebar-id');
            var status = "$DEACTIVE_STATUS";

            //alert ( sidebar_id+role+status);

            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                },
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action'        :'update_sidebar',
                    'sidebar_id'    : sidebar_id,
                    'sidebar_status': status,
                },
                dataType: 'json',

                type: "POST",
                url: "{{ url(App::getLocale().'/admin/sidebar/edit') }}",
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
    });/****** End Of Documant.Ready **********/
</script>
@endsection
@section('content')

    @include('layouts.main.modals.loading-spinner',[
        'action'  => 'save',

    ])

    <div class="row">
            <div class="col-lg-12">
                    <h1 class="page-header">{{ trans('sidebar.available_sidebars_list') }}</h1>
            </div>
            <!-- /.col-lg-12 -->
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('sidebar.sidebars_list') }}</div>
                <!-- /.panel-heading -->

                <ul class="nav nav-tabs" role="tablist">
                    <li role="presentation"  class="active">
                        <a  id="tab0" href="#sidebar-view" aria-controls="sidebar-view" role="tab" data-toggle="tab"> 
                            {{ trans('sidebar.all_sidebars') }}
                        </a>
                    </li>
                </ul>
                <!-- Modal -->

                <form role="form" method="post" action="{{ url(App::getLocale().'/admin/sidebar/all') }}">
                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                    <div class="tab-content">

                        <div role="tabpanel" class="tab-pane active" id="sidebar-view">
                            <div class="table-responsive dataTable_wrapper">
                                <table class="table  table-striped table-bordered table-hover" id="dataTable-article">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('sidebar.title') }}</th>
                                            <th>{{ trans('sidebar.role') }}</th>
                                            <th>{{ trans('sidebar.status') }}</th>
                                            <th>{{ trans('sidebar.action') }}</th>
                                        </tr>
                                    </thead>
                                    <tbody>

                                        @foreach( $sidebar_array as $sidebar )
                                            <tr>
                                                <td>
                                                    {{ $sidebar['sidebar_title']}}   
                                                </td>


                                                <td>
                                                    <select autocomplete="off" class="form-control" name="sidebar_role" data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                        <option value=''>--none--</option>
                                                        @if( !empty($sidebar['role_array']) )
                                                            @foreach( $sidebar['role_array'] as $role )
                                                                <option data-value="{{ $role['role_slug']}}" {{ !empty($role['selected'])?'selected':'' }}>
                                                                    {{ $role['role_title']}}
                                                                </option>
                                                            @endforeach
                                                        @else
                                                            @foreach( $role_array as $role )
                                                                <option data-value="{{ $role['role_slug']}}" >
                                                                    {{ $role['role_title']}}
                                                                </option>
                                                            @endforeach
                                                        @endif

                                                    </select>
                                                </td>

                                                <td>
                                                    @if($sidebar['sidebar_status']!=$DELETED_STATUS)
                                                        <select autocomplete="off" class="form-control" name="sidebar_status" data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                            <option data-value="{{ $DEACTIVE_STATUS }}" {{ ucfirst($sidebar['sidebar_status'])==$DEACTIVE_STATUS?'selected':'' }} > {{ trans('sidebar.active') }}</option>
                                                            <option data-value="{{ $ACTIVE_STATUS }}" {{ ucfirst($sidebar['sidebar_status'])==$NORMAL_STATUS?'selected':'' }} > {{ trans('sidebar.deactive') }}</option>
                                                        </select>  
                                                    @else
                                                        <p class="text-danger"><s> {{ trans('sidebar.deleted') }}!</s></p>
                                                    @endif
                                                </td>
                                                <td data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                    <div class="btn-group">
                                                        <a class="btn btn-default btn-primary ban-user-btn" href="{{ url(App::getLocale().'/admin/sidebar/edit?id='.$sidebar['sidebar_id']) }}" 
                                                            data-sidebar-id="{{ $sidebar['sidebar_id'] }}">

                                                            <i class="fa fa-pencil  fa-lg fa-fw" title="Edit" aria-hidden="true" ></i>
                                                            <span class="sr-only">{{ trans('sidebar.edit') }}</span>
                                                        </a>

                                                        <a aria-controls="" class="btn btn-default btn-success update-sidebar-btn" href="#" data-toggle="modal" data-target="#update-sidebar" 
                                                                data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                            <i class="fa fa-check fa-fw fa-lg" title="Update" aria-hidden="true" ></i>
                                                            <span class="sr-only">{{ trans('sidebar.save') }}</span>
                                                        </a>
                                                        
                                                        <!-- /********* Perm Stuff to Add *************/ -->
                                                        
                                                        @if( $sidebar['sidebar_status'] != $DELETED_STATUS )
                                                            <a aria-controls="" class="btn btn-default btn-danger del-sidebar-btn" href="#" data-toggle="modal" data-target="#del-sidebar" 
                                                                    data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                                <i class="fa fa-trash fa-fw fa-lg" title="Delete" aria-hidden="true" ></i>
                                                                <span class="sr-only">{{ trans('sidebar.delete') }}</span>
                                                            </a> 
                                                        @elseif( $sidebar['sidebar_status'] == $DELETED_STATUS ) 
                                                            <a aria-controls="" class="btn btn-default btn-warning recover-sidebar-btn" href="#" data-toggle="modal" data-target="#del-sidebar" 
                                                                    data-sidebar-id="{{ $sidebar['sidebar_id'] }}">
                                                                <i class="fa fa-reply fa-fw fa-lg" title="Recover" aria-hidden="true" ></i>
                                                                <span class="sr-only">{{ trans('sidebar.recover') }}</span>
                                                            </a> 
                                                        @endif
                                                        
                                                        
                                                    </div>
                                                </td>

                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>

                            </div><!-- /.table-responsive dataTable_wrapper -->



                        </div><!-- /.tab-pane -->

                    </div><!-- /.tab-content -->

                </form>

            </div> <!-- /.panel-default -->

        </div><!-- /.col-lg-12 -->
    </div><!-- /.row -->
@endsection