@extends('ltr.layouts.admin.main')
@extends('ltr.layouts.admin.sidebar_left')
@section('extra_stylesheets')
<style type="text/css">
    .border{
    	border-radius: 10px 10px 10px 10px;
        -moz-border-radius: 10px 10px 10px 10px;
        -webkit-border-radius: 10px 10px 10px 10px;
        border: 2px dashed #000000;
    }
</style>
@endsection
@section('extra_scripts')
<script type="text/javascript">
    $('#myAlert').on('closed.bs.alert', function () {
      // do something…
    })
    $(document).ready( function(){

    	$("#level-one-add-item").click(function(){
        	 new_item = add_drop_down( 'one',"",'test');
   	   		 $("#level-one-container").append( new_item );	
        });
    	$("#level-two-add-item").click(function(){
    		 new_item = add_drop_down( 'two',"margin-left: 65px",'test_2');
   			 $("#level-two-container").append( new_item );	
      	});
    	$("#level-three-add-item").click(function(){
   		 $("#level-three-container").append( new_item );	
      	 });

    });

	 function add_drop_down( level, style, label_tag ){

		 var clear_fix="<div class='clearfix' ></div>"; 
		 console.log( level+style+label_tag);  
		 switch(level){
		 	case "one":
			 	id ="#level-one-add-item";
			 	var add_div = "<div class='border form-group col-md-6 col-md-offset-2'  style='padding-left: 75px;'> ";
				var add_btn = "<button type='button' class='btn btn-default' id='level-two-add-item' >Add +</button> ";
				var add_div_end ="</div>";
			 	array ="level-one[]";
			 	console.log('1');
			 	break;
		 	case "two":
		 		id ="#level-two-add-item"; 
		 		array ="level-two[parent-one][]";
		 		break;
		 	case "three":
		 		id ="#level-three-add-item";	
		 		array ="level-three[parent-one][parent-two][]";
		 		break;
		 }
		 		var container ="<div style='"+style+";' >";
		 		var div_one ="<div class='border form-group col-md-6 col-md-offset-2'  >";
		 		
    			var btn ="<button type='button' class='btn btn-default'>Default</button>";
    			var div_one_end = "</div>";
    			var	div_two = "<div class='form-group'>";
    			var label ="<label class='col-md-4  border'>"+label_tag+"</label>";
     			var div_three ="<div class='col-md-1'>";
    			var input = "<input type='hidden' class='form-control' name='"+array+"' value=\"\"> ";
    			var div_three_end="</div>";
    			var container_end ="</div>";
    
    			var new_item = container + div_one + btn + div_one_end + clear_fix + div_two + label +
    				div_three + input +div_three_end+ clear_fix+ add_div +add_btn +add_div_end +container_end;
				
    			return new_item;
		 
       	 
		
  	 };


    
</script>
@endsection
@section('content')

<div class="container-fluid">
	<div class="row">
		<div class="col-md-8 col-md-offset-2">
			<div class="panel panel-default">
				<div class="panel-heading">Menu Generator</div>
				<div class="panel-body">
					@if (count($errors) > 0)
						<div class="alert alert-danger">
							<strong>Whoops!</strong> There were some problems with your input.<br><br>
							<ul>
								@foreach ($errors->all() as $error)
									<li>{{ $error }}</li>
								@endforeach
							</ul>
						</div>
					@endif
				   
					<form class="form-horizontal" role="form" method="POST" action="{{ url(App::getLocale().'/register') }}">
						<input type="hidden" name="_token" value="{{ csrf_token() }}">
                        
                        <div id="level-one-container" class="border">
                            <div class="border form-group col-md-6 col-md-offset-2" style="" >
    						  <button type="button" class="btn btn-default" id="level-one-add-item" >Default</button>
    						</div>
    						<div class="clearfix" ></div>
    						<div class="form-group">
    							<label class="col-md-4  border">Name</label>
    							<div class="col-md-1">
    								<input type="hidden" class="form-control" name="name" value="{{ old('name') }}">
    							</div>
    						</div>
    						<div class="form-group col-md-6 col-md-offset-2"  style="padding-left: 75px;" >
    						  <button type="button" class="btn btn-default" id="level-two-add-item" >Add +</button>
    						</div>
    						<div class="clearfix" ></div>
						</div><!-- /level-one-container -->
						
						<div id="level-two-container">
    						
    						
    						
    						<div class="alert form-group border col-md-10" id="myAlert" style="margin-left: 65px;">
    						    
    						    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                  <span aria-hidden="true">&times;</span>
                                </button>
    							<label class="col-md-4 border ">E-Mail Address</label>
    							<div class="col-md-5">
    								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
    							</div>
    							
    						</div>
						</div>
						<div id="level-three-container">
    						<div class="border form-group col-md-6 col-md-offset-2" style="padding-left: 150px;" >
        						  <button type="button" class="btn btn-default">Default</button>
        				    </div>
                            <div class="clearfix" ></div>
                            
    						<div class="form-group border" style="margin-left: 135px;">
    							<label class="col-md-4  border">Level 3</label>
    							<div class="col-md-1">
    								<input type="email" class="form-control" name="email" value="{{ old('email') }}">
    							</div>
    						</div>
                        </div>
						<div class="form-group">
							<label class="col-md-4 control-label">Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password">
							</div>
						</div>

						<div class="form-group">
							<label class="col-md-4 control-label">Confirm Password</label>
							<div class="col-md-6">
								<input type="password" class="form-control" name="password_confirmation">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-6 col-md-offset-4">
								<button type="submit" class="btn btn-primary">
									Register
								</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>

@endsection


