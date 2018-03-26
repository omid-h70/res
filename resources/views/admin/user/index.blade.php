@extends('layouts.admin.main')
@section('sidebar')
    @include('layouts.admin.sidebar')
@endsection
@section('extra-scripts')
@parent
<script type="text/javascript">
    $(document).ready(function(){
         
	$('#save-new-user-btn').click(function () {
            $.ajax({
                beforeSend:function(){
                     prepareToSend();
                },
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'id'      : $('input[name="id"]').val(),
                    'name'    : $('input[name="name"]').val(),
                    'email'   : $('input[name="email"]').val(),
                    'password': $('input[name="password"]').val(),
                    'password_confirmation': $('input[name="password_confirmation"]').val(),
                    'role_select': $('select[name="role_select"] option:selected').val(),
                },
                dataType: 'json',
                type: "POST",
                url: "{{ url(App::getLocale().'/admin/user/add-new') }}",
                success: function(data){
                    
                    $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                    
                    if( typeof data['no-error']!=='undefined' ){
                        //console.log( 'no Error' );
                        var success = $("div#absolute-message-box > p#message");
                        success.removeClass('hidden');
                        success.css('border','1px solid green')
                            .addClass("text-success bg-success alert")
                            .append(data['no-error']+'<br>' );         
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true); 	  

                    }else{
                        var alert_box = $("div#modal-alert-box"); 
                        alert_box.removeClass("hidden");
                        if( typeof data['user_password']!=='undefined'){
                           alert_box.find("p#error")
                              .append(data['user_password'] +'<br>' );
                        } 
                        if( typeof data['user_email']!=='undefined'){
                           alert_box.find("p#error")
                              .append(data['user_email'] +'<br>' );
                        } 
                        alert_box.find("span.close").click( function( event ){   
                              alert_box.addClass("hidden");
                        });  
                    }
                }
            });
	}); /****** End Of Click Event**********/

	$('.update-user-status-btn').click(function () {
            var user_id = $(this).attr('data-user-id');
            
            var status_select = $('select[data-user-id='+user_id+'][data-type="status"]');
            if( status_select.length > 0 ){
                // for Active & Deactive Status
                var status = status_select.children(':selected').val();
            }else{
                // for banned Status 
                var status_select = $('p[data-user-id='+user_id+'][data-type="status"]');
                if( status_select.length > 0 ){
                    var status = status_select.attr('data-value');
                }    
            }
            
            var role_select = $('select[data-user-id='+user_id+'][data-type="role"]');
            var role = role_select.children(':selected').attr('data-role-slug');

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
                    'action'     :'update_status',
                    'user_id'    : user_id,
                    'user_status': status,
                    'user_role'  : role
                },
                dataType: 'json',

                type: "POST",
                url: "{{ url(App::getLocale().'/admin/user/edit') }}",
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
	
        $('.ban-user-btn').click(function(){
            var user_id = $(this).attr('data-user-id');

            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                }, 
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action'     :'update_status',
                    'user_id'    : user_id,
                    'user_status': 'banned'
                },
                dataType: 'json',

                type: "POST",
                url: "{{ url(App::getLocale().'/admin/user/edit') }}",
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
        
        $('.recover-user-btn').click(function(){
            var user_id = $(this).attr('data-user-id');

            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                }, 
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action'     :'update_status',
                    'user_id'    : user_id,
                    'user_status': 'deactive'
                },
                dataType: 'json',
                type: "POST",
                url: "{{ url(App::getLocale().'/admin/user/edit') }}",
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
           
        $('.edit-user-btn').click(function () {
            var user_id = $(this).attr('data-user-id');
            var edit_str = "{{ trans('user.quick_edit') }}";
            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                }, 
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'user_id' : user_id
                },
                type: "POST",
                url: "{{ url(App::getLocale().'/admin/user/edit') }}",
                success: function(response){
                    $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                    $("input[name='id']").val(response.id);
                    $("h4#add-user-modal-header").text(edit_str);
                    $("input[name='email']").val(response.email);                    
                    $('#add-user').modal();
                }
            });
        });/****** End Of Click Event**********/
       
    });
</script>
@endsection
@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('user.panel')}}</h1>
    </div>
	<!-- /.col-lg-12 -->
        @include('layouts.main.modals.loading-spinner',[
            'action'  => 'save',
        ])
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('user.users_list')}}</div>
            <!-- /.panel-heading -->
            <ul class="nav nav-tabs" role="tablist">
                @if(!empty($user_array))
                    <li role="presentation" class="active">
                        <a href="#active-users" aria-controls="active-users" role="tab" data-toggle="tab">
                            {{ trans('user.active_users')}}
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#new-users" aria-controls="new-users" role="tab" data-toggle="tab"> 
                            {{ trans('user.new_users')}}
                        </a>
                    </li>
                    <li role="presentation">
                        <a href="#banned-users" aria-controls="banned-users" role="tab" data-toggle="tab">
                            {{ trans('user.banned_users')}}
                        </a>
                    </li>
                @endif    
                <li role="presentation">
                    <a id="add-user-btn" href="#profile" aria-controls="profile" role="tab" data-toggle="modal" data-target="#add-user"> 
                        <i class="fa fa-plus fa-fw" class="close"></i>
                        {{ trans('user.add_new_user')}}
                    </a>
                </li>
            </ul>
            <!-- manual_reg Modal -->
                @include('admin.user.modals.manual-register',[
                     'action'       => 'save',
                ])
            <!-- End Of Modal-->
            @if(!empty($user_array))            
                <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="active-users">
                        <div class="table-responsive dataTable_wrapper">
                            @include('admin.user.tables.users',[
                               '_user_status'  => $NORMAL_STATUS,
                            ])	
                        </div>
                        <!-- dataTable_wrapper -->
                    </div>
                    <!-- /.tab-pane -->
                    <div role="tabpanel" class="tab-pane" id="new-users">
                        <div class="dataTable_wrapper">
                           @include('admin.user.tables.users',[
                                '_user_status'  => $DEACTIVE_STATUS,
                            ])

                        </div>
                    </div>

                    <div role="tabpanel" class="tab-pane" id="banned-users">
                        <div class="dataTable_wrapper">
                           @include('admin.user.tables.users',[
                                '_user_status'  => $BANNED_STATUS,
                            ])

                        </div>
                    </div>
                    <!-- /.tab-content -->
                </div>
            @else
                <!-- --> 
            @endif
        </div><!--Users /.panel-default -->
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
    
@endsection