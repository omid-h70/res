@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection
@section('content')
    
    @include('admin.food.tables.food-all',[
        'user_role'    => 'super_user',
        'form_action'  => '/admin/food/add-new',
    ])

    @include('layouts.main.paginations.template1', ['paginator' => $food_paginator])    
    
@endsection

