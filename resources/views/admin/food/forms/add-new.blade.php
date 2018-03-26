@section('linked-stylesheets')
    @parent
    <!-----------------  bootstrap file  input --------------->
    <link rel="stylesheet" type="text/css" href="{{ asset( '/public/plugins/bootstrap-fileinput/css/fileinput.min.css') }}" />

    <!----------------- bootstrap tags input  --------------->
    <link rel="stylesheet" type="text/css" href="{{ asset( '/public/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput.css') }}" />
    <link rel="stylesheet" type="text/css" href="{{ asset( '/public/plugins/bootstrap-tagsinput/css/bootstrap-tagsinput-typeahead.css') }}" />
@endsection
@section('extra-scripts')
    @parent
    <!-----------------  bootstrap file  input --------------->
    <script src="{{ asset( '/public/plugins/bootstrap-fileinput/js/plugins/canvas-to-blob.min.js') }}" ></script>
    <script src="{{ asset( '/public/plugins/bootstrap-fileinput/js/fileinput.min.js') }}" ></script>
    <script src="{{ asset( '/public/plugins/bootstrap-fileinput/js/fileinput_locale_uk.js') }}" ></script>
    <script>
    $(document).ready( function(){
        
        var image_obj = {!! $image_json_obj !!} ;//Json Endcoded Data Sent from php
        var temp = new Array() ;

        //Adding an Extra Record for Testing 
        //temp.push("<img src='"+image_array+"' alt='DooDOOO' title='Desert'>"); 
        
        if( typeof image_obj.href != 'undefined' ){
            //image_obj.forEach( function( image , index ) {
                temp.push("<img src='"+image_obj.href+"' data-image-id='"+image_obj.id+"' alt='"+image_obj.title+"' title='"+image_obj.title+"'>");
            //})

        }
        //console.log( image_obj );
        //console.log( temp ); 

        $("#food-picture").fileinput({

            initialPreview: temp,
            previewFileType : "image",
            allowedFileExtention : ["jpg"],
            browserClass :"btn btn-primary btn-block",
            showUpload: false,

        });

    });

</script>
<!----------------- bootstrap tags input  --------------->
<script src="{{ asset( '/public/plugins/bootstrap-tagsinput/js/bootstrap-tagsinput.min.js') }}" ></script>
<script type="text/javascript">
    $( document ).ready(function(e) {

        $('.dropdown-menu input, .dropdown-menu label').click(function(e) {
            e.stopPropagation();
        });

        /***********Tags Input **********/
      
    	$('input#tags').tagsinput({
    	    tagClass: 'label label-primary big',
            cancelConfirmKeysOnEmpty: false
            /***Preventing Enter Key from Submitting the form***/
    	});

    	//console.log( "ready!" );
        
    	$("#add-category-btn").click( function( event ){
            event.preventDefault();

            // console.log( 'X-CSRF-TOKEN:' + $('meta[name="csrf-token"]').attr('content') );
            /*****************************************************/
            $("#save-category-btn").click( function( event ){
            	$.ajax({
                    beforeSend:function(){
                       // prepareToSend();
                    },
                    headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
            	    data: {
               	       'category_title' : $('input[id="add-category"]').val(),
               	       //'mama' :'kind'
               	    },
                    dataType: 'json',
        
                    error: function() {
                       $('#info').html('<p>An error has occurred</p>');
                    },	

                    success: function(data) {
                        if( typeof data['category_title'] !== 'undefined' ){
                            //console.log( '1' );
                            $("div#category-status-error").removeClass("hidden");
                            $("div#category-status-error p#error")
                                .append(data['category_title'] +'<br>' );
                            $("div#category-status-error span.close").click( function( event ){   
                                $("div#category-status-error").addClass("hidden");
                            });		

                        }else if( typeof data['no-error'] !== 'undefined' ){
                            //console.log( 'no Error' );
                            $("div#category-status-success ").removeClass("hidden");
                            $("div#category-status-success p#success")
                               .append(data['no-error']+'<br>' );
                            $("div#category-status-success span.close").click( function( event ){   
                                $("div#category-status-success").addClass("hidden");
                            });

                            if( typeof data['category_array'] !== 'undefined' ){

                                /*****insert newly added Category inside select tag****/

                                var category_array = data['category_array'];

                                for (i = 0; i<category_array.length; i++) { 

                                    var option = $('<option></option>').attr({
                                        'value': category_array[i]['category_slug'],
                                    }).text( category_array[i]['category_title'] );

                                    $("select[name='category_select']").append( option );
                                }


                            }
                        }	  

                        //console.log(  data );

                    },

                    type: 'POST',
                    url : "{{ url(App::getLocale().'/admin/food/add-new') }}",

                });
    	    });
    	});/***** ENDOF Click Event ****/

  	/* Preventing Modal from Opening */
    	$('div.bootstrap-tagsinput>input').focusin(function(event){
            $("#add-category-btn").removeAttr('data-target');
    	});

    	$('div.bootstrap-tagsinput>input').focusout(function(event){
            $("#add-category-btn").attr('data-target','#add-category-modal');
      	});

      	
    	/*********** **********/ 
    });
</script>
@endsection

@section('extra-stylesheets')
<style  type="text/css" >
textarea {
    resize: none;
}

#food-img{
    width: 100px;
    height: 100px;
    margin-left:15px;
}

.success-box{
    margin:25px;	
}

.hidden{
    display:none;	
}

</style>

@endsection

<div class="row">
    <div class="col-lg-12">
            <h1 class="page-header">{{ trans($form_title) }}</h1>
    </div>
    <!-- /.col-lg-12 -->
</div><!-- /.row -->
<form id="add-food-form" role="form" method="post" action="{{ url(App::getLocale().$form_action ) }}" enctype="multipart/form-data" accept-charset="UTF-8">
    
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if( $action == 'edit_food')
        <input type="hidden" name="food_id" value="{{ $food_id }}">
    @endif
    <div class="row">
        <?php  Helper::showErrors( $errors ); ?>
    </div>
    <div class="row">
        @if( isset( $SuccessArray ))
            <?php  Helper::showSuccess( $SuccessArray ); ?>
        @endif
    </div>
    <div class="row">

    </div>
    <div class="row">
        <div class="form-group">

            <div class="col-sm-3">
                <input name="food_title" placeholder="{{ trans('food.title') }}" type="text" class="form-control" value="{{ !empty(old('food_title'))?old('food_title'):(!empty($food_title)?$food_title:'')  }}">
            </div>

            <div class="col-sm-4">
                 <label class="" for="status" >
                     @if( isset( $food_status ) )
                        <input id="status" class="" type="checkbox" name="food_status"  {{ $food_status==$NORMAL_STATUS ? 'checked' : '' }} value="{{ $NORMAL_STATUS }}"> 
                        {{ trans('food.publish') }}
                     @else
                        <input id="status" class="" type="checkbox" name="food_status" checked value="{{ $NORMAL_STATUS }}" > 
                        {{ trans('food.publish') }}
                     @endif
                 </label>

            </div>

        </div>          
    </div><!-- /.row -->
    <br><br>
    <div class="row">
        
        <div class="form-group">

            <div class="col-sm-3">
                <input name="food_price" placeholder="{{ trans('food.price') }}" type="text" class="form-control" value="{{ !empty(old('food_price'))?old('food_price'):(!empty($food_price)?$food_price:'') }}">
            </div>

       </div>
    </div><!-- /.row -->  
    <br><br> 
    <div class="row">
        <div class="form-group">
            <div class="col-sm-2">
                <select name="category_select" form="add-food-form" class="form-control">
                    
                    <option value="none"  > {{ trans('food.category') }} </option>
                    
                    @if( !empty($category_array ) )
                        @foreach( $category_array as $category)
                          <option  value="{{ $category['category_slug'] }}" {{ array_key_exists('selected',$category)?'selected':'' }}>{{ $category['category_title'] }}</option>
                        @endforeach
                    @endif

                </select>
            </div>
            <div class="col-sm-1">
                <a id="add-category-btn" class="btn btn-default btn-block" data-toggle="modal" data-target="#add-category-modal">
                   <i class="fa fa-plus fa-fw" class="close"></i> 
                </a>
            </div>
            <!-- Modal -->
                @include('admin.food.modals.add-food-category')
            <!-- End Of Modal -->

            <div class="col-sm-4">
                <input id="tags" rows="4" cols="50" type="text" name="tag_array" class="form-control" placeholder="{{ trans('food.tags') }}" value="{{ !empty(old('tag_array'))?old('tag_array'):(!empty($tag_array)?$tag_array:'')  }}">
            </div>
        </div>
    </div>

    <br><br>
    
     <div class="row" >
        <div class="form-group">
            <div class="col-md-6">
                <label class="control-label" ></label>
                <input id="food-picture" class="file-loading" name="picture_input" type="file" >
            </div>
        </div>
    </div>
    <br><br>
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3">
                <div class="dropdown">
                    <button class="btn btn-default" id="dLabel" type="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        {{ trans('food.week_days') }}
                        <span class="caret"></span>
                    </button>
                    <ul class="dropdown-menu" aria-labelledby="dLabel">
                        <li>    
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['everyday'] )?'checked':'' }} value="everyday" class="status" type="checkbox"  value="everyday" name="day_array[]">
                                    {{ trans('food.everyday') }}
                            </label>
                        </li> 
                        <li> 
                            <label  for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['saturday'] )?'checked':'' }} value="saturday" id="status" class="status" type="checkbox"  name="day_array[]"> 
                                    {{ trans('food.saturday') }}
                            </label>
                        </li>
                        <li> 
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['sunday'] )?'checked':'' }} value="sunday" class="status" type="checkbox" name="day_array[]"> 
                                    {{ trans('food.sunday') }}
                            </label>
                        </li>
                        <li> 
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['monday'] )?'checked':'' }} value="monday" class="status" type="checkbox" name="day_array[]"> 
                                    {{ trans('food.monday') }}
                            </label>
                        </li>    
                        <li>     
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['tuesday'] )?'checked':'' }} value="tuesday" class="status" type="checkbox" name="day_array[]"> 
                                    {{ trans('food.tuesday') }}
                            </label>
                        </li>    
                        <li>     
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['wednesday'] )?'checked':'' }} value="wednesday" class="status" type="checkbox" name="day_array[]"> 
                                    {{ trans('food.wednesday') }}
                            </label>
                        </li>    
                        <li>     
                            <label class="" for="day_array[]" >
                                &nbsp;&nbsp;&nbsp;
                                <input {{ isset( $time_array['thursday'] )?'checked':'' }} value="thursday" class="status" type="checkbox" name="day_array[]"> 
                                    {{ trans('food.thursday') }}
                            </label>
                        </li>     
                    </ul>        
                </div>   
            </div>
            <div class="col-sm-4">
               <button class="btn btn-default">{{ trans('food.advanced_options') }}</button>
            </div>
        </div>
    </div>
    
    <br><br><br><br>

    <div class="row" >
       <div class="col-sm-2">
          <button type="submit" value="submit" class="btn btn-success btn-block">{{ trans('food.save') }}</button>
       </div> 
       <div class="col-sm-1">
       </div>
       <div class="col-sm-2">
          <button type="reset" value="reset" class="btn btn-danger btn-block">{{ trans('food.reset') }}</button>
       </div> 
    </div>
    <br><br><br>
</form>

