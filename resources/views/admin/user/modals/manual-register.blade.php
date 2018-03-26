<div class="modal fade" id="add-user" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <form class="form-horizontal" role="form" method="post" action="{{ url(App::getLocale().'/admin/user/add-new') }}">
                <input type="hidden" name="id" value="{{ old('id') }}">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="add-user-modal-header">
                        {{ trans('user.add_new_user') }}
                    </h4>
                </div>
                <div class="modal-body">
                    @include('layouts.main.modals.msg-box',[
                        'user_role'    => 'super_user',
                    ])
                    <div class="row">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('user.email_address') }}</label>
                            <div class="col-md-6">
                                <input type="email" class="form-control" name="email" value="{{ old('email') }}">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('user.password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('user.confirm_password') }}</label>
                            <div class="col-md-6">
                                <input type="password" class="form-control" name="password_confirmation">
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('user.user_role') }}</label>
                            <div class="col-md-6">
                                <select name="role_select" class="form-control">
                                @if( empty($role_array) )
                                    <option value='none'></option>
                                @else
                                    @foreach( $role_array as $key => $role )
                                        <option value="{{ $role['role_slug']}}" > {{ $role['role_title']}}</option>
                                    @endforeach
                                @endif    
                                </select>
                            </div>
                        </div>

                    </div>

                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">
                        {{ trans('user.close') }}
                    </button>
                    <button id="save-new-user-btn" type="button" class="btn btn-primary">
                            {{ trans('user.save') }}
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>
<!-- End Of Modal -->