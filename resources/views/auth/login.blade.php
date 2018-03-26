@extends('layouts.main.main')
@section('linked-stylesheets')
    @parent
   
@endsection

@section('content')
<div class="row" ></div>
<div class="container-fluid documents" id="login-form">
    <div class="row">
        <div class="col-md-8 col-md-offset-2 ">
            <div class="panel panel-default main main-raised">
                <div class="panel-heading">
                    <h5>{{ trans('auth.login_form') }}</h5>
                </div>
                <div class="panel-body">
                    @if (count($errors) > 0)
                        <div class="panel panel-danger">
                            <div class="panel-heading"> {{ trans('error.error')}}</div>
                            <div class="panel-body">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li><h6>{{ trans('error.'.$error) }}</h6></li>
                                    @endforeach
                                </ul>
                            </div>
                                
                        </div>
                    @endif

                    <form action="{{ url(App::getLocale().'/login#login-form') }}" class="form-horizontal" role="form" method="POST" >
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.email_address') }}</label>
                            <div class="input-group col-md-4">
                                <span class="input-group-addon"><i class="fa fa-envelope-o fa-fw"></i></span>
                                <input type="email" class="form-control" name="user_email" value="{{ old('user_email') }}" style="">
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-md-4 control-label">{{ trans('auth.password') }}</label>
                            <div class="input-group col-md-4">
                                <span class="input-group-addon"><i class="fa fa-key fa-fw"></i></span>
                                <input type="password" class="form-control" name="user_password" style="">
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <div class="checkbox">
                                    <label>
                                        <input type="checkbox" name="remember"> {{ trans('auth.remember_me') }}
                                    </label>
                                </div>
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-md-4 col-md-offset-4">
                                <button type="submit" class="btn btn-primary">{{ trans('auth.login') }}</button>
                                <a class="btn btn-link" href="{{ url(App::getLocale().'/password/email') }}">{{ trans('auth.forgot_your_password') }} ?</a>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection