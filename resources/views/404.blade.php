@extends('layouts.main.main')
@section('content')
<div class="container documents">
    <div class="row">
        <div class="col-md-10 col-md-offset-1">
            <div class="panel panel-yellow">
                <div class="panel-heading">{{ trans('public.error') }} </div>
                <div class="panel-body">
                    {{ trans('public.404_error') }} 
                </div>
            </div>
        </div>
    </div>
</div>
@endsection