@section('extra-stylesheets') @parent
<style type="text/css">
    h1, h2, h3, h4, h5, h6, p ,li{ font-weight : normal;  }
</style>    
@endsection
@section('extra-scripts')
@parent
<script src="{{ asset( '/public/js/sortable/Sortable.js') }}"></script>
<script type="text/javascript">
    $( document ).ready(function() {
        
        /**************************Creating Sortable Lists**************************/
        
    	var container = document.getElementById("default-first-level-container");
        
        var sort = Sortable.create(container, {
          animation: 150, 
          handle: ".move-handle",
          //draggable:".draggable",
          group:{
              name:"first-level",
              put:["second-level","submit-sidebar"],
          },
          //ghostClass: ".sortable-home", 
          draggable: ".first-level",
          onUpdate: function (evt/**Event*/){
             var item = evt.item; // the current dragged HTMLElement
          },
          filter: '.no-drag, .js-remove .duplicate',
          onFilter: function (evt) {
              
            var item = evt.item;
            var ctrl = evt.target;
            
            if (Sortable.utils.is(ctrl, ".js-remove")) {  // Click on remove button
                var el = sort.closest(evt.item); // get dragged item
                el && el.parentNode.removeChild(el);
            }
          },
          sort: true,
        });

        $(".second-level-container").each( function(i){
            var id = $(this).attr('id');
            var container = document.getElementById( id );
            var sort = Sortable.create(container, {
                animation: 150, 
                group:{
                   name:"second-level",
                   put:["first-level","second-level"]
                },
                onUpdate: function (evt/**Event*/){
                   var item = evt.item; 
                },
                filter: '.js-remove', 
                onFilter: function (evt) {
                    var el = sort.closest(evt.item); // get dragged item
                    el && el.parentNode.removeChild(el);
                }
            });
        }); 

        var container = document.getElementById("submit-sidebar");
        var sort = Sortable.create(container, {
            animation: 150, 
            group:{
              name:"submit-sidebar",
              put:["first-level","second-level","t1","t2"]
            },
            onUpdate: function (evt/**Event*/){
              var item = evt.item; 
            },
            filter: '.js-remove', 
            onFilter: function (evt) {
                var el = sort.closest(evt.item); // get dragged item
                el && el.parentNode.removeChild(el);
                var target = evt.target ;
                var url_id = target.getAttribute('data-url-id');
                
                $('.duplicate').each( function(){
                    if($(this).data('url-id') == url_id){
                        $(this).removeClass('duplicate').addClass('first-level');
                        $(this).find('.fa-copy').removeClass('fa-copy')
                            .addClass('fa-arrows move-handle').css({'color':'green'});
                    }

                });
                
            },
            onEnd: function (/**Event*/evt) {
                
            },
        });



        /***************** Saving SideBar *********************/
        
        var url_array = [];
        var action = '{{ $action }}';
        
        $("#save-sidebar-btn").click( function(){
            
            $("#submit-sidebar li.first-level").each( function(){
                
                console.log( "Parent-"+$(this).data('url-id') );
                var temp = "ul.second-level-container li.second-level";
                var id  = $(this).data('url-id');
                
                var url= {
                    "url_id" : id,
                    "url_children":[] /*******define a property as an array***********/
                };
                
                
                if( $(this).find(temp).length > 0 ){
                    
                    $(this).find(temp).each( function(){

                        if( id == $(this).data('parent-url-id')){
                            console.log( "Children-"+ $(this).attr('data-url-id') );
                            var child_url = {
                                "url_id":$(this).attr('data-url-id'),
                            }
                            var temp = url.url_children ;
                            temp.push( child_url ); 
                        }
                        
                    } );

                }
                url_array.push ( url );

            } );

            
            $(".default-level").each( function(){
                console.log(  "Default-"+ $(this).attr('data-url-id') );
            });
            
            
            console.log( url_array );
            /******************Sending Submitted Data******************************/
            
            
            var data = {
                'action'        : '{{ $action }}',
                'sidebar_id'    :  function(){
                    if( $('input[name="sidebar_id"]').length > 0 ){
                        return $('input[name="sidebar_id"]').val();
                    }else{
                        return ;
                    }
                },
                'sidebar_title' : function(){
                    if( $('input[name="sidebar_title"]').length > 0 ){
                        return $('input[name="sidebar_title"]').val();
                    }else{
                        return ;
                    }
                },
                'url_array' : url_array
            };
            
            $.ajax({
                beforeSend:function(){
                    prepareToSend();
                },
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data    : data,
                dataType: 'json',

                error   : function() {
                    $('#info').html('<p>An error has occurred</p>');
                },	
                success: function(data) {
                    //$("#loading-spinner").addClass('hidden');
                    $("div#absolute-message-box > p#loading-spinner").addClass('hidden');

                    if( typeof data['sidebar_title'] !== 'undefined' ){

                        var error = $("div#absolute-message-box > p#message");
                        error.removeClass('hidden');
                        error.addClass("text-danger bg-danger alert")
                            .append(data['sidebar_title'] +'<br>' );


                    }else if( typeof data['no-error'] !== 'undefined' ){

                        var success = $("div#absolute-message-box > p#message");
                        success.removeClass('hidden');
                        success.css('border','1px solid green')
                            .addClass("text-success bg-success alert")
                            .append(data['no-error']+'<br>' );

                    }
                    $("div#absolute-message-box").fadeOut(1000);
                    if( action=='edit-sidebar')
                        location.reload(true);
                },
                type    : 'POST',
                url     : '{{ $send_url }}'

            });/***** ENDOF Ajax Request ****/
            
            
            
        });/***ENDOF Click Event****/
        
    });
</script>
@endsection

<div class="panel panel-default">
    <div class="panel-heading">{{ $panel_title }}</div>
    <!-- /.panel-heading -->
    <div class="row col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
        <div class="col-md-4 col-sm-4 col-xs-4"> 
            <h3>
                 {{ trans('sidebar.your_sidebar') }}
            </h3>
        </div>    
       
       <div class="col-md-4 col-sm-4 col-xs-4 col-xs-offset-2 col-sm-offset-2 col-md-offset-2" > 
            <h3>
                {{ trans('sidebar.available_links') }}<br>
                {{ trans('sidebar.drag_and_drop') }}
            </h3>
       </div>  
        
    </div>    
    <div class="row col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
        <div class="input-group col-md-4 col-sm-4 col-xs-4">
            <span class="input-group-addon"><i class="fa fa-edit fa-fw"></i></span>
            @if( !empty($sidebar_array['sidebar_id']) )
                <input type="hidden" name="sidebar_id" value="{{ $sidebar_array['sidebar_id'] }}">
            @endif
            
            @if( $action =='edit_sidebar')
                <input type="text" class="form-control" name="sidebar_title" value="{{ !empty($sidebar_array['sidebar_title'])? $sidebar_array['sidebar_title'] : old('sidebar_title') }}" style="" placeholder="SidebarTitle">
            @elseif ( $action =='add_new')
                <input type="text" class="form-control" name="sidebar_title"  style="" placeholder="{{ trans('sidebar.sidebar_title') }}">
            @endif
            
        </div>  
        <div class="col-md-4">
            
        </div> 
    </div>  
    <br><br>
    <div class="row col-xs-offset-1 col-sm-offset-1 col-md-offset-1">
        <ul id="submit-sidebar" class="list-group col-xs-4 col-sm-4 col-md-4 ">
            <li class="btn-default list-group-item default-level">
                <i aria-hidden="true" class="fa fa-link fa-fw" style="color:purple;" ></i>
                <strong>{{ trans('sidebar.result_sidebar') }}</strong>
            </li>

            @if( !empty($sidebar_url_array) )
                @foreach( $sidebar_url_array as $url)
                    <li class="btn-default list-group-item first-level" data-url-id="{{ $url['url_id'] }}" >

                        <a class="list-group" data-toggle="collapse"  data-target="{{ '#'.$url['url_id'] }}" aria-expanded="false" aria-controls="{{ $url['url_id'] }}" >
                            {{ !empty($url['url_title'])? trans($url['url_title']):$url['url_slug'] }}
                            <span class="fa fa-angle-down fa-fw pull-right"></span>
                            <i aria-hidden="true" data-url-id="{{ $url['url_id'] }}" class="fa fa-trash-o fa-fw fa-lg js-remove pull-right" style="color:red;"></i>
                        </a>
                        @if( !empty($url['children']) )
                            <ul class="second-level-container list-group collapse" id="{{ $url['url_id'] }}" data-parent-url-id="{{ $url['url_id'] }}" style="margin-top: 20px;">
                            @foreach( $url['children'] as $child_url)
                                <li class="list-group-item second-level" data-parent-url-id="{{ $url['url_id'] }}" data-url-id="{{ $child_url['url_id'] }}">   
                                   {{ !empty($child_url['url_title'])?trans($child_url['url_title']):$child_url['url_slug'] }}
                                   <i aria-hidden="true" class="fa fa-close fa-fw js-remove pull-right" style="color:red;"></i>
                                </li>
                            @endforeach
                            </ul>
                        @endif
                    </li>
                @endforeach
            @endif

        </ul>
        <div id="test" class="col-xs-4 col-sm-4 col-md-4 col-xs-offset-2 col-sm-offset-2 col-md-offset-2" >
            <ul class="list-group first-level-container sortable-home" id="default-first-level-container">
                <li class="btn-default list-group-item first-level">
                    <i aria-hidden="true" class="fa fa-link fa-fw" style="color:purple;" ></i>
                    <strong>{{ trans('sidebar.link_lists') }}</strong>
                </li>
                @foreach( $default_sidebar_url_array as $url)
                    <li class="btn-default list-group-item {{ !empty($url['selected'])?'duplicate':'first-level'}}" data-url-id="{{ $url['url_id'] }}"  >
                        <a class="list-group" data-toggle="collapse"  data-target="#default_{{ $url['url_id'] }}" aria-expanded="false" aria-controls="{{ $url['url_id'] }}" >
                            @if( !empty($url['selected']) )
                                <i aria-hidden="true" class="fa fa-copy fa-fw" style="color:red;"></i>
                            @else
                                <i aria-hidden="true" class="fa fa-arrows fa-fw move-handle"></i>
                            @endif
                            
                            {{ !empty($url['url_title'])?trans($url['url_title']):$url['url_slug'] }}
                            @if( !empty($url['children']) )
                                <span aria-hidden="true" class="fa fa-angle-down fa-fw pull-right"></span>
                            @endif
                            <i aria-hidden="true" data-url-id="{{ $url['url_id'] }}" class="fa fa-trash-o fa-fw fa-lg js-remove pull-right" style="color:red;"></i>
                        </a>
                        @if( !empty($url['children']) )
                          <ul class="second-level-container list-group collapse" id="default_{{ $url['url_id'] }}" data-parent-url-id="{{ $url['url_id'] }}" style="margin-top: 20px;">
                            @foreach( $url['children'] as $child_url)
                                <li class="list-group-item second-level" data-parent-url-id="{{ $url['url_id'] }}" data-url-id="{{ $child_url['url_id'] }}">   
                                   {{ !empty($child_url['url_title'])?trans($child_url['url_title']):$child_url['url_slug'] }}
                                   <i aria-hidden="true" class="fa fa-close fa-fw js-remove pull-right" style="color:red;"></i>
                                </li>
                            @endforeach
                            </ul>
                       @endif
                    </li>
                @endforeach
                
            </ul>
        </div>


    </div><!-- /.row -->
    <div class="pull-right">
        <button id="save-sidebar-btn" type="submit" value="submit" class="btn btn-success">
          {{ trans('sidebar.save') }}
          <i aria-hidden="true" class="fa fa-check fa-fw"></i> 
        </button>
    </div>
</div> <!-- /.panel-default -->