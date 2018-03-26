<table class="table  table-striped table-bordered table-hover" id="dataTable-article">
    <thead>
        <tr>
            <th>{{ trans('user.id') }}</th>
            <th>{{ trans('user.email') }}</th>
            <th>{{ trans('user.user_role')}}</th>
            <th>{{ trans('user.status') }} </th>
            <th>{{ trans('user.action')}}</th>
            <th>{{ trans('user.action')}}</th>

        </tr>
    </thead>
    <tbody>

        @foreach( $user_array as $user)
            @if($user['user_status']=='banned')
                <tr>
                <td>{{ $user['user_id'] }}</td>
                <td data-user-id="{{ $user['user_id'] }}" data-type="email" >
                    {{ $user['user_email'] }}
                </td>
                <td data-user-id="{{ $user['user_id'] }}" data-type="role">
                    <select  class="form-control">
                        <option> {{ trans('user.not_selected') }} </option>
                        @foreach( $role_array as $role )
                            <option {{ $role['role_slug'] == $user['user_role']['role_slug']?'selected':'' }}>
                                {{ $role['role_title'] }}
                            </option>
                        @endforeach
                    </select>
                </td>
                <td>
                    @if( $user['user_status'] != 'banned')
                    <select class="form-control" data-user-id="{{ $user['user_id'] }}" data-type="status" >
                        <option value="active" {{ $user['user_status'] == 'active' ?'selected':'' }}>
                            {{ trans('user.active') }}
                        </option>
                        <option value="deactive" {{ $user['user_status'] == 'deactive' ?'selected':'' }}>
                            {{ trans('user.deactive') }}
                        </option>
                    </select>
                    @elseif( $user['user_status'] == 'banned')
                        <p class="text-danger"><s> {{ trans('user.banned') }} !</s></p>
                    @endif
                </td>
                <td data-user-id="{{ $user['user_id'] }}">
                    <div class="btn-group">
                        @if( $user['user_status'] !='banned')
                            <a aria-controls="" class="btn btn-default btn-danger ban-user-btn" href="#" data-toggle="modal" data-target="#ban-user" 
                                    data-user-id="{{ $user['user_id'] }}">

                                <i class="fa fa-ban  fa-lg fa-fw" title="Ban" aria-hidden="true" ></i>

                                <span class="sr-only">{{ trans('user.ban') }}</span>
                            </a>
                        @elseif( $user['user_status'] =='banned')
                            <a aria-controls="" class="btn btn-default btn-warning recover-user-btn" href="#" data-toggle="modal" data-target="#recover-user" 
                                    data-user-id="{{ $user['user_id'] }}">
                                <i class="fa fa-mail-reply fa-fw fa-lg" title="Recover" aria-hidden="true" ></i>
                                <span class="sr-only">{{ trans('user.recover') }}</span>
                            </a>      
                        @endif

                    </div>
                </td>
                <td>
                    <div class="btn-group">

                        <a class="btn btn-primary edit-user-btn" data-user-id="{{ $user['user_id'] }}" href="{{ url(App::getLocale().'/admin/user/edit?id='.$user['user_id'] ) }}" >
                            <i class="fa fa-pencil-square-o fa-fw fa-lg" title="Edit" aria-hidden="true" ></i>
                            <span class="sr-only">{{ trans('user.edit') }}</span>
                        </a>

                        <a aria-controls="" class="btn btn-success update-user-status-btn" href="#" data-toggle="modal" data-target="#save-user-status" 
                                data-user-id="{{ $user['user_id'] }}">
                            <i class="fa fa-check fa-fw fa-lg" title="Save" aria-hidden="true" ></i>
                            <span class="sr-only">{{ trans('user.update') }}</span>
                        </a>

                    </div>
                </td> 


                </tr>
            @endif
        @endforeach
    </tbody>
</table>