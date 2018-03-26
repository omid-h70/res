@extends('layouts.admin.main')

@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection

@section('content')
    
    @include('admin.food.forms.add-new',[
        'action'       => 'edit_food',
        'form_action'  => '/admin/food/edit?id='.$food_id,
        'form_title'   => trans('food.edit_food'),
    ])

@endsection