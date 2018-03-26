@extends('layouts.admin.main')
@section('sidebar')
   @include('layouts.admin.sidebar')
@endsection
@section('extra-scripts')
<script type="text/javascript">
    $( document ).ready(function() {
    	console.log( "ready!" );
    	
    });
</script>
@endsection
@section('content')
<div class="row">
	<div class="col-lg-12">
		<h1 class="page-header">SideBars Index</h1>
	</div>
	<!-- /.col-lg-12 -->
</div>
<!-- /.row -->
<div class="row">
	<div class="col-lg-12">
		<div class="panel panel-default">
			<div class="panel-heading">List Of SideBars</div>
			<!-- /.panel-heading -->

			

		</div> <!-- /.panel-default -->
		
	</div><!-- /.col-lg-12 -->
</div><!-- /.row -->
@endsection