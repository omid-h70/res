@extends('layouts.main.main')
@section('content')
<div class="container-fluid documents">
    <div class="row">
        <div class="col-md-8 col-md-offset-2">
            <div class="panel panel-default">
                <div class="panel-heading">{{ trans('auth.registration_form') }}</div>
                <div class="panel-body">
                        @if(count($errors) > 0)
                            <div class="panel panel-danger">
                            <div class="panel-heading"> {{ trans('error.error')}}</div>
                            <div class="panel-body">
                                <ul>
                                    @foreach($errors->all() as $error)
                                        <li><h6>{{ $error }}</h6></li>
                                    @endforeach
                                </ul>
                            </div>   
                            </div>
                        @endif

                        <form class="form-horizontal" role="form" method="POST" action="{{ url(App::getLocale().'/register') }}">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('auth.email_address') }}</label>
                                <div class="input-group col-md-4">
                                    <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                    <input type="email" class="form-control" name="user_email" value="{{ old('email') }}">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                                <div class="input-group col-md-4">
                                    <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                    <input type="password" class="form-control" name="user_password">
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="col-md-4 control-label">{{ trans('auth.confirm_password') }}</label>
                                <div class="input-group col-md-4">
                                    <span class="input-group-addon"><i class="fa fa-lock fa-fw"></i></span>
                                    <input type="password" class="form-control" name="user_password_confirmation">
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-4 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                            {{ trans('auth.register') }}
                                    </button>
                                    <a class="btn btn-link" href="{{ url(App::getLocale().'/auth/login') }}">
                                        {{ trans('auth.already_a_member') }} ?
                                    </a>
                                </div>
                            </div>
                        </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection