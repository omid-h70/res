@extends('layouts.main.setup')

@section('extra-scripts')
    @parent
    <script type="text/javascript">
                    
        var setup_url = "{{ url(App::getLocale().'/setup') }}";
        var home = "{{ url(App::getLocale().'/') }}";
        $( document ).ready(function() {  
            $.ajax({
                beforeSend:function(){

                },
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action':'create_db',
                },
                dataType: 'json',
                type: 'POST',
                url:setup_url ,
                success: function(data){
                    if( typeof data['no-error'] !== 'undefined' ){
                        createMigration();
                        $('#setup-progressbar').attr('aria-valuenow','30').css('width','30%');
                    }
                }
            });
        }); /****** End Of Document.Ready**********/   
        
        function createMigration(){
                
            $.ajax({
                beforeSend:function(){

                },
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action' :'create_migration',
                },
                dataType: 'json',
                type: 'POST',
                url: setup_url,
                success: function(data){
                    if( typeof data['no-error'] !== 'undefined' ){
                        seedDataBase();
                        $('#setup-progressbar').attr('aria-valuenow','60').css('width','60%');
                    }
                }
            });
        }

        function seedDataBase(){

            $.ajax({
                beforeSend:function(){

                },
                headers : {"X-CSRF-TOKEN" : $('meta[name="csrf-token"]').attr('content')},
                data: {
                    'action':'db_seed',
                },
                dataType: 'json',
                type: 'POST',
                url: setup_url,
                success: function(data){
                    if( typeof data['no-error'] !== 'undefined' ){
                        $('#setup-progressbar').attr('aria-valuenow','100').css('width','100%');
                        $('#response>div').html(""+data['no-error']+"").css('color','green');
                        window.location = home;
                    }
                }
            });
        }
        
    </script>
@endsection      

@section('content')
    <div class="main main-raised" style="margin-top:-260px;">
        <div class="container documents">
            <div class="row">
                <div id="response" class="col-md-8 col-md-offset-2">
                    <h2 class="text-center">{{ trans('public.setup')}}...</h2>
                    <div class="text-center description">
                       {{ trans('public.please_wait')}}...
                    </div>
                </div>    
            </div>
            <br><br>
            <div class="row">
                <div class="col-md-12">
                    <div class="progress progress-striped active" style="height:14px;">
                      <div class="progress-bar progress-bar-danger" id="setup-progressbar" role="progressbar" style="float:left; width:0%;" aria-valuenow="00" aria-valuemin="0" aria-valuemax="100">
                        <span class="sr-only"></span>
                      </div>
                    </div>
                </div>
            </div>    
        </div>    
    </div>    
@endsection
