@extends('layouts.admin.main') 
@section('sidebar')
    @include('layouts.admin.sidebar',['_global_sidebar_array'=>$_global_sidebar_array]) 
@endsection 

@section('content')

    @include('admin.acl.tables.table1',[
        'user_role'    => 'super_user',
        'form_action'  => '/admin/food/add-new',
        'form_title'   => 'Add a New Food',
    ])

@endsection