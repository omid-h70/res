@extends('layouts.admin.main')

@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection

@section('content')
    @include('admin.food.forms.add-new',[
        'action'       => 'save',
        'form_action'  => '/admin/food/add-new',
        'form_title'   => trans('food.add_new_food'),
    ])
@endsection
