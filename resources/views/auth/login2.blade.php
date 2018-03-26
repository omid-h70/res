@extends('layouts.main.main')

@section('extra-scripts')
    @parent
    <link rel="stylesheet" href="{{ url('public/plugins/form3/css/form-elements.css') }} ">
    <link rel="stylesheet" href="{{ url('public/plugins/form3/css/style.css')}} ">
    
@endsection

@section('content')
<div class="top-content">
    <div class="inner-bg">
        <div class="container">
            <div class="row">
                <div class="col-sm-8 col-sm-offset-2 text">
                    <h1><strong>Bootstrap</strong> Login Form</h1>
                    <div class="description">
                        <p>
                        </p>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 form-box">
                    <div class="form-top">
                        <div class="form-top-left">
                            @if (count($errors) > 0)
                                <div class="alert alert-danger">
                                    <strong>Whoops!</strong> There were some problems with your input.<br><br>
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                                <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @else
                                <h3>Login to our site</h3>
                                <p>Enter your username and password to log on:</p>
                            @endif
                        </div>
                        <div class="form-top-right">
                            <i class="fa fa-lock"></i>
                        </div>
                    </div>
                    <div class="form-bottom">
                        <form role="form" method="POST" action="{{ url(App::getLocale().'/login') }}" class="login-form">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}">
                            <div class="form-group">
                                <label class="sr-only" for="email">{{ trans('auth.email') }}</label>
                                <input type="text" name="email" placeholder="{{ trans('auth.email') }}..." class="form-username form-control" id="form-username" value="{{ old('email') }}">
                            </div>
                            <div class="form-group">
                                <label class="sr-only" for="password">{{ trans('auth.password') }}</label>
                                <input type="password" name="password" placeholder="{{ trans('auth.password') }}..." class="form-password form-control" id="form-password">
                            </div>
                            <button type="submit" class="btn">{{ trans('auth.login') }}</button>
                        </form>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-sm-6 col-sm-offset-3 social-login">
                    <h3>...or login with:</h3>
                    <div class="social-login-buttons">
                        <a class="btn btn-link-2" href="#">
                                <i class="fa fa-facebook"></i> Facebook
                        </a>
                        <a class="btn btn-link-2" href="#">
                                <i class="fa fa-twitter"></i> Twitter
                        </a>
                        <a class="btn btn-link-2" href="#">
                                <i class="fa fa-google-plus"></i> Google Plus
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>
@endsection