@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection
@section('content')
    
    @include('admin.article.tables.article-all',[

        'form_action'  => '/admin/article/add-new',
        
    ])

    @include('layouts.main.paginations.template1', ['paginator' => $article_paginator])    
    
@endsection

