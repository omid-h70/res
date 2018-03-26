<!-- Modal -->
@if( $_action == 'add_new_role')
    <div class="modal fade" id="add-role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
@elseif( $_action == 'edit_role')   
    <div class="modal fade" id="edit-role" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
@endif    
 
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="myModalLabel">{{ $_modal_title }}</h4>
            </div>
            <div class="modal-body">
                <div id="role-status-error" class="hidden row">
                    <div class="col-md-10 col-centered alert alert-danger alert-dismissible fade in" role=alert>
                        <p id="error">
                            <span class="close"> 
                                <i class="fa fa-remove fa-fw close"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div id="role-status-success" class="hidden row">
                    <div class="bg-success col-md-10 col-centered alert  alert-dismissible fade in">
                        <p class="" id="success">
                            <span class="close"> 
                                <i class="fa fa-check fa-fw close"></i>
                            </span>
                        </p>
                    </div>
                </div>
                <div class="row">
                    <form role="form" method="post" action="{{ $_form_url_action  }}">
                        <div class="col-md-2">
                            <label for="role_title">{{ trans('acl.role_title') }}</label>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                @if( $_action == 'add_new_role')
                                    <input type="text" class="form-control" id="add-role" name="role_title" placeholder="{{ trans('acl.role_name') }}">
                                @elseif( $_action == 'edit_role')  
                                    <input class="form-control" data-action-type="edit" id="edit-role" name="role_title" placeholder="{{ trans('acl.role_name') }}" type="text">
                                @endif
                            </div>
                        </div>
                        <div class="col-md-6">
                            <ul class="list-group">
                                <li class="list-group-item">
                                    <h4>
                                        <i class="fa fa-key fa-fw"></i>
                                        {{ trans('acl.permissions') }}
                                    </h4>
                                </li> 
                                @foreach( $_permission_array as $perm )
                                    <li class="list-group-item">
                                        <label class="checkbox-inline">
                                            @if( $_action == 'add_new_role')
                                                <input type="checkbox" name="permission_array[]" value="{{ $perm['permission_slug'] }}">
                                                {{$perm['permission_slug'] }}
                                            @elseif( $_action == 'edit_role') 
                                                <input  data-action-type="edit" type="checkbox" name="permission_array[]" value="{{ $perm['permission_slug'] }}">
                                                {{ $perm['permission_slug'] }}
                                            @endif
                                        </label>
                                    </li> 
                                @endforeach
                            </ul>
                        </div>

                    </div>

                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">
                            {{ trans('acl.close') }}
                        </button>
                        
                        @if( $_action == 'add_new_role')
                            <button id="save-role-btn" type="button" class="btn btn-primary">
                                {{ trans('acl.save') }}
                            </button>    
                        @elseif( $_action == 'edit_role')   
                            <button id="save-edit-role-btn" type="button" class="btn btn-primary">
                                {{ trans('acl.save') }}
                            </button> 
                        @endif   
                        
                    </div>
                </form>
            </div>     <!-- End Of Modal Body -->   
        </div>
    </div>
</div>
<!-- End Of Add New Modal -->