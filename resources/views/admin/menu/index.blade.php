@extends('ltr.layouts.admin.main')
@section('extra_scripts')
    <script src="{{ asset('public/js/sortable/jquery.sortable.min.js') }}"  type="text/javascript" ></script>
    <script src="{{ asset('public/js/sortable/jquery.sortable.js') }}"  type="text/javascript" ></script>
    <script type="text/javascript">
    $(document).ready(function(){
        $('.sortable').sortable();
    });
    </script>
@endsection
@section('extra_stylesheets')
    <link href="{{ asset('public/js/sortable/sortable.css') }}" rel="stylesheets" />
@endsection
@section('sidebar')
   @include('ltr.layouts.admin.left_sidebar')
@endsection
@section('content')
  
        <div class="row">
                <div class="col-lg-12">
                    <h1 class="page-header">Menu Controller</h1>
                </div>
                <!-- /.col-lg-12 -->
        </div>
        <div class="row">
            <div class="col-lg-12">
                    <ul class="sortable">
                        <li>Item 1
                        <li>Item 2
                        <li>Item 3
                        <li>Item 4
                    </ul>
            </div>
            <!-- /.col-lg-12 -->
        </div>
        
   
@endsection