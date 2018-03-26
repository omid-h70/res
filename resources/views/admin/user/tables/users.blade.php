
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

        @foreach( $user_array as $user )
            @if($user['user_status'] == $_user_status )
                <tr>
                <td>{{ $user['user_id'] }}</td>
                <td data-user-id="{{ $user['user_id'] }}" data-type="email" >
                    {{ $user['user_email'] }}
                </td>
                <td>
                    {{ $user['user_role']['role_title'] }}
                    <!--
                    <select  class="form-control" data-user-id="{{ $user['user_id'] }}" data-type="role">
                        <option> {{ trans('user.not_selected') }} </option>
                        @foreach( $role_array as $role )
                            <option data-role-slug="{{$role['role_slug']}}" {{ $role['role_slug'] == $user['user_role']['role_slug']?'selected':'' }}>
                                {{ $role['role_title'] }}
                            </option>
                        @endforeach
                    </select>
                    -->
                </td>
                <td>
                    @if( $user['user_status'] != $BANNED_STATUS )
                        <select  class="form-control" data-user-id="{{ $user['user_id'] }}" data-type="status" >
                            <option value="{{ $NORMAL_STATUS }}" {{ $user['user_status'] == $NORMAL_STATUS ?'selected':'' }}>
                                {{ trans('user.active') }}
                            </option>
                            <option value="{{ $DEACTIVE_STATUS }}" {{ $user['user_status'] == $DEACTIVE_STATUS ?'selected':'' }}>
                                {{ trans('user.deactive') }}
                            </option>
                        </select>
                    @elseif( $user['user_status'] == $BANNED_STATUS )
                        <s>
                            <p class="text-danger" data-user-id="{{ $user['user_id'] }}" data-type="status" data-value="banned"> 
                                {{ trans('user.banned') }} !
                            </p>
                        </s>
                    @endif
                </td>
                <td data-user-id="{{ $user['user_id'] }}">
                    <div class="btn-group">
                        @if( $user['user_status']!=$BANNED_STATUS )
                            <a aria-controls="" class="btn btn-default btn-danger ban-user-btn" href="#" data-toggle="modal" data-target="#ban-user" data-user-id="{{ $user['user_id'] }}">
                                <i class="fa fa-ban  fa-lg fa-fw" title="{{ trans('user.ban') }}" aria-hidden="true" ></i>
                                <span class="sr-only">{{ trans('user.ban') }}</span>
                            </a>
                        @elseif( $user['user_status']==$BANNED_STATUS )
                            <a aria-controls="" class="btn btn-default btn-warning recover-user-btn" href="#" data-toggle="modal" data-target="#recover-user" data-user-id="{{ $user['user_id'] }}">
                                <i class="fa fa-user-plus fa-fw fa-lg" title="{{ trans('user.recover') }}" aria-hidden="true" ></i>
                                <span class="sr-only">{{ trans('user.recover') }}</span>
                            </a>      
                        @endif
                    </div>
                </td>
                <td>
                    <div class="btn-group">
                        <a class="btn btn-warning edit-user-btn" data-user-id="{{ $user['user_id'] }}" href="{{ url(App::getLocale().'/admin/setting/user?id='.$user['user_id'] ) }}">
                            <i class="fa fa-cog fa-fw fa-lg" title="{{ trans('user.advance_edit') }}" aria-hidden="true" ></i>
                            <span class="sr-only">{{ trans('user.advance_edit') }}</span>
                        </a>
                        <a class="btn btn-primary edit-user-btn" data-user-id="{{ $user['user_id'] }}" href="#" >
                            <i class="fa fa-pencil-square-o fa-fw fa-lg" title="{{ trans('user.edit') }}" aria-hidden="true" ></i>
                            <span class="sr-only">{{ trans('user.edit') }}</span>
                        </a>
                        <a aria-controls="" class="btn btn-success update-user-status-btn" href="#" data-toggle="modal" data-target="#save-user-status" 
                                data-user-id="{{ $user['user_id'] }}">
                            <i class="fa fa-check fa-fw fa-lg" title="{{ trans('user.save') }}" aria-hidden="true" ></i>
                            <span class="sr-only">{{ trans('user.update') }}</span>
                        </a>
                    </div>
                </td> 


                </tr>
            @endif
        @endforeach
    </tbody>
</table>