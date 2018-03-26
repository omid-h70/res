@section('extra-scripts')
    @parent
    <script type="text/javascript">
        $( document ).ready(function() {

            $("#save-role-btn").click( function( event ){
                event.preventDefault();
                var permission_array = [];
                $('input[ name="permission_array[]" ]').each( function(i){
                    if( $(this).is(':checked') ){
                        permission_array.push( $(this).val() );
                        //console.log(  $(this).val()  );
                    }	
                });

                // console.log( 'X-CSRF-TOKEN:' + $('meta[name="csrf-token"]').attr('content') );
                /*****************************************************/

                $.ajax({
                    beforeSend:function(){
                        //prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                      'role_title'      : $('input[id="add-role"]').val(),
                      'permission_array' : permission_array
                    },
                    dataType: 'json',

                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	

                    success: function(data) {
                        if( typeof data['role_title'] !== 'undefined' ){
                            //console.log( '1' );
                            $("div#role-status-error").removeClass("hidden");
                            $("div#role-status-error p#error")
                                .append(data['role_title'] +'<br>' );
                            $("div#role-status-error span.close").click( function( event ){   
                                $("div#role-status-error").addClass("hidden");
                            });		

                        }else if( typeof data['no-error'] !== 'undefined' ){
                            //console.log( 'no Error' );
                            $("div#role-status-success ").removeClass("hidden");
                            $("div#role-status-success p#success")
                                .append(data['no-error']+'<br>' );
                            $("div#role-status-success span.close").click( function( event ){   
                                $("div#role-status-success").addClass("hidden");
                            });	  

                        }	  

                        //console.log(  data );

                   },
                   type: 'POST',
                   url: "{{ url(App::getLocale().'/admin/acl/add-new-role') }}",
                });
            });/***** ENDOF Click Event ****/
            var role_id = '';

            $(".edit-role-btn").click( function( event ){

                event.preventDefault();
                //console.log( "opening Edit modal " );
                role_id = $(this).attr('data-role-id').trim() ;

                $.ajax({
                    beforeSend:function(){
                        //prepareToSend(); Notice::Loading bar not needed here 
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                        'action'       :'edit' ,
                        'role_id'      : role_id

                    },
                    dataType: 'json',

                    error: function() {
                        $('#info').html('<p>An error has occurred</p>');
                    },	

                    success: function(data) {
                        //console.log( data );
                        if( data.perm_array != 'undefined'){

                            var title = $("input[name='role_title'][data-action-type='edit']");
                            if( data.role_array.role_title !=''){
                                title.val( data.role_array.role_title );
                            }else{
                                title.val( data.role_array.role_slug);
                            }    

                            for( var key in data.perm_array ){

                                var value = data.perm_array[key];
                                var slug = value.permission_slug ;
                                //console.log( value );

                                $("input[name='permission_array[]'][data-action-type='edit']").each( function(i){
                                    if( $(this).val() === slug ){
                                        $(this).prop('checked', true).attr('checked','checkd');
                                    } 
                                    //console.log( slug +"::"+$(this).val() );
                                });
                            }
                        }

                    },
                    type: 'POST',
                    url: "{{ url(App::getLocale().'/admin/acl/edit-role') }}",
                });               
            });/********ENDOF Click Event***************/

            $("#save-edit-role-btn").click( function( event ){
            
                event.preventDefault();
                var permission_array = [];

                $('input[ name="permission_array[]"][data-action-type="edit"]').each( function(i){
                    if( $(this).is(':checked') ){
                        permission_array.push( $(this).val() );
                        //console.log(  $(this).val()  );
                    }	
                });

                $.ajax({
                    beforeSend:function(){
                        //prepareToSend(); Notice::Loading bar not needed here 
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                       'action'           :'save' ,
                       'role_id'          : role_id,
                       'role_title'       : $('input[id="edit-role"]').val(),
                       'permission_array' : permission_array
                    },
                    dataType: 'json',

                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	
                    success: function(data) {
                        if( typeof data['role_title'] !== 'undefined' ){
                            //console.log( '1' );
                            $("div#role-status-error").removeClass("hidden");
                            $("div#role-status-error p#error")
                                .append(data['role_title'] +'<br>' );
                            $("div#role-status-error span.close").click( function( event ){   
                                $("div#role-status-error").addClass("hidden");
                            });		

                        }else if( typeof data['no-error'] !== 'undefined' ){
                            //console.log( 'no Error' );
                            $("div#role-status-success ").removeClass("hidden");
                            $("div#role-status-success p#success")
                               .append(data['no-error']+'<br>' );
                            $("div#role-status-success span.close").click( function( event ){   
                                $("div#role-status-success").addClass("hidden");
                            });	  

                        }	  
                        //console.log(  data );
                   },
                   type: 'POST',
                   url: "{{ url(App::getLocale().'/admin/acl/edit-role') }}",
                });
            });/***** ENDOF Click Event ****/
            
            $("#close-edit-role-btn").click( function( event ){

                if( $("input[type='checkbox']").is(":checked") ){
                    $("input[type='checkbox']").prop('checked',false ).removeAttr('checked');
                }
            });

            $(".save-role-status-btn").click( function( event ){

                event.preventDefault();
                console.log('saving the status...');
                role_id = $(this).attr('data-role-id').trim() ;
                var role_status = $("select.role-status[data-role-id="+role_id+"]").find(":selected").val();

                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },   
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                       'action'       :'edit-status' ,
                       'role_id'      : role_id,
                       'role_status'  : role_status,

                    },
                    dataType: 'json',
                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	
                    success: function(data) {
                        //$("#loading-spinner").addClass('hidden');
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        
                        if( typeof data['role_title'] !== 'undefined' ){
                            
                            var error = $("div#absolute-message-box > p#message");
                            error.removeClass('hidden');
                            error.addClass("text-danger bg-danger alert")
                                .append(data['role_title'] +'<br>' );

                        }else if( typeof data['no-error'] !== 'undefined' ){
                            
                            var success = $("div#absolute-message-box > p#message");
                            success.removeClass('hidden');
                            success.css('border','1px solid green')
                                .addClass("text-success bg-success alert")
                                .append(data['no-error']+'<br>' );

                        }
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true);
                    },
                    type: 'POST',
                    url: "{{ url(App::getLocale().'/admin/acl/edit-role') }}",
                });               
            });/********ENDOF Click Event***************/

            $(".del-role-btn").click( function( event ){

                event.preventDefault();
                //console.log('Deleting the Role...');
                role_id = $(this).attr('data-role-id').trim() ;
                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                       'action'       :'delete-role' ,
                       'role_id'      : role_id,
                    },
                    dataType: 'json',
                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	

                    success: function(response) {
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        var success = $("div#absolute-message-box > p#message");
                        success.removeClass('hidden');
                        success.css('border','1px solid green')
                            .addClass("text-success bg-success alert")
                            .append(response['no-error']+'<br>' );         
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true); 
                    },
                    type: 'POST',
                    url: "{{ url(App::getLocale().'/admin/acl/edit-role') }}",
                });               
            });/********ENDOF Click Event***************/
            
            $(".recover-role-btn").click( function( event ){

                event.preventDefault();
                role_id = $(this).attr('data-role-id').trim() ;
                $.ajax({
                    beforeSend:function(){
                        prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                    data: {
                       'action'       :'edit-status' ,
                       'role_id'      : role_id,
                       'role_status'  :'deactive'
                    },
                    dataType: 'json',
                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	
                    success: function(response) {
                        
                        $("div#absolute-message-box > p#loading-spinner").addClass('hidden');
                        var success = $("div#absolute-message-box > p#message");
                        success.removeClass('hidden');
                        success.css('border','1px solid green')
                            .addClass("text-success bg-success alert")
                            .append(response['no-error']+'<br>' );         
                        $("div#absolute-message-box").fadeOut(1000);
                        location.reload(true); 
                        
                    },
                    type: 'POST',
                    url: "{{ url(App::getLocale().'/admin/acl/edit-role') }}",
                });               
            });/********ENDOF Click Event***************/
        });
    </script>
@endsection

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('acl.panel')}}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">{{ trans('acl.panel')}}</div>
            <!-- /.panel-heading -->
            <ul class="nav nav-tabs" role="tablist">
                <li role="presentation" class="active">
                    <a href="#home" aria-controls="home" role="tab" data-toggle="tab"> {{ trans('acl.roles')}}</a>
                </li>
                @if( Helper::userHasPermission('admin_permission_index') )
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="tab"> {{ trans('acl.permissions')}} </a>
                    </li>
                @endif
                @if( Helper::userHasPermission('admin_acl_add_new_role') )
                    <li role="presentation">
                        <a href="#profile" aria-controls="profile" role="tab" data-toggle="modal" data-target="#add-role"> 
                            <i class="fa fa-plus fa-fw" class="close"></i>
                            {{ trans('acl.add_new_role')}}
                        </a>
                    </li>
                @endif
            </ul>
            
            <!-- Add New Role Modal -->
            @if( Helper::userHasPermission('admin_acl_add_new_role') )
            
                @include('admin.acl.modals.edit-role',[
                     '_action'            => 'add_new_role',
                     '_modal_title'       => trans('acl.add_new_role') ,
                     '_form_url_action'   => url(App::getLocale().'/admin/acl/add-new-role') ,
                     '_permission_array'  => $ViewParams['perm_array'] ,    
                ])
                
            @endif    
            <!-- End Of Modal-->
            <!-- Edit Role Modal -->
            @if( Helper::userHasPermission('admin_acl_edit_role') )
            
                @include('admin.acl.modals.edit-role',[
                     '_action'            => 'edit_role',
                     '_modal_title'       => trans('acl.edit_role')  ,
                     '_form_url_action'   => url(App::getLocale().'/admin/acl/edit-role') ,
                     '_permission_array'  => $ViewParams['perm_array'] ,
                     
                ])
                
            @endif    
            <!-- End Of Edit Modal-->
            <div class="tab-content">
                    <div role="tabpanel" class="tab-pane active" id="home">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover" id="dataTable-article">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('acl.id') }}</th>
                                            <th>{{ trans('acl.role_title') }}</th>
                                            <th>{{ trans('acl.role_slug') }}</th>
                                            <th>{{ trans('acl.role_status') }}</th>
                                            @if( Helper::userHasPermission('admin_acl_edit_role') ) 
                                                <th>{{ trans('acl.action')}}</th>
                                            @endif    
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach( $ViewParams['role_array'] as $role)
                                            <tr>
                                                <td data-role-id="{{ $role['role_id'] }}" data-type="id">   {{ $role['role_id'] }}   </td>
                                                <td data-role-id="{{ $role['role_id'] }}" data-type="title">{{ $role['role_title'] }}</td>
                                                <td data-role-id="{{ $role['role_id'] }}" data-type="slug"> {{ $role['role_slug'] }} </td>
                                                
                                                @if( Helper::userHasPermission('admin_acl_edit_role') )  
                                                
                                                <td data-role-id="{{ $role['role_id'] }}" data-type="status">
                                                    @if( $role['role_status']!=$DELETED_STATUS )    
                                                        <select autocomplete="off" id="" class="form-control role-status" data-role-id="{{ $role['role_id'] }}" >
                                                            <option {{ $role['role_status']==$NORMAL_STATUS?'selected':'' }} value="{{ $NORMAL_STATUS }}" style="color:green;" >{{ trans('acl.active') }}</option>            
                                                            <option {{ $role['role_status']==$DEACTIVE_STATUS?'selected':'' }} value="{{ $DEACTIVE_STATUS }}" style="color:orange;"  >{{ trans('acl.deactive') }}</option> 
                                                        </select> 
                                                    @elseif( $role['role_status']==$DELETED_STATUS ) 
                                                        <p class="text-danger"><s> {{ trans('acl.deleted') }}!</s></p>
                                                    @endif
                                                </td>
                                                
                                                  
                                                <td>
                                                    <div class="btn-group">
                                                        <a aria-controls="" class="btn btn-primary edit-role-btn" href="#" data-toggle="modal" data-target="#edit-role" data-role-id="{{ $role['role_id'] }}">
                                                            <i class="fa fa-pencil-square-o fa-fw " title="{{ trans('acl.edit') }}" aria-hidden="true" ></i>
                                                            <span class="sr-only">{{ trans('acl.edit') }}</span>
                                                        </a>
                                                        <a aria-controls="" class="btn btn-success save-role-status-btn" href="#" data-toggle="modal" data-target="#save-role-status" data-role-id="{{ $role['role_id'] }}">
                                                            <i class="fa fa-check fa-fw " title="{{ trans('acl.save') }}" aria-hidden="true" ></i>
                                                            <span class="sr-only">{{ trans('acl.save') }}</span>

                                                        </a>

                                                        @if( $role['role_status']!=$DELETED_STATUS)
                                                            <a aria-controls="" class="btn btn-default btn-danger del-role-btn" href="#" data-toggle="modal" data-target="#del-role" 
                                                                data-role-id="{{ $role['role_id'] }}">
                                                                <i class="fa fa-trash-o fa-fw" title="{{ trans('acl.delete') }}" aria-hidden="true" ></i>
                                                                <span class="sr-only">{{ trans('acl.delete') }}</span>
                                                            </a>
                                                        @else
                                                            <a aria-controls="" class="btn btn-default btn-warning recover-role-btn" href="#" data-toggle="modal" data-target="#recover-role" 
                                                                    data-role-id="{{ $role['role_id'] }}">
                                                                <i class="fa fa-reply fa-fw" title="{{ trans('acl.recover') }}" aria-hidden="true" ></i>
                                                                <span class="sr-only">{{ trans('acl.recover') }}</span>
                                                            </a>            
                                                        @endif

                                                    </div>    
                                                </td>
                                                @else
                                                    <td data-role-id="{{ $role['role_id'] }}" data-type="status">
                                                        <p class="text-danger"> {{ trans('acl.'.$role['role_status']) }}</p>
                                                    </td>
                                                @endif
                                            </tr>
                                            

                                        @endforeach
                                    </tbody>
                            </table>

                            </div>
                            <!-- dataTable_wrapper -->
                    </div>
                    <!-- /.tab-pane -->
                    @if( Helper::userHasPermission('admin_acl_permission_index') )                        
                    <div role="tabpanel" class="tab-pane" id="profile">
                        <div class="dataTable_wrapper">
                            <table class="table table-striped table-bordered table-hover"
                                    id="dataTable-article">
                                    <thead>
                                        <tr>
                                            <th>{{ trans('acl.id') }}</th>
                                            <th>{{ trans('acl.permission_title') }}</th>
                                            <th>{{ trans('acl.permission_slug') }}</th>
                                            <th>{{ trans('acl.permission_disc') }}</th>
                                            <th>{{ trans('acl.permission_action')}}</th>

                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach( $ViewParams['perm_array'] as $perm)
                                            <tr>
                                                <td>{{ $perm['permission_id'] }}</td>
                                                <td>{{ $perm['permission_title'] }}</td>
                                                <td>{{ $perm['permission_slug'] }}</td>
                                                <td>{{ $perm['permission_description'] }}</td>
                                                <td><a href="#"> </a></td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                            </table>
                    </div>
                    @endif        
                </div>
                <!-- /.tab-content -->
            </div>
            <!-- /.panel-default -->
    </div>
        <!-- /.col-lg-12 -->
</div>
<!-- /.row -->

