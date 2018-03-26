@section('extra-includes')
    @parent
    <!-- include summernote css/js-->
    <link   href="{{ url('public/plugins/summer-note/dist/summernote.css') }}" rel="stylesheet">
    <script src="{{ url('public/plugins/summer-note/dist/summernote.min.js') }}"></script>
    <script type="text/javascript">
    $( document ).ready(function() {
        
        var summernote_id = '#summernote';
        
        $(summernote_id).summernote({
            height   : 300,             // set editor height
            minHeight: 300,             // set minimum height of editor
            maxHeight: 300,             // set maximum height of editor
            toolbar: [
              // [groupName, [list of button]]
              ['style', ['bold', 'italic', 'underline', 'clear']],
              ['font', ['strikethrough', 'superscript', 'subscript']],
              ['fontsize', ['fontsize']],
              ['color', ['color']],
              ['para', ['ul', 'ol', 'paragraph']],
              ['height', ['height']],
              ['picture', ['picture']],
            ],
            callbacks: {
                onImageUpload: function( files ) {
                   
                    //Default function base64 upload
                    //$(summernote_id).summernote('insertImages',files );
                    
                     // new version of onImageUpload only accepts one argument
                    // upload image to server 
                    // files[0] stores the file name
                    uploadPhoto(files[0], $(this) );


                }
            }
        });
        
        function uploadPhoto( files, textEditor ){
            
            data = new FormData();
            data.append("file",files);
            var url = "{{ url(App::getLocale().'/admin/article/add-new') }}";
            
            $.ajax({
                headers : {'X-CSRF-TOKEN' : $('meta[name="csrf-token"]').attr('content')},
                data: data,
                type:'POST',
                processData: false,//its necessary for using FormData javascript interface 
                contentType: false,//its necessary for using FormData javascript interface 
                url :url,
                success: function(data) {
                    
                    var base_url = "{{ url('public/images/articles/')}}";
                    var url = base_url.concat('/'+data.img_name);
                    
                    $(summernote_id).summernote('insertImage', url,function( image ){
                        image.css('width', image.width() / 3); 
                        image.attr('data-filename', 'retriever')
                        
                    });
                    console.log(url);
                }
                
            });
            
            function previewFile() {
                var preview = document.querySelector('img');
                var file    = document.querySelector('input[type=file]').files[0];
                var reader  = new FileReader();

                reader.addEventListener("load", function () {
                  preview.src = reader.result;
                }, false);

                if (file) {
                  reader.readAsDataURL(file);
                }
            }
            
            
        }
        
        
    });
    //exp::
    // var postForm = function() {
    //	var content = $('textarea[name="content"]').html($('#summernote').code());
    // S}
    </script>
@endsection 

<div class="row">
    <div class="col-lg-12">
        <h1 class="page-header">{{ $form_title }}</h1>
    </div><!-- /.col-lg-12 -->
</div><!-- /.row -->
<form id="add-article-form" role="form" method="post" action="{{ url(App::getLocale().$form_action ) }}" enctype="multipart/form-data" accept-charset="UTF-8">
    <input type="hidden" name="_token" value="{{ csrf_token() }}">
    @if( $form_type == 'edit')
        <input type="hidden" name="article_id" value="{{ !empty(old('article_id'))?old('article_id'):(!empty($article_id)?$article_id:'')  }}">
    @endif

    <div class="row">
        <?php  Helper::showErrors( $errors ); ?>
    </div>
    <div class="row">
        @if( isset( $SuccessArray ))
            <?php  Helper::showSuccess( $SuccessArray ); ?>
        @endif
    </div>
    <!-- edit it dude -->
    <div class="row">
        <div class="form-group">
            <div class="col-sm-3">
                <input name="article_title" placeholder="{{ trans('article.title') }}" type="text" class="form-control" value="{{ !empty(old('article_title'))?old('article_title'):(!empty($article_title)?$article_title:'')  }}">
            </div>
        </div>  
    </div>
    <br>
    <div class="row">
        <div class="form-group">
            <div class="col-md-12">
                <textarea  class="input-block-level"  form="add-article-form" id="summernote" name="article_body" placeholder="test">
                    {!! !empty(old('article_body'))?old('article_body'):(!empty($article_body)?$article_body:'')  !!}
                </textarea>
            </div>
        </div>
    </div>
    <div class="row" >
        <div class="col-sm-2">
           <button type="submit" value="submit" class="btn btn-success btn-block">{{ trans('food.save') }}</button>
        </div> 
        <div class="col-sm-1">
        </div>
        <div class="col-sm-2 col-sm-offset-1">
           <button type="reset" value="reset" class="btn btn-danger btn-block">{{ trans('food.reset') }}</button>
        </div> 
    </div>
    <br><br><br>
</form> 
  

