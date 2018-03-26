@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection

@section('content')
<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ trans('sidebar.add_new_sidebar') }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
    <div class="col-lg-12">
        @include('admin.sidebar.panels.edit-sidebar',[
            'action'            => 'add_new',
            'panel_title'       => trans('sidebar.edit_sidebar') ,
            'send_url'          => url(App::getLocale().'/admin/sidebar/add-new') ,
            'sidebar_array'     => $sidebar_array, 
            'default_sidebar_url_array' => $default_sidebar_url_array
        ])
    </div>    
</div>    
@endsection