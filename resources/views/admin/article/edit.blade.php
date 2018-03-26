@extends('layouts.admin.main') 
@section('sidebar')
    @include('layouts.admin.sidebar',['_global_sidebar_array'=>$_global_sidebar_array]) 
@endsection 

@section('content')

    @include('admin.article.forms.addNewOrEdit',[
        'form_type'    => 'edit',
        'form_action'  => '/admin/article/edit',
        'form_title'   => trans('article.edit_article'),
    ])
    
@endsection