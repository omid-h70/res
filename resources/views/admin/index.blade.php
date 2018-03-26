@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection
@section('content')
    
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('admin.dashboard') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-primary">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-edit fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-locale">
                        <div class="huge"></div>
                        <div>{{ trans('article.articles') }}</div>
                    </div>
                </div>
            </div>
            <a href="{{ url(App::getLocale().'/admin/article/all') }}">
                <div class="panel-footer">
                    <span class="pull-left">{{ trans('article.see_all') }}</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-green">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-photo fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-locale">
                        <div class="huge"></div>
                        <div>Pictures</div>
                    </div>
                </div>
            </div>
            <a href="{{ url(App::getLocale().'/admin/picture/show/?id=all') }}">
                <div class="panel-footer">
                    <span class="pull-left">See All</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-yellow">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-users  fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-locale">
                        <div class="huge">124</div>
                        <div>Users</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">See All</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-3 col-md-6">
        <div class="panel panel-red">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-3">
                        <i class="fa fa-support fa-5x"></i>
                    </div>
                    <div class="col-xs-9 text-locale">
                        <div class="huge">13</div>
                        <div>Colleagues</div>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer">
                    <span class="pull-left">See All</span>
                    <span class="pull-right"><i class="fa fa-arrow-circle-right"></i></span>
                    <div class="clearfix"></div>
                </div>
            </a>
        </div>
    </div>
</div>
<!-- /.row -->
<div class="row">
</div>
<!-- /.row -->

   
@endsection